<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\PaymentWebhook;
use App\Models\PaymentAuditRecord;
use App\Models\Refund;
use App\Models\Order;
use App\Models\OrderReturnRequest;
use App\Models\Product;
use App\Services\CheckoutOrderService;
use App\Services\RazorpayPaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = PaymentTransaction::query()
            ->where('user_id', $request->user()->id)
            ->with('refunds')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->string('search')->toString());
                $query->where(function ($payments) use ($search) {
                    $payments->where('id', $search)
                        ->orWhere('gateway_payment_id', 'like', "%{$search}%")
                        ->orWhere('gateway_transaction_id', 'like', "%{$search}%")
                        ->orWhere('gateway_order_id', 'like', "%{$search}%")
                        ->orWhereJsonContains('order_ids', (int) preg_replace('/\\D/', '', $search));
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->when($request->filled('date'), fn ($query) => $query->whereDate('created_at', $request->date('date')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('payments.index', compact('payments'));
    }

    public function show(PaymentTransaction $payment)
    {
        abort_unless($payment->isAccessibleByCurrentSession(), 403);

        if ($payment->expires_at?->isPast() && in_array($payment->status, ['pending', 'processing'], true)) {
            $payment->update([
                'status' => 'expired',
                'failure_reason' => 'Payment session expired.',
            ]);
        }

        return view('payments.show', [
            'payment' => $payment,
            'razorpayKey' => config('services.razorpay.key'),
            'gatewayReady' => app(RazorpayPaymentGateway::class)->isConfigured()
                && filled($payment->gateway_order_id)
                && in_array($payment->status, ['pending', 'processing'], true)
                && empty($payment->order_ids),
        ]);
    }

    /** Start a new gateway attempt for the existing checkout transaction. */
    public function retry(Request $request, PaymentTransaction $payment, RazorpayPaymentGateway $gateway)
    {
        abort_unless($payment->isAccessibleByCurrentSession(), 403);

        $payment = DB::transaction(function () use ($payment) {
            $locked = PaymentTransaction::whereKey($payment->id)->lockForUpdate()->firstOrFail();

            abort_if($locked->status === 'paid' || ! empty($locked->order_ids), 422, 'This payment has already created an order and cannot be retried.');
            abort_unless(in_array($locked->status, ['failed', 'cancelled', 'expired'], true), 422, 'This payment cannot be retried.');

            $rootId = $locked->root_transaction_id ?: $locked->id;
            $attempts = PaymentTransaction::where(function ($query) use ($rootId) {
                $query->whereKey($rootId)->orWhere('root_transaction_id', $rootId);
            })->orderBy('id')->lockForUpdate()->get();

            abort_if($attempts->contains(fn ($attempt) => in_array($attempt->status, ['pending', 'processing'], true)), 422, 'An active payment attempt already exists.');

            $nextAttemptNumber = ((int) $attempts->max('attempt_number')) + 1;

            $retry = PaymentTransaction::create([
                'payment_id' => $locked->payment_id,
                'root_transaction_id' => $rootId,
                'user_id' => $locked->user_id,
                'access_token' => Str::random(64),
                'gateway' => $locked->gateway,
                'payment_method' => $locked->payment_method,
                'status' => 'pending',
                'amount' => $locked->amount,
                'amount_paise' => $locked->amount_paise,
                'currency' => $locked->currency,
                'items_snapshot' => $locked->items_snapshot,
                'customer_details' => $locked->customer_details,
                'order_ids' => [],
                'attempt_number' => $nextAttemptNumber,
                'transaction_type' => $locked->transaction_type,
                'expires_at' => now()->addMinutes(30),
                'initiated_at' => now(),
            ]);

            session(['payment_transaction_token.' . $retry->id => $retry->access_token]);

            return $retry;
        });

        $gatewayOrder = $gateway->createOrder($payment);

        if (! $gatewayOrder['success']) {
            $payment->update(['status' => 'failed', 'failure_reason' => $gatewayOrder['message']]);

            return redirect()->route('payments.show', $payment)->with('error', $gatewayOrder['message']);
        }

        $payment->update([
            'gateway_order_id' => $gatewayOrder['gateway_order_id'],
            'status' => 'processing',
            'attempt_number' => ((int) $payment->attempt_number) + 1,
            'initiated_at' => now(),
        ]);

        return redirect()->route('payments.show', $payment)->with('success', 'Your secure payment session is ready.');
    }

    public function receipt(PaymentTransaction $payment)
    {
        abort_unless($payment->isAccessibleByCurrentSession(), 403);

        $orders = Order::query()
            ->where('user_id', auth()->id())
            ->whereIn('id', collect($payment->order_ids ?? [])->map(fn ($id) => (int) $id))
            ->with('seller')
            ->get();

        $products = Product::whereIn('id', $orders->flatMap(fn ($order) => collect($order->items ?? [])->pluck('product_id'))->filter()->unique())
            ->get()->keyBy('id');

        return view('payments.receipt', compact('payment', 'orders', 'products'));
    }

    public function verify(Request $request, PaymentTransaction $payment, RazorpayPaymentGateway $gateway, CheckoutOrderService $orders)
    {
        abort_unless($payment->isAccessibleByCurrentSession(), 403);

        if ($payment->expires_at?->isPast() && $payment->status !== 'paid') {
            $payment->update(['status' => 'expired', 'failure_reason' => 'Payment session expired.']);

            return $this->jsonFailure('This payment session has expired. Please start checkout again.', 422);
        }

        $validated = $request->validate([
            'razorpay_payment_id' => ['required', 'string', 'max:255'],
            'razorpay_order_id' => ['required', 'string', 'max:255'],
            'razorpay_signature' => ['required', 'string', 'max:255'],
        ]);

        if (! $gateway->isConfigured()) {
            return $this->jsonFailure('Online payment gateway is not configured.', 503);
        }

        if ($payment->gateway_order_id !== $validated['razorpay_order_id']) {
            Log::warning('Payment verification supplied a mismatched gateway order ID.', ['payment_transaction_id' => $payment->id]);
            return $this->jsonFailure('Payment verification failed.', 422);
        }

        if (! $gateway->verifySignature($validated['razorpay_order_id'], $validated['razorpay_payment_id'], $validated['razorpay_signature'])) {
            Log::warning('Payment verification supplied an invalid gateway signature.', ['payment_transaction_id' => $payment->id]);
            return $this->jsonFailure('Payment verification failed.', 422);
        }

        $gatewayPayment = $gateway->fetchPayment($validated['razorpay_payment_id']);
        if (! $gatewayPayment['success']) {
            return $this->jsonFailure($gatewayPayment['message'], 502);
        }

        if (($gatewayPayment['order_id'] ?? null) !== $payment->gateway_order_id
            || ($gatewayPayment['currency'] ?? null) !== $payment->currency
            || (int) ($gatewayPayment['amount'] ?? 0) !== (int) $payment->amount_paise) {
            $responseMetadata = $payment->response_metadata ?? [];
            $responseMetadata['provider_verification'] = [
                'payment_id' => $validated['razorpay_payment_id'],
                'order_id' => $gatewayPayment['order_id'] ?? null,
                'amount' => $gatewayPayment['amount'] ?? null,
                'currency' => $gatewayPayment['currency'] ?? null,
                'status' => $gatewayPayment['status'] ?? null,
            ];
            $payment->update([
                'status' => 'amount_mismatch',
                'gateway_payment_id' => $validated['razorpay_payment_id'],
                'failure_reason' => 'Gateway amount, currency, or order mismatch.',
                'response_metadata' => $responseMetadata,
            ]);
            return $this->jsonFailure('Payment amount verification failed.', 422);
        }

        if (($gatewayPayment['status'] ?? '') !== 'captured') {
            if (($gatewayPayment['status'] ?? '') === 'failed') {
                $this->markFailed($payment, 'The payment provider reported a failed payment.');

                return $this->jsonFailure('The payment was not completed.', 422);
            }

            $payment->forceFill([
                'status' => 'processing',
                'failure_reason' => 'Gateway status: ' . ($gatewayPayment['status'] ?? 'unknown'),
            ])->save();

            return $this->jsonFailure('Payment is pending. Please wait or retry.', 202, 'pending');
        }

        try {
            $orderIds = DB::transaction(function () use ($payment, $orders, $validated) {
                $locked = PaymentTransaction::whereKey($payment->id)->lockForUpdate()->firstOrFail();

                if ($locked->status === 'paid' && ! empty($locked->order_ids)) {
                    return $locked->order_ids;
                }

                if (! in_array($locked->status, ['pending', 'processing'], true)) {
                    throw new \RuntimeException('This payment can no longer be confirmed.');
                }

                $orderIds = $orders->createConfirmedOrders(
                    $locked->items_snapshot,
                    $locked->customer_details,
                    $locked->user_id,
                    $locked->payment_method,
                    'Paid'
                );

                $locked->update([
                    'status' => 'paid',
                    'gateway_payment_id' => $validated['razorpay_payment_id'],
                    'gateway_signature' => $validated['razorpay_signature'],
                    'order_ids' => $orderIds,
                    'failure_reason' => null,
                    'verified_at' => now(),
                ]);
                if ($locked->payment) {
                    $locked->payment->update([
                        'status' => 'paid',
                        'gateway_reference' => $validated['razorpay_payment_id'],
                        'captured_at' => now(),
                    ]);
                    $locked->payment->orders()->sync($orderIds);
                }

                return $orderIds;
            });
        } catch (\Throwable $exception) {
            Log::warning('Payment verified but order finalization failed.', [
                'payment_transaction_id' => $payment->id,
                'exception' => $exception->getMessage(),
            ]);
            $payment->update([
                'status' => 'manual_review',
                'gateway_payment_id' => $validated['razorpay_payment_id'],
                'gateway_signature' => $validated['razorpay_signature'],
                'failure_reason' => $exception->getMessage(),
                'verified_at' => now(),
            ]);
            if ($payment->payment) {
                $payment->payment->update([
                    'status' => 'manual_review',
                    'gateway_reference' => $validated['razorpay_payment_id'],
                ]);
            }

            return $this->jsonFailure('Payment was verified, but order confirmation could not be completed. Please contact support.', 409);
        }

        $orders->clearCurrentCheckout($payment->user_id);

        return response()->json([
            'success' => true,
            'message' => 'Payment verified successfully',
            'redirect' => url('/order-success'),
            'order_ids' => $orderIds,
        ]);
    }

    public function cancel(Request $request, PaymentTransaction $payment)
    {
        abort_unless($payment->isAccessibleByCurrentSession(), 403);

        if (in_array($payment->status, ['pending', 'processing'], true)) {
            $payment->update([
                'status' => 'cancelled',
                'failure_reason' => 'Customer cancelled the payment.',
            ]);
        }

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => 'Payment cancelled.'])
            : redirect('/checkout')->with('error', 'Payment cancelled. Please try again or choose Cash on Delivery.');
    }

    public function webhook(Request $request, RazorpayPaymentGateway $gateway, CheckoutOrderService $orders)
    {
        $secret = config('services.razorpay.webhook_secret');
        if (! $secret) {
            return response()->json(['success' => false], 404);
        }

        $rawPayload = $request->getContent();
        $expected = hash_hmac('sha256', $rawPayload, $secret);
        if (! hash_equals($expected, (string) $request->header('X-Razorpay-Signature'))) {
            Log::warning('Invalid Razorpay webhook signature.');
            return response()->json(['success' => false], 401);
        }

        $eventId = trim((string) $request->header('X-Razorpay-Event-Id'));
        if ($eventId === '') {
            return response()->json(['success' => false, 'message' => 'Missing provider event ID.'], 400);
        }

        $payload = json_decode($rawPayload, true);
        if (! is_array($payload)) {
            return response()->json(['success' => false, 'message' => 'Invalid webhook payload.'], 400);
        }

        $eventType = (string) $request->header('X-Razorpay-Event', $payload['event'] ?? 'unknown');
        $refundEntity = $payload['payload']['refund']['entity'] ?? null;
        if (str_starts_with($eventType, 'refund.') && is_array($refundEntity)) {
            return $this->processRefundWebhook($eventId, $eventType, $refundEntity);
        }

        $entity = $payload['payload']['payment']['entity'] ?? [];
        $status = $entity['status'] ?? null;
        $gatewayOrderId = $entity['order_id'] ?? null;
        $gatewayPaymentId = $entity['id'] ?? null;

        DB::transaction(function () use ($eventId, $payload, $entity, $status, $gatewayOrderId, $gatewayPaymentId, $orders, $request) {
            $eventType = (string) $request->header('X-Razorpay-Event', $payload['event'] ?? 'unknown');
            $webhook = PaymentWebhook::firstOrCreate(
                ['gateway' => 'razorpay', 'gateway_event_id' => $eventId],
                [
                    'event_type' => $eventType,
                    'status' => 'received',
                    'payload' => [
                        'payment_id' => $gatewayPaymentId,
                        'order_id' => $gatewayOrderId,
                        'amount' => $entity['amount'] ?? null,
                        'currency' => $entity['currency'] ?? null,
                        'status' => $status,
                    ],
                    'headers' => ['event_id' => $eventId, 'event_type' => $eventType],
                ]
            );
            $webhook = PaymentWebhook::whereKey($webhook->id)->lockForUpdate()->firstOrFail();

            if ($webhook->processed_at) {
                return;
            }

            $payment = $gatewayOrderId
                ? PaymentTransaction::where('gateway_order_id', $gatewayOrderId)->lockForUpdate()->first()
                : null;

            if (! $payment || ! $gatewayPaymentId || ! in_array($status, ['authorized', 'captured', 'failed'], true)) {
                $webhook->update(['status' => 'ignored', 'processed_at' => now()]);
                return;
            }

            $webhook->payment_id = $payment->payment_id;

            if ($status === 'failed') {
                $this->markFailed($payment, 'Gateway webhook reported failed payment.');
                $webhook->update(['status' => 'processed', 'processed_at' => now(), 'payment_id' => $payment->payment_id]);
                return;
            }

            if ((int) ($entity['amount'] ?? 0) !== (int) $payment->amount_paise || ($entity['currency'] ?? null) !== $payment->currency) {
                $payment->update([
                    'status' => 'amount_mismatch',
                    'gateway_payment_id' => $gatewayPaymentId,
                    'failure_reason' => 'Webhook amount or currency mismatch.',
                    'response_metadata' => array_merge($payment->response_metadata ?? [], [
                        'provider_webhook' => [
                            'payment_id' => $gatewayPaymentId,
                            'amount' => $entity['amount'] ?? null,
                            'currency' => $entity['currency'] ?? null,
                            'status' => $status,
                        ],
                    ]),
                ]);
                $webhook->update([
                    'status' => 'amount_mismatch',
                    'failure_reason' => 'Webhook amount or currency mismatch.',
                    'processed_at' => now(),
                    'payment_id' => $payment->payment_id,
                ]);
                return;
            }

            if ($status === 'authorized') {
                $webhook->update(['status' => 'processed', 'processed_at' => now(), 'payment_id' => $payment->payment_id]);
                return;
            }

            if ($payment->status === 'paid' && ! empty($payment->order_ids)) {
                $webhook->update(['status' => 'processed', 'processed_at' => now(), 'payment_id' => $payment->payment_id]);
                return;
            }

            if ($payment->expires_at?->isPast()) {
                $payment->update(['status' => 'manual_review', 'failure_reason' => 'Captured payment arrived after the checkout session expired.']);
                $webhook->update([
                    'status' => 'manual_review',
                    'failure_reason' => $payment->failure_reason,
                    'processed_at' => now(),
                    'payment_id' => $payment->payment_id,
                ]);
                return;
            }

            try {
                $orderIds = $orders->createConfirmedOrders(
                    $payment->items_snapshot,
                    $payment->customer_details,
                    $payment->user_id,
                    $payment->payment_method,
                    'Paid'
                );
            } catch (\Throwable $exception) {
                Log::warning('Captured webhook payment requires manual order review.', [
                    'payment_transaction_id' => $payment->id,
                    'exception' => $exception->getMessage(),
                ]);
                $payment->update([
                    'status' => 'manual_review',
                    'gateway_payment_id' => $gatewayPaymentId,
                    'failure_reason' => $exception->getMessage(),
                    'verified_at' => now(),
                ]);
                $webhook->update([
                    'status' => 'manual_review',
                    'failure_reason' => 'Captured payment could not be finalized into an order.',
                    'processed_at' => now(),
                    'payment_id' => $payment->payment_id,
                ]);
                return;
            }

            $oldStatus = $payment->status;
            $payment->update([
                'status' => 'paid',
                'gateway_payment_id' => $gatewayPaymentId,
                'order_ids' => $orderIds,
                'failure_reason' => null,
                'verified_at' => now(),
                'completed_at' => now(),
            ]);
            if ($payment->payment) {
                $payment->payment->update([
                    'status' => 'paid',
                    'gateway_reference' => $gatewayPaymentId,
                    'captured_at' => now(),
                ]);
                $payment->payment->orders()->sync($orderIds);
            }
            PaymentAuditRecord::create([
                'payment_id' => $payment->payment_id,
                'payment_transaction_id' => $payment->id,
                'user_id' => $payment->user_id,
                'event' => 'payment.webhook_captured',
                'from_status' => $oldStatus,
                'to_status' => 'paid',
            ]);
            $webhook->update(['status' => 'processed', 'processed_at' => now(), 'payment_id' => $payment->payment_id]);
        });

        return response()->json(['success' => true]);
    }

    private function processRefundWebhook(string $eventId, string $eventType, array $entity)
    {
        $gatewayRefundId = $entity['id'] ?? null;
        if (! is_string($gatewayRefundId) || $gatewayRefundId === '') {
            return response()->json(['success' => false, 'message' => 'Missing provider refund ID.'], 400);
        }

        $result = DB::transaction(function () use ($eventId, $eventType, $entity, $gatewayRefundId) {
            $webhook = PaymentWebhook::firstOrCreate(
                ['gateway' => 'razorpay', 'gateway_event_id' => $eventId],
                [
                    'event_type' => $eventType,
                    'status' => 'received',
                    'payload' => [
                        'refund_id' => $gatewayRefundId,
                        'payment_id' => $entity['payment_id'] ?? null,
                        'amount' => $entity['amount'] ?? null,
                        'status' => $entity['status'] ?? null,
                    ],
                    'headers' => ['event_id' => $eventId, 'event_type' => $eventType],
                ]
            );
            $webhook = PaymentWebhook::whereKey($webhook->id)->lockForUpdate()->firstOrFail();
            if ($webhook->processed_at) {
                return true;
            }

            $refund = Refund::where('gateway_refund_id', $gatewayRefundId)->lockForUpdate()->first();
            if (! $refund) {
                $webhook->update(['status' => 'unmatched', 'failure_reason' => 'Refund webhook arrived before local provider reference was available.']);
                return false;
            }

            $transaction = $refund->transaction;
            if (($entity['payment_id'] ?? null) !== $transaction?->gateway_payment_id
                || (isset($entity['amount']) && (int) $entity['amount'] !== $this->decimalToPaise((string) $refund->amount))
                || (isset($entity['currency']) && $entity['currency'] !== $refund->currency)) {
                $refund->update([
                    'status' => 'manual_review',
                    'metadata' => array_merge($refund->metadata ?? [], ['webhook_mismatch' => [
                        'payment_id' => $entity['payment_id'] ?? null,
                        'amount' => $entity['amount'] ?? null,
                        'currency' => $entity['currency'] ?? null,
                    ]]),
                ]);
                $webhook->update([
                    'payment_id' => $refund->payment_id,
                    'status' => 'manual_review',
                    'failure_reason' => 'Refund webhook did not match the local payment, amount, or currency.',
                    'processed_at' => now(),
                ]);
                return true;
            }

            $status = match ($eventType) {
                'refund.processed' => 'refunded',
                'refund.failed' => 'failed',
                'refund.created' => 'pending',
                default => $refund->status,
            };
            $refund->update([
                'status' => $status,
                'processed_at' => $status === 'refunded' ? now() : $refund->processed_at,
                'failed_at' => $status === 'failed' ? now() : $refund->failed_at,
                'metadata' => array_merge($refund->metadata ?? [], ['provider_status' => $entity['status'] ?? $eventType]),
            ]);

            $returnRequestId = (int) ($refund->metadata['return_request_id'] ?? 0);
            if ($returnRequestId > 0) {
                $returnRequest = OrderReturnRequest::whereKey($returnRequestId)->lockForUpdate()->first();
                if ($returnRequest && $returnRequest->status === OrderReturnRequest::STATUS_REFUND_PENDING) {
                    $nextStatus = $status === 'refunded'
                        ? OrderReturnRequest::STATUS_REFUNDED
                        : ($status === 'failed' ? OrderReturnRequest::STATUS_APPROVED : $returnRequest->status);
                    if ($nextStatus !== $returnRequest->status) {
                        $returnRequest->status = $nextStatus;
                        $returnRequest->appendHistory(
                            $nextStatus,
                            $status === 'refunded'
                                ? 'Payment provider confirmed the refund.'
                                : 'Payment provider reported that the refund failed; administrator review is required.',
                            'payment-provider'
                        );
                        $returnRequest->save();
                    }
                }
            }

            $refundedPaise = Refund::where('payment_id', $refund->payment_id)
                ->where('status', 'refunded')
                ->get(['amount'])
                ->sum(fn (Refund $item) => $this->decimalToPaise((string) $item->amount));
            $paymentAmountPaise = $this->decimalToPaise((string) $refund->payment->amount);
            if ($status === 'refunded') {
                $refund->payment->update([
                    'status' => $refundedPaise >= $paymentAmountPaise ? 'refunded' : 'partially_refunded',
                ]);
            }

            PaymentAuditRecord::create([
                'payment_id' => $refund->payment_id,
                'payment_transaction_id' => $refund->payment_transaction_id,
                'user_id' => $refund->user_id,
                'event' => 'refund.' . $status,
                'from_status' => null,
                'to_status' => $status,
                'metadata' => ['gateway_refund_id' => $gatewayRefundId, 'webhook_event_id' => $eventId],
            ]);
            $webhook->update([
                'payment_id' => $refund->payment_id,
                'status' => 'processed',
                'processed_at' => now(),
            ]);

            return true;
        });

        return $result
            ? response()->json(['success' => true])
            : response()->json(['success' => false, 'message' => 'Refund reference is not yet available.'], 503);
    }

    private function markFailed(PaymentTransaction $payment, string $reason): void
    {
        if ($payment->status !== 'paid') {
            $payment->update([
                'status' => 'failed',
                'failure_reason' => $reason,
            ]);
        }
    }

    private function decimalToPaise(string $amount): int
    {
        if (! preg_match('/^(\d+)(?:\.(\d{1,2}))?$/', $amount, $matches)) {
            throw new \InvalidArgumentException('Financial amounts must have at most two decimal places.');
        }

        return ((int) $matches[1] * 100) + (int) str_pad($matches[2] ?? '', 2, '0');
    }

    private function jsonFailure(string $message, int $status = 422, string $state = 'failed')
    {
        return response()->json([
            'success' => false,
            'status' => $state,
            'message' => $message,
        ], $status);
    }
}
