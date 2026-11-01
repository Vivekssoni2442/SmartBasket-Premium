<?php

namespace App\Services;

use App\Contracts\PaymentGatewayInterface;
use App\Models\PaymentTransaction;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RazorpayPaymentGateway implements PaymentGatewayInterface
{
    public function isConfigured(): bool
    {
        $key = (string) config('services.razorpay.key');
        $secret = (string) config('services.razorpay.secret');
        $mode = config('services.razorpay.mode', 'test');

        if (! filled($key) || ! filled($secret) || ! in_array($mode, ['test', 'live'], true)) {
            return false;
        }

        // Razorpay issues distinct rzp_test_* and rzp_live_* key IDs. Refuse
        // to initialize Checkout when the deployment mode and key disagree.
        return str_starts_with($key, 'rzp_' . $mode . '_');
    }

    public function publicKey(): ?string
    {
        return config('services.razorpay.key');
    }

    public function createOrder(PaymentTransaction $transaction): array
    {
        if (! $this->isConfigured()) {
            return ['success' => false, 'message' => 'Online payment gateway is not configured.'];
        }

        try {
            $response = Http::acceptJson()
                ->withBasicAuth(config('services.razorpay.key'), config('services.razorpay.secret'))
                ->timeout(20)
                ->post('https://api.razorpay.com/v1/orders', [
                    'amount' => $transaction->amount_paise,
                    'currency' => $transaction->currency,
                    'receipt' => 'sb-payment-' . $transaction->id,
                    'payment_capture' => 1,
                    'notes' => [
                        'smart_basket_payment_transaction_id' => (string) $transaction->id,
                    ],
                ]);
        } catch (ConnectionException $exception) {
            Log::warning('Razorpay order creation connection failed.', ['exception' => $exception->getMessage()]);
            return ['success' => false, 'message' => 'Payment gateway is temporarily unavailable.'];
        }

        if ($response->failed()) {
            Log::warning('Razorpay order creation failed.', [
                'status' => $response->status(),
                'response' => str($response->body())->limit(1000)->toString(),
            ]);

            return ['success' => false, 'message' => 'Payment gateway could not start this payment.'];
        }

        return [
            'success' => true,
            'gateway_order_id' => $response->json('id'),
        ];
    }

    public function verifySignature(string $gatewayOrderId, string $gatewayPaymentId, string $signature): bool
    {
        if (! $this->isConfigured()) {
            return false;
        }

        $expected = hash_hmac('sha256', $gatewayOrderId . '|' . $gatewayPaymentId, config('services.razorpay.secret'));

        return hash_equals($expected, $signature);
    }

    public function fetchPayment(string $gatewayPaymentId): array
    {
        if (! $this->isConfigured()) {
            return ['success' => false, 'message' => 'Online payment gateway is not configured.'];
        }

        try {
            $response = Http::acceptJson()
                ->withBasicAuth(config('services.razorpay.key'), config('services.razorpay.secret'))
                ->timeout(20)
                ->get('https://api.razorpay.com/v1/payments/' . rawurlencode($gatewayPaymentId));
        } catch (ConnectionException $exception) {
            Log::warning('Razorpay payment fetch connection failed.', ['exception' => $exception->getMessage()]);
            return ['success' => false, 'message' => 'Payment verification is temporarily unavailable.'];
        }

        if ($response->failed()) {
            Log::warning('Razorpay payment fetch failed.', [
                'status' => $response->status(),
                'response' => str($response->body())->limit(1000)->toString(),
            ]);

            return ['success' => false, 'message' => 'Payment verification failed.'];
        }

        return [
            'success' => true,
            'status' => $response->json('status'),
            'amount' => (int) $response->json('amount'),
            'currency' => $response->json('currency'),
            'order_id' => $response->json('order_id'),
            'method' => $response->json('method'),
        ];
    }

    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        $secret = config('services.razorpay.webhook_secret');

        return filled($secret)
            && filled($signature)
            && hash_equals(hash_hmac('sha256', $payload, $secret), $signature);
    }

    public function createRefund(PaymentTransaction $transaction, string $amount): array
    {
        if (! $this->isConfigured() || ! filled($transaction->gateway_payment_id)) {
            return ['success' => false, 'message' => 'A verified gateway payment is required before a refund can be requested.'];
        }

        if (! preg_match('/^(\d+)(?:\.(\d{1,2}))?$/', $amount, $matches)) {
            return ['success' => false, 'message' => 'Refund amount must be a non-negative INR amount with at most two decimal places.'];
        }
        $amountPaise = ((int) $matches[1] * 100) + (int) str_pad($matches[2] ?? '', 2, '0');
        if ($amountPaise <= 0) {
            return ['success' => false, 'message' => 'Refund amount must be greater than zero.'];
        }

        try {
            $response = Http::acceptJson()
                ->withBasicAuth(config('services.razorpay.key'), config('services.razorpay.secret'))
                ->timeout(20)
                ->post('https://api.razorpay.com/v1/payments/' . rawurlencode($transaction->gateway_payment_id) . '/refund', [
                    'amount' => $amountPaise,
                ]);
        } catch (ConnectionException $exception) {
            Log::warning('Razorpay refund connection failed.', ['exception' => $exception->getMessage()]);

            return ['success' => false, 'message' => 'Payment gateway is temporarily unavailable.'];
        }

        if ($response->failed()) {
            Log::warning('Razorpay refund request failed.', ['status' => $response->status()]);

            return ['success' => false, 'message' => 'The gateway could not create this refund.'];
        }

        return [
            'success' => true,
            'gateway_refund_id' => $response->json('id'),
            'status' => $response->json('status', 'requested'),
        ];
    }
}
