<?php

namespace App\Services;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentAuditRecord;
use App\Models\PaymentTransaction;
use App\Models\PaymentWebhook;
use App\Models\Refund;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Persistent payment-domain operations. This service deliberately does not
 * create orders or mark an attempt successful without gateway verification.
 */
class PaymentService
{
    public function __construct(private readonly PaymentGatewayInterface $gateway)
    {
    }

    public function createPayment(User $customer, string $amount, string $currency, string $method, array $orderIds = [], ?string $idempotencyKey = null): Payment
    {
        if ((float) $amount <= 0) {
            throw new InvalidArgumentException('Payment amount must be greater than zero.');
        }

        return DB::transaction(function () use ($customer, $amount, $currency, $method, $orderIds, $idempotencyKey) {
            if ($idempotencyKey && ($existing = Payment::where('idempotency_key', $idempotencyKey)->first())) {
                return $existing;
            }

            $orders = Order::query()
                ->where('user_id', $customer->id)
                ->whereIn('id', array_map('intval', $orderIds))
                ->get();

            if ($orders->count() !== count(array_unique(array_map('intval', $orderIds)))) {
                throw new InvalidArgumentException('A payment can only be linked to this customer\'s orders.');
            }

            $payment = Payment::create([
                'user_id' => $customer->id,
                'gateway' => 'razorpay',
                'payment_method' => $method,
                'status' => 'pending',
                'amount' => $amount,
                'currency' => strtoupper($currency),
                'idempotency_key' => $idempotencyKey,
            ]);

            $payment->orders()->sync($orders->modelKeys());
            $this->audit($payment, null, $customer->id, 'payment.created', null, 'pending');

            return $payment;
        });
    }

    public function initiatePayment(Payment $payment, array $itemsSnapshot, array $customerDetails): PaymentTransaction
    {
        $attempt = DB::transaction(function () use ($payment, $itemsSnapshot, $customerDetails) {
            $attempt = PaymentTransaction::create([
                'payment_id' => $payment->id,
                'user_id' => $payment->user_id,
                'access_token' => Str::random(80),
                'gateway' => $payment->gateway,
                'payment_method' => $payment->payment_method,
                'status' => 'pending',
                'amount' => $payment->amount,
                'amount_paise' => (int) round(((float) $payment->amount) * 100),
                'currency' => $payment->currency,
                'items_snapshot' => $itemsSnapshot,
                'customer_details' => $customerDetails,
                'order_ids' => $payment->orders()->pluck('orders.id')->all(),
                'attempt_number' => $payment->transactions()->count() + 1,
                'initiated_at' => now(),
                'expires_at' => now()->addMinutes(30),
            ]);

            $this->audit($payment, $attempt, $payment->user_id, 'payment.initiated', null, 'pending');

            return $attempt;
        });

        $gatewayOrder = $this->gateway->createOrder($attempt);
        if (! ($gatewayOrder['success'] ?? false)) {
            $attempt->update(['status' => 'failed', 'failure_reason' => $gatewayOrder['message'] ?? 'Gateway initiation failed.']);
            $this->audit($payment, $attempt, $payment->user_id, 'payment.initiation_failed', 'pending', 'failed');

            return $attempt->fresh();
        }

        $attempt->update(['gateway_order_id' => $gatewayOrder['gateway_order_id'], 'status' => 'processing']);
        $this->audit($payment, $attempt, $payment->user_id, 'payment.gateway_order_created', 'pending', 'processing');

        return $attempt->fresh();
    }

