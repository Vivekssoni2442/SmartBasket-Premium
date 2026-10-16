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
        $amountPaise = $this->toMinorUnits($amount);
        if ($amountPaise <= 0) {
            throw new InvalidArgumentException('Payment amount must be greater than zero.');
        }

        $amount = $this->formatMinorUnits($amountPaise);

        return DB::transaction(function () use ($customer, $amount, $currency, $method, $orderIds, $idempotencyKey) {
            if ($idempotencyKey && ($existing = Payment::where('idempotency_key', $idempotencyKey)->first())) {
                if ((int) $existing->user_id !== (int) $customer->id
                    || $existing->amount !== $amount
                    || strtoupper($existing->payment_method) !== strtoupper($method)
                    || strtoupper($existing->currency) !== strtoupper($currency)) {
                    throw new InvalidArgumentException('The idempotency key was already used for a different payment.');
                }

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
            $lockedPayment = Payment::whereKey($payment->id)->lockForUpdate()->firstOrFail();
            if ($lockedPayment->status === 'paid') {
                throw new InvalidArgumentException('A paid transaction cannot be initiated again.');
            }

            $activeAttempt = $lockedPayment->transactions()
                ->whereIn('status', ['pending', 'processing'])
                ->where('expires_at', '>', now())
                ->latest('id')
                ->lockForUpdate()
                ->first();
            if ($activeAttempt) {
                return $activeAttempt;
            }

            $previousAttempts = $lockedPayment->transactions()->orderBy('id')->lockForUpdate()->get();
            $rootTransactionId = $previousAttempts->first()?->root_transaction_id
                ?: $previousAttempts->first()?->id;

            $attempt = PaymentTransaction::create([
                'payment_id' => $lockedPayment->id,
                'root_transaction_id' => $rootTransactionId,
                'user_id' => $lockedPayment->user_id,
                'access_token' => Str::random(80),
                'gateway' => $lockedPayment->gateway,
                'payment_method' => $lockedPayment->payment_method,
                'status' => 'pending',
                'amount' => $lockedPayment->amount,
                'amount_paise' => $this->toMinorUnits((string) $lockedPayment->amount),
                'currency' => $lockedPayment->currency,
                'items_snapshot' => $itemsSnapshot,
                'customer_details' => $customerDetails,
                'order_ids' => $lockedPayment->orders()->pluck('orders.id')->all(),
                'attempt_number' => ((int) $previousAttempts->max('attempt_number')) + 1,
                'initiated_at' => now(),
                'expires_at' => now()->addMinutes(30),
            ]);

            $this->audit($lockedPayment, $attempt, $lockedPayment->user_id, 'payment.initiated', null, 'pending');

            return $attempt;
        });

        if ($attempt->gateway_order_id && $attempt->status === 'processing') {
            return $attempt;
        }

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
            || ($gatewayPayment['status'] ?? null) !== 'captured'
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

    public function refundPayment(
        Payment $payment,
        PaymentTransaction $attempt,
        string $amount,
        ?Order $order = null,
        ?string $reason = null,
        ?string $idempotencyKey = null
    ): Refund
    {
        $amountPaise = $this->toMinorUnits($amount);
        if ($attempt->payment_id !== $payment->id
            || $attempt->status !== 'paid'
            || ! filled($attempt->gateway_payment_id)
            || $amountPaise <= 0
            || ! in_array($payment->status, ['paid', 'partially_refunded'], true)) {
            throw new InvalidArgumentException('The refund request is not valid for this payment.');
        }

        if ($order && ! $payment->orders()->whereKey($order->id)->exists()) {
            throw new InvalidArgumentException('The order is not linked to this payment.');
        }

        $idempotencyKey ??= (string) Str::uuid();
        $amount = $this->formatMinorUnits($amountPaise);

        [$refund, $shouldCallProvider] = DB::transaction(function () use ($payment, $attempt, $order, $reason, $idempotencyKey, $amount, $amountPaise) {
            $lockedPayment = Payment::whereKey($payment->id)->lockForUpdate()->firstOrFail();
            $existing = Refund::where('idempotency_key', $idempotencyKey)->first();
            if ($existing) {
                if ($existing->payment_id !== $lockedPayment->id
                    || $existing->payment_transaction_id !== $attempt->id
                    || $this->toMinorUnits((string) $existing->amount) !== $amountPaise) {
                    throw new InvalidArgumentException('The refund idempotency key was already used for a different request.');
                }

                return [$existing, false];
            }

            $reservedPaise = Refund::where('payment_id', $lockedPayment->id)
                ->where('status', '!=', 'failed')
                ->get(['amount'])
                ->sum(fn (Refund $refund) => $this->toMinorUnits((string) $refund->amount));
            $paymentPaise = $this->toMinorUnits((string) $lockedPayment->amount);
            if ($amountPaise + $reservedPaise > $paymentPaise) {
                throw new InvalidArgumentException('Refund amount exceeds the remaining refundable balance.');
            }

            $refund = Refund::create([
                'payment_id' => $lockedPayment->id,
                'payment_transaction_id' => $attempt->id,
                'order_id' => $order?->id,
                'user_id' => $lockedPayment->user_id,
                'seller_id' => $order?->seller_id,
                'idempotency_key' => $idempotencyKey,
                'amount' => $amount,
                'currency' => $lockedPayment->currency,
                'status' => 'processing',
                'reason' => $reason,
                'requested_at' => now(),
            ]);
            $this->audit($lockedPayment, $attempt, $lockedPayment->user_id, 'refund.initiated', null, 'processing');

            return [$refund, true];
        });

        if (! $shouldCallProvider) {
            return $refund;
        }

        $result = $this->gateway->createRefund($attempt, $amount);
        if (! ($result['success'] ?? false)) {
            $refund->update([
                'status' => 'failed',
                'reason' => $reason ?: ($result['message'] ?? 'The provider could not create this refund.'),
                'failed_at' => now(),
            ]);
            $this->audit($payment, $attempt, $payment->user_id, 'refund.failed', 'processing', 'failed');

            return $refund->fresh();
        }

        $refund->update([
            'gateway_refund_id' => $result['gateway_refund_id'] ?? null,
            'status' => 'pending',
            'metadata' => ['provider_status' => $result['status'] ?? 'pending'],
        ]);
        $this->audit($payment, $attempt, $payment->user_id, 'refund.provider_accepted', 'processing', 'pending');

        return $refund->fresh();
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

    private function toMinorUnits(string $amount): int
    {
        if (! preg_match('/^(\d+)(?:\.(\d{1,2}))?$/', $amount, $matches)) {
            throw new InvalidArgumentException('Payment amounts must use INR with no more than two decimal places.');
        }

        return ((int) $matches[1] * 100) + (int) str_pad($matches[2] ?? '', 2, '0');
    }

    private function formatMinorUnits(int $amount): string
    {
        return intdiv($amount, 100) . '.' . str_pad((string) ($amount % 100), 2, '0', STR_PAD_LEFT);
    }
}
