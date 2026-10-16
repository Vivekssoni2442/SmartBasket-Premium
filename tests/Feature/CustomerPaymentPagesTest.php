<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Models\Product;
use App\Models\Refund;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CustomerPaymentPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_history_only_contains_their_database_payments(): void
    {
        $customer = User::factory()->create();
        $otherCustomer = User::factory()->create();
        $ownPayment = $this->payment($customer, ['gateway_payment_id' => 'pay_customer_001']);
        $otherPayment = $this->payment($otherCustomer, ['gateway_payment_id' => 'pay_other_001']);

        $this->actingAs($customer)
            ->get(route('payments.index'))
            ->assertOk()
            ->assertSee('pay_customer_001')
            ->assertDontSee('pay_other_001');
    }

    public function test_customer_cannot_view_another_customers_payment_or_receipt(): void
    {
        $customer = User::factory()->create();
        $otherPayment = $this->payment(User::factory()->create());

        $this->actingAs($customer)->get(route('payments.show', $otherPayment))->assertForbidden();
        $this->actingAs($customer)->get(route('payments.receipt', $otherPayment))->assertForbidden();
    }

    public function test_pending_gateway_payment_offers_hosted_checkout_and_server_verification(): void
    {
        config([
            'services.razorpay.key' => 'rzp_test_public',
            'services.razorpay.secret' => 'test_secret',
        ]);

        $customer = User::factory()->create();
        $payment = $this->payment($customer, [
            'status' => 'processing',
            'gateway_order_id' => 'order_test_001',
        ]);

        $response = $this->actingAs($customer)
            ->get(route('payments.show', $payment))
            ->assertOk();

        $html = $response->getContent();
        $this->assertTrue(str_contains($html, 'https://checkout.razorpay.com/v1/checkout.js'), 'Hosted checkout script is missing.');
        $this->assertTrue(str_contains($html, 'Pay securely'), 'Secure payment button is missing.');
        $verificationUrl = str_replace('/', '\\/', route('payments.verify', $payment));
        $this->assertTrue(str_contains($html, $verificationUrl), 'Server verification endpoint is missing.');
        $this->assertTrue(str_contains($html, 'server-side verification'), 'Server-side verification notice is missing.');

        $this->assertDatabaseHas('payment_transactions', [
            'id' => $payment->id,
            'status' => 'processing',
        ]);
    }

    public function test_authorized_but_uncaptured_gateway_payment_does_not_confirm_an_order(): void
    {
        $secret = 'test_secret';
        config([
            'services.razorpay.key' => 'rzp_test_public',
            'services.razorpay.secret' => $secret,
        ]);

        $customer = User::factory()->create();
        $payment = $this->payment($customer, [
            'status' => 'processing',
            'gateway_order_id' => 'order_test_002',
        ]);
        Http::fake([
            'https://api.razorpay.com/v1/payments/pay_authorized' => Http::response([
                'id' => 'pay_authorized',
                'order_id' => 'order_test_002',
                'status' => 'authorized',
                'amount' => 19900,
                'currency' => 'INR',
            ]),
        ]);

        $response = $this->actingAs($customer)->postJson(route('payments.verify', $payment), [
            'razorpay_payment_id' => 'pay_authorized',
            'razorpay_order_id' => 'order_test_002',
            'razorpay_signature' => hash_hmac('sha256', 'order_test_002|pay_authorized', $secret),
        ]);

        $response->assertStatus(202)->assertJson(['success' => false, 'status' => 'pending']);
        $this->assertDatabaseHas('payment_transactions', ['id' => $payment->id, 'status' => 'processing']);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_captured_gateway_payment_confirms_order_and_reduces_inventory(): void
    {
        $secret = 'test_secret';
        config([
            'services.razorpay.key' => 'rzp_test_public',
            'services.razorpay.secret' => $secret,
        ]);
        $customer = User::factory()->create();
        $seller = $this->seller();
        $product = Product::create([
            'seller_id' => $seller->id,
            'name' => 'Captured Payment Product',
            'category' => 'Test',
            'price' => '499.99',
            'stock' => 3,
            'status' => 'active',
        ]);
        $canonical = Payment::create([
            'user_id' => $customer->id,
            'gateway' => 'razorpay',
            'payment_method' => 'Card',
            'status' => 'processing',
            'amount' => '499.99',
            'currency' => 'INR',
        ]);
        $payment = $this->payment($customer, [
            'payment_id' => $canonical->id,
            'status' => 'processing',
            'gateway_order_id' => 'order_captured_001',
            'amount' => '499.99',
            'amount_paise' => 49999,
            'items_snapshot' => [$seller->id => [[
                'product_id' => $product->id,
                'seller_id' => $seller->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => '499.99',
            ]]],
            'customer_details' => [
                'name' => $customer->name,
                'mobile' => '9876543210',
                'address' => 'Test Street',
                'city' => 'Pune',
            ],
        ]);
        Http::fake([
            'https://api.razorpay.com/v1/payments/pay_captured_001' => Http::response([
                'id' => 'pay_captured_001',
                'order_id' => 'order_captured_001',
                'status' => 'captured',
                'amount' => 49999,
                'currency' => 'INR',
            ]),
        ]);

        $response = $this->actingAs($customer)->postJson(route('payments.verify', $payment), [
            'razorpay_payment_id' => 'pay_captured_001',
            'razorpay_order_id' => 'order_captured_001',
            'razorpay_signature' => hash_hmac('sha256', 'order_captured_001|pay_captured_001', $secret),
        ]);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('payment_transactions', [
            'id' => $payment->id,
            'status' => 'paid',
            'gateway_payment_id' => 'pay_captured_001',
        ]);
        $this->assertDatabaseHas('payments', ['id' => $canonical->id, 'status' => 'paid']);
        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'seller_id' => $seller->id,
            'amount' => '499.99',
            'payment_status' => 'Paid',
        ]);
        $this->assertDatabaseHas('payment_order', ['payment_id' => $canonical->id]);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'stock' => 2]);
    }

    public function test_verified_amount_mismatch_is_flagged_without_confirming_an_order(): void
    {
        $secret = 'test_secret';
        config([
            'services.razorpay.key' => 'rzp_test_public',
            'services.razorpay.secret' => $secret,
        ]);
        $customer = User::factory()->create();
        $payment = $this->payment($customer, [
            'status' => 'processing',
            'gateway_order_id' => 'order_mismatch_001',
        ]);
        Http::fake([
            'https://api.razorpay.com/v1/payments/pay_mismatch_001' => Http::response([
                'id' => 'pay_mismatch_001',
                'order_id' => 'order_mismatch_001',
                'status' => 'captured',
                'amount' => 19901,
                'currency' => 'INR',
            ]),
        ]);

        $response = $this->actingAs($customer)->postJson(route('payments.verify', $payment), [
            'razorpay_payment_id' => 'pay_mismatch_001',
            'razorpay_order_id' => 'order_mismatch_001',
            'razorpay_signature' => hash_hmac('sha256', 'order_mismatch_001|pay_mismatch_001', $secret),
        ]);

        $response->assertStatus(422)->assertJson(['success' => false]);
        $this->assertDatabaseHas('payment_transactions', [
            'id' => $payment->id,
            'status' => 'amount_mismatch',
            'gateway_payment_id' => 'pay_mismatch_001',
        ]);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_invalid_gateway_signature_does_not_mutate_payment_state(): void
    {
        config([
            'services.razorpay.key' => 'rzp_test_public',
            'services.razorpay.secret' => 'test_secret',
        ]);
        $customer = User::factory()->create();
        $payment = $this->payment($customer, [
            'status' => 'processing',
            'gateway_order_id' => 'order_signature_001',
        ]);

        $response = $this->actingAs($customer)->postJson(route('payments.verify', $payment), [
            'razorpay_payment_id' => 'pay_forged_001',
            'razorpay_order_id' => 'order_signature_001',
            'razorpay_signature' => 'invalid',
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseHas('payment_transactions', ['id' => $payment->id, 'status' => 'processing']);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_replayed_captured_webhook_creates_only_one_order(): void
    {
        $secret = 'webhook_test_secret';
        config(['services.razorpay.webhook_secret' => $secret]);
        $customer = User::factory()->create();
        $seller = $this->seller();
        $product = Product::create([
            'seller_id' => $seller->id,
            'name' => 'Webhook Test Product',
            'category' => 'Test',
            'price' => 250,
            'stock' => 5,
        ]);
        $payment = $this->payment($customer, [
            'status' => 'processing',
            'gateway_order_id' => 'order_webhook_001',
            'amount' => 250,
            'amount_paise' => 25000,
            'items_snapshot' => [
                $seller->id => [[
                    'product_id' => $product->id,
                    'seller_id' => $seller->id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => 250,
                ]],
            ],
            'customer_details' => [
                'name' => $customer->name,
                'mobile' => '9876543210',
                'address' => 'Test Street',
                'city' => 'Pune',
            ],
        ]);
        $payload = json_encode([
            'event' => 'payment.captured',
            'payload' => ['payment' => ['entity' => [
                'id' => 'pay_webhook_001',
                'order_id' => 'order_webhook_001',
                'status' => 'captured',
                'amount' => 25000,
                'currency' => 'INR',
            ]]],
        ], JSON_THROW_ON_ERROR);
        $headers = [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_X_RAZORPAY_SIGNATURE' => hash_hmac('sha256', $payload, $secret),
            'HTTP_X_RAZORPAY_EVENT_ID' => 'evt_webhook_001',
            'HTTP_X_RAZORPAY_EVENT' => 'payment.captured',
        ];

        $this->call('POST', route('payments.razorpay.webhook'), [], [], [], $headers, $payload)->assertOk();
        $this->call('POST', route('payments.razorpay.webhook'), [], [], [], $headers, $payload)->assertOk();

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('payment_transactions', [
            'id' => $payment->id,
            'status' => 'paid',
            'gateway_payment_id' => 'pay_webhook_001',
        ]);
        $this->assertDatabaseHas('payment_webhooks', [
            'gateway_event_id' => 'evt_webhook_001',
            'status' => 'processed',
        ]);
        $this->assertDatabaseCount('payment_webhooks', 1);
    }

    public function test_captured_payment_with_unavailable_inventory_is_held_for_manual_review(): void
    {
        $secret = 'test_secret';
        config([
            'services.razorpay.key' => 'rzp_test_public',
            'services.razorpay.secret' => $secret,
        ]);
        $customer = User::factory()->create();
        $seller = $this->seller();
        $product = Product::create([
            'seller_id' => $seller->id,
            'name' => 'Out of Stock Product',
            'category' => 'Test',
            'price' => 250,
            'stock' => 0,
        ]);
        $payment = $this->payment($customer, [
            'status' => 'processing',
            'gateway_order_id' => 'order_stock_001',
            'amount' => 250,
            'amount_paise' => 25000,
            'items_snapshot' => [$seller->id => [[
                'product_id' => $product->id,
                'seller_id' => $seller->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => '250.00',
            ]]],
            'customer_details' => [
                'name' => $customer->name,
                'mobile' => '9876543210',
                'address' => 'Test Street',
                'city' => 'Pune',
            ],
        ]);
        Http::fake([
            'https://api.razorpay.com/v1/payments/pay_stock_001' => Http::response([
                'id' => 'pay_stock_001',
                'order_id' => 'order_stock_001',
                'status' => 'captured',
                'amount' => 25000,
                'currency' => 'INR',
            ]),
        ]);

        $response = $this->actingAs($customer)->postJson(route('payments.verify', $payment), [
            'razorpay_payment_id' => 'pay_stock_001',
            'razorpay_order_id' => 'order_stock_001',
            'razorpay_signature' => hash_hmac('sha256', 'order_stock_001|pay_stock_001', $secret),
        ]);

        $response->assertStatus(409)->assertJson(['success' => false]);
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('payment_transactions', [
            'id' => $payment->id,
            'status' => 'manual_review',
            'gateway_payment_id' => 'pay_stock_001',
        ]);
    }

    public function test_failed_payment_displays_retry_and_does_not_create_an_order_when_gateway_is_unavailable(): void
    {
        $customer = User::factory()->create();
        $payment = $this->payment($customer, [
            'status' => 'failed',
            'gateway_order_id' => 'order_old_001',
            'gateway_payment_id' => 'pay_old_001',
            'failure_reason' => 'Bank declined the transaction.',
        ]);

        $this->actingAs($customer)
            ->get(route('payments.show', $payment))
            ->assertOk()
            ->assertSee('Retry Payment')
            ->assertSee('Bank declined the transaction.');

        $this->actingAs($customer)
            ->post(route('payments.retry', $payment))
            ->assertRedirect();

        $this->assertDatabaseCount('payment_transactions', 2);
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('payment_transactions', [
            'id' => $payment->id,
            'status' => 'failed',
            'gateway_order_id' => 'order_old_001',
            'gateway_payment_id' => 'pay_old_001',
        ]);
        $this->assertDatabaseHas('payment_transactions', [
            'root_transaction_id' => $payment->id,
            'attempt_number' => 2,
            'status' => 'failed',
        ]);
    }

    public function test_receipt_displays_the_customers_attached_order_and_payment_details(): void
    {
        $customer = User::factory()->create(['name' => 'Asha Verma']);
        $seller = SellerProfile::create([
            'seller_name' => 'Ravi Kumar', 'shop_name' => 'Ravi Electronics',
            'email' => 'ravi@example.test', 'mobile_number' => '9876543210',
            'password' => bcrypt('Password1!'),
        ]);
        $order = Order::create([
            'user_id' => $customer->id, 'seller_id' => $seller->id, 'name' => $customer->name,
            'mobile' => '9999999999', 'address' => 'Market Road', 'city' => 'Pune',
            'total' => 499.00, 'amount' => 499.00, 'status' => 'Confirmed',
            'payment_method' => 'UPI', 'payment_status' => 'Paid', 'order_status' => 'Confirmed',
            'delivery_status' => 'Pending', 'items' => [],
        ]);
        $payment = $this->payment($customer, [
            'amount' => 499.00, 'amount_paise' => 49900, 'status' => 'paid',
            'order_ids' => [$order->id], 'gateway_payment_id' => 'pay_receipt_001',
        ]);
        $canonicalPayment = Payment::create([
            'user_id' => $customer->id, 'gateway' => 'razorpay', 'payment_method' => 'UPI',
            'status' => 'paid', 'amount' => 499.00, 'currency' => 'INR',
        ]);
        $payment->update(['payment_id' => $canonicalPayment->id]);
        Refund::create([
            'payment_id' => $canonicalPayment->id, 'payment_transaction_id' => $payment->id,
            'user_id' => $customer->id, 'amount' => 499.00, 'currency' => 'INR', 'status' => 'requested',
        ]);

        $this->actingAs($customer)
            ->get(route('payments.receipt', $payment))
            ->assertOk()
            ->assertSee('SMART BASKET')
            ->assertSee('Asha Verma')
            ->assertSee('SB-'.$order->id)
            ->assertSee('Ravi Electronics')
            ->assertSee('pay_receipt_001')
            ->assertSee('Requested');
    }

    private function payment(User $user, array $overrides = []): PaymentTransaction
    {
        return PaymentTransaction::create(array_merge([
            'user_id' => $user->id, 'access_token' => str()->random(64), 'gateway' => 'razorpay',
            'payment_method' => 'UPI', 'status' => 'paid', 'amount' => 199.00, 'amount_paise' => 19900,
            'currency' => 'INR', 'items_snapshot' => [], 'customer_details' => ['name' => $user->name],
            'order_ids' => [], 'expires_at' => now()->addMinutes(30),
        ], $overrides));
    }

    private function seller(): SellerProfile
    {
        return SellerProfile::create([
            'seller_name' => 'Webhook Seller',
            'shop_name' => 'Webhook Shop',
            'email' => 'webhook-seller@example.test',
            'mobile_number' => '9999999999',
            'password' => bcrypt('Password1!'),
        ]);
    }
}