    public function verifyPayment(PaymentTransaction $attempt, string $gatewayPaymentId, string $signature): bool
    {
        if (! $attempt->payment || ! $attempt->gateway_order_id || ! $this->gateway->verifySignature($attempt->gateway_order_id, $gatewayPaymentId, $signature)) {
            return false;
        }

        $gatewayPayment = $this->gateway->fetchPayment($gatewayPaymentId);
        if (! ($gatewayPayment['success'] ?? false)
            || ! in_array($gatewayPayment['status'] ?? null, ['authorized', 'captured'], true)
            || ($gatewayPayment['order_id'] ?? null) !== $attempt->gateway_order_id
            || ($gatewayPayment['currency'] ?? null) !== $attempt->currency
            || (int) ($gatewayPayment['amount'] ?? 0) !== (int) $attempt->amount_paise) {
            return false;
        }

        DB::transaction(function () use ($attempt, $gatewayPaymentId, $signature) {
            $locked = PaymentTransaction::lockForUpdate()->findOrFail($attempt->id);
            if ($locked->status === 'paid') {
                return;
            }

            $locked->update([
                'status' => 'paid', 'gateway_payment_id' => $gatewayPaymentId,
                'gateway_signature' => $signature, 'verified_at' => now(), 'completed_at' => now(),
            ]);
            $locked->payment->update(['status' => 'paid', 'gateway_reference' => $gatewayPaymentId, 'captured_at' => now()]);
            $this->audit($locked->payment, $locked, $locked->user_id, 'payment.verified', $attempt->status, 'paid');
        });

        return true;
    }

    public function processWebhook(string $gateway, string $eventId, string $eventType, string $rawPayload, string $signature, array $headers = [], ?Payment $payment = null): ?PaymentWebhook
    {
        if (! $this->gateway->verifyWebhookSignature($rawPayload, $signature)) {
            return null;
        }

        $payload = json_decode($rawPayload, true);
        if (! is_array($payload)) {
            throw new InvalidArgumentException('Webhook payload must contain valid JSON.');
        }

        return PaymentWebhook::firstOrCreate(
            ['gateway' => $gateway, 'gateway_event_id' => $eventId],
            ['payment_id' => $payment?->id, 'event_type' => $eventType, 'status' => 'received', 'payload' => $this->redact($payload), 'headers' => $this->redact($headers)]
        );
    }

    public function refundPayment(Payment $payment, PaymentTransaction $attempt, string $amount, ?Order $order = null, ?string $reason = null): Refund
    {
        if ($attempt->payment_id !== $payment->id || (float) $amount <= 0 || (float) $amount > (float) $payment->amount) {
            throw new InvalidArgumentException('The refund request is not valid for this payment.');
        }

        if ($order && ! $payment->orders()->whereKey($order->id)->exists()) {
            throw new InvalidArgumentException('The order is not linked to this payment.');
        }

        $result = $this->gateway->createRefund($attempt, $amount);
        $refund = Refund::create([
            'payment_id' => $payment->id, 'payment_transaction_id' => $attempt->id, 'order_id' => $order?->id,
            'user_id' => $payment->user_id, 'amount' => $amount, 'currency' => $payment->currency,
            'status' => ($result['success'] ?? false) ? ($result['status'] ?? 'requested') : 'failed',
            'gateway_refund_id' => $result['gateway_refund_id'] ?? null, 'reason' => $reason,
            'requested_at' => now(), 'failed_at' => ($result['success'] ?? false) ? null : now(),
        ]);
        $this->audit($payment, $attempt, $payment->user_id, 'refund.requested', null, $refund->status);

        return $refund;
    }

    private function audit(Payment $payment, ?PaymentTransaction $attempt, ?int $userId, string $event, ?string $from, ?string $to): void
    {
        PaymentAuditRecord::create(['payment_id' => $payment->id, 'payment_transaction_id' => $attempt?->id, 'user_id' => $userId, 'event' => $event, 'from_status' => $from, 'to_status' => $to]);
    }

    private function redact(array $values): array
    {
        return collect($values)->map(function ($value, $key) {
            if (preg_match('/cvv|pin|password|secret|card.?number/i', (string) $key)) return '[redacted]';
            return is_array($value) ? $this->redact($value) : $value;
        })->all();
    }
}
