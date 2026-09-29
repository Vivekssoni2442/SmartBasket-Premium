<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Services\CheckoutOrderService;
use App\Services\RazorpayPaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function show(PaymentTransaction $payment)
    {
        abort_unless($payment->isAccessibleByCurrentSession(), 403);

        if ($payment->status === 'paid' && ! empty($payment->order_ids)) {
            return redirect('/order-success')->with('success', 'Payment successful. Order confirmed.');
        }

        return view('payments.show', [
            'payment' => $payment,
            'razorpayKey' => config('services.razorpay.key'),
            'gatewayReady' => app(RazorpayPaymentGateway::class)->isConfigured() && filled($payment->gateway_order_id),
        ]);
    }

    public function verify(Request $request, PaymentTransaction $payment, RazorpayPaymentGateway $gateway, CheckoutOrderService $orders)
    {
        abort_unless($payment->isAccessibleByCurrentSession(), 403);

        $validated = $request->validate([
            'razorpay_payment_id' => ['required', 'string', 'max:255'],
            'razorpay_order_id' => ['required', 'string', 'max:255'],
            'razorpay_signature' => ['required', 'string', 'max:255'],
        ]);

        if (! $gateway->isConfigured()) {
            return $this->jsonFailure('Online payment gateway is not configured.', 503);
        }

        if ($payment->gateway_order_id !== $validated['razorpay_order_id']) {
            $this->markFailed($payment, 'Gateway order id mismatch.');
            return $this->jsonFailure('Payment verification failed.', 422);
        }

        if (! $gateway->verifySignature($validated['razorpay_order_id'], $validated['razorpay_payment_id'], $validated['razorpay_signature'])) {
            $this->markFailed($payment, 'Invalid payment signature.');
            return $this->jsonFailure('Payment verification failed.', 422);
        }

        $gatewayPayment = $gateway->fetchPayment($validated['razorpay_payment_id']);
        if (! $gatewayPayment['success']) {
            return $this->jsonFailure($gatewayPayment['message'], 502);
        }

        if (($gatewayPayment['order_id'] ?? null) !== $payment->gateway_order_id
            || ($gatewayPayment['currency'] ?? null) !== $payment->currency
            || (int) ($gatewayPayment['amount'] ?? 0) !== (int) $payment->amount_paise) {
            $this->markFailed($payment, 'Gateway amount, currency, or order mismatch.');
            return $this->jsonFailure('Payment amount verification failed.', 422);
        }

        if (! in_array($gatewayPayment['status'] ?? '', ['authorized', 'captured'], true)) {
            $payment->forceFill([
                'status' => 'pending',
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

                return $orderIds;
            });
        } catch (\Throwable $exception) {
            Log::warning('Payment verified but order finalization failed.', [
                'payment_transaction_id' => $payment->id,
                'exception' => $exception->getMessage(),
            ]);
            $this->markFailed($payment, $exception->getMessage());

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

        $expected = hash_hmac('sha256', $request->getContent(), $secret);
        if (! hash_equals($expected, (string) $request->header('X-Razorpay-Signature'))) {
            Log::warning('Invalid Razorpay webhook signature.');
            return response()->json(['success' => false], 401);
        }

        $payload = $request->json()->all();
        $entity = $payload['payload']['payment']['entity'] ?? [];
        $status = $entity['status'] ?? null;
        $gatewayOrderId = $entity['order_id'] ?? null;
        $gatewayPaymentId = $entity['id'] ?? null;

        if (! $gatewayOrderId || ! $gatewayPaymentId || ! in_array($status, ['authorized', 'captured', 'failed'], true)) {
            return response()->json(['success' => true]);
        }

        $payment = PaymentTransaction::where('gateway_order_id', $gatewayOrderId)->first();
        if (! $payment) {
            return response()->json(['success' => true]);
        }

        if ($status === 'failed') {
            $this->markFailed($payment, 'Gateway webhook reported failed payment.');
            return response()->json(['success' => true]);
        }

        if ((int) ($entity['amount'] ?? 0) !== (int) $payment->amount_paise || ($entity['currency'] ?? null) !== $payment->currency) {
            $this->markFailed($payment, 'Webhook amount or currency mismatch.');
            return response()->json(['success' => true]);
        }

        DB::transaction(function () use ($payment, $orders, $gatewayPaymentId) {
            $locked = PaymentTransaction::whereKey($payment->id)->lockForUpdate()->firstOrFail();
            if ($locked->status === 'paid' && ! empty($locked->order_ids)) {
                return;
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
                'gateway_payment_id' => $gatewayPaymentId,
                'order_ids' => $orderIds,
                'failure_reason' => null,
                'verified_at' => now(),
            ]);
        });

        return response()->json(['success' => true]);
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

    private function jsonFailure(string $message, int $status = 422, string $state = 'failed')
    {
        return response()->json([
            'success' => false,
            'status' => $state,
            'message' => $message,
        ], $status);
    }
}
