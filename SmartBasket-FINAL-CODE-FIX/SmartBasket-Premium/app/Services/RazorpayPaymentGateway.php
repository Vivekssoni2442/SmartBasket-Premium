<?php

namespace App\Services;

use App\Models\PaymentTransaction;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RazorpayPaymentGateway
{
    public function isConfigured(): bool
    {
        return filled(config('services.razorpay.key')) && filled(config('services.razorpay.secret'));
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
        ];
    }
}
