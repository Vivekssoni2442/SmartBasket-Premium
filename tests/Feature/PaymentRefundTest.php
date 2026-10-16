<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentRefundTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_refund_is_idempotent_and_provider_webhook_finalizes_it(): void
    {
        $secret = 'refund-webhook-secret';
        config([
            'services.razorpay.key' => 'rzp_test_public',
            'services.razorpay.secret' => 'refund-api-secret',
            'services.razorpay.webhook_secret' => $secret,
        ]);
        Http::fake([
            'https://api.razorpay.com/v1/payments/pay_refund_001/refund' => Http::response([
                'id' => 'rfnd_test_001',
                'status' => 'processed',
            ]),
        ]);

        [$customer, $payment, $attempt] = $this->capturedPayment();
        $admin = Admin::create([
            'name' => 'Refund Admin',
            'email' => 'refund-admin@example.test',
            'password' => bcrypt('Password1!'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);
        $session = ['admin_authenticated' => true, 'admin_id' => $admin->id];

        $this->withSession($session)
            ->post(route('admin.transactions.refund', $attempt), [
                'amount' => '499.99',
                'reason' => 'Customer request',
                'idempotency_key' => 'refund-request-001',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('refunds', [
            'payment_id' => $payment->id,
            'payment_transaction_id' => $attempt->id,
            'gateway_refund_id' => 'rfnd_test_001',
            'idempotency_key' => 'refund-request-001',
            'status' => 'pending',
        ]);

        $this->withSession($session)
            ->post(route('admin.transactions.refund', $attempt), [
                'amount' => '499.99',
                'reason' => 'Customer request',
                'idempotency_key' => 'refund-request-001',
            ])
            ->assertSessionHas('success');
        $this->assertDatabaseCount('refunds', 1);
        Http::assertSentCount(1);

        $payload = json_encode([
            'event' => 'refund.processed',
            'payload' => ['refund' => ['entity' => [
                'id' => 'rfnd_test_001',
                'payment_id' => 'pay_refund_001',
                'amount' => 49999,
                'currency' => 'INR',
                'status' => 'processed',
            ]]],
        ], JSON_THROW_ON_ERROR);
        $headers = [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_X_RAZORPAY_SIGNATURE' => hash_hmac('sha256', $payload, $secret),
            'HTTP_X_RAZORPAY_EVENT_ID' => 'evt_refund_001',
            'HTTP_X_RAZORPAY_EVENT' => 'refund.processed',
        ];

        $this->call('POST', route('payments.razorpay.webhook'), [], [], [], $headers, $payload)->assertOk();
        $this->call('POST', route('payments.razorpay.webhook'), [], [], [], $headers, $payload)->assertOk();

        $this->assertDatabaseHas('refunds', ['gateway_refund_id' => 'rfnd_test_001', 'status' => 'refunded']);
        $this->assertDatabaseHas('payments', ['id' => $payment->id, 'status' => 'refunded']);
        $this->assertDatabaseHas('payment_webhooks', ['gateway_event_id' => 'evt_refund_001', 'status' => 'processed']);
        $this->assertDatabaseCount('payment_webhooks', 1);
    }

    public function test_unauthorized_customer_cannot_initiate_admin_refund(): void
    {
        [, , $attempt] = $this->capturedPayment();

        $this->actingAs(User::factory()->create())
            ->post(route('admin.transactions.refund', $attempt), [
                'amount' => '1.00',
                'idempotency_key' => 'unauthorized-refund',
            ])
            ->assertForbidden();

        $this->assertDatabaseCount('refunds', 0);
    }

    private function capturedPayment(): array
    {
        $customer = User::factory()->create();
        $payment = Payment::create([
            'user_id' => $customer->id,
            'gateway' => 'razorpay',
            'payment_method' => 'Card',
            'status' => 'paid',
            'amount' => '499.99',
            'currency' => 'INR',
        ]);
        $attempt = PaymentTransaction::create([
            'payment_id' => $payment->id,
            'user_id' => $customer->id,
            'access_token' => str()->random(64),
            'gateway' => 'razorpay',
            'gateway_order_id' => 'order_refund_001',
            'gateway_payment_id' => 'pay_refund_001',
            'payment_method' => 'Card',
            'status' => 'paid',
            'amount' => '499.99',
            'amount_paise' => 49999,
            'currency' => 'INR',
            'items_snapshot' => [],
            'customer_details' => ['name' => $customer->name],
            'order_ids' => [],
            'expires_at' => now()->addMinutes(30),
        ]);

        return [$customer, $payment, $attempt];
    }
}
