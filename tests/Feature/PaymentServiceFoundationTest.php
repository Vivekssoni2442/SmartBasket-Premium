<?php

namespace Tests\Feature;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Payment;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentServiceFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_service_persists_a_canonical_payment_and_audit_record(): void
    {
        $customer = User::factory()->create();
        $service = new PaymentService($this->gateway());

        $payment = $service->createPayment($customer, '199.00', 'inr', 'UPI', [], 'payment-key-001');

        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'user_id' => $customer->id,
            'amount' => 199,
            'currency' => 'INR',
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('payment_audit_records', [
            'payment_id' => $payment->id,
            'event' => 'payment.created',
        ]);
    }

    public function test_webhook_storage_requires_a_valid_gateway_signature_and_redacts_sensitive_values(): void
    {
        $service = new PaymentService($this->gateway());
        $payload = json_encode(['payment' => ['id' => 'pay_001', 'card_number' => '4111111111111111']]);

        $this->assertNull($service->processWebhook('test', 'event-invalid', 'payment.captured', $payload, 'invalid'));

        $webhook = $service->processWebhook('test', 'event-valid', 'payment.captured', $payload, 'valid');

        $this->assertSame('[redacted]', $webhook->payload['payment']['card_number']);
        $this->assertDatabaseCount('payment_webhooks', 1);
    }

    private function gateway(): PaymentGatewayInterface
    {
        return new class implements PaymentGatewayInterface {
            public function isConfigured(): bool { return true; }
            public function publicKey(): ?string { return null; }
            public function createOrder(\App\Models\PaymentTransaction $transaction): array { return ['success' => false]; }
            public function verifySignature(string $gatewayOrderId, string $gatewayPaymentId, string $signature): bool { return false; }
            public function fetchPayment(string $gatewayPaymentId): array { return ['success' => false]; }
            public function verifyWebhookSignature(string $payload, string $signature): bool { return $signature === 'valid'; }
            public function createRefund(\App\Models\PaymentTransaction $transaction, string $amount): array { return ['success' => false]; }
        };
    }
}
