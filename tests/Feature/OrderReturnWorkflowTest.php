<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderReturnRequest;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OrderReturnWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private function order(User $customer, array $overrides = []): Order
    {
        return Order::create(array_merge([
            'user_id' => $customer->id,
            'name' => $customer->name,
            'mobile' => '9876543210',
            'address' => '10 Test Road',
            'city' => 'Test City',
            'total' => 200,
            'amount' => 200,
            'status' => 'Delivered',
            'order_status' => 'Delivered',
            'delivery_status' => 'Delivered',
            'payment_status' => 'Paid',
            'items' => [['product_id' => 9001, 'seller_id' => 44, 'name' => 'Test Product', 'price' => 100, 'quantity' => 2]],
        ], $overrides));
    }

    public function test_customer_can_request_partial_return_and_cancel_only_while_pending_review(): void
    {
        $customer = User::factory()->create();
        $order = $this->order($customer);

        $this->actingAs($customer)->post(route('returns.store', $order), [
            'items' => [['product_id' => 9001, 'quantity' => 1]],
            'reason' => 'damaged',
            'description' => 'The packaging was damaged.',
        ])->assertRedirect();

        $return = OrderReturnRequest::firstOrFail();
        $this->assertSame(OrderReturnRequest::STATUS_REQUESTED, $return->status);
        $this->assertSame(1, $return->items[0]['quantity']);
        $this->actingAs($customer)->post(route('returns.cancel', $return))->assertRedirect();
        $this->assertSame(OrderReturnRequest::STATUS_CANCELLED, $return->fresh()->status);
    }

    public function test_delivered_cod_order_displays_cash_and_can_submit_a_return_without_becoming_paid(): void
    {
        $customer = User::factory()->create();
        $order = $this->order($customer, ['payment_method' => 'COD', 'payment_status' => 'Pending']);

        $this->assertSame('Cash', $order->payment_status_label);
        $this->assertTrue($order->isPaymentEligibleForReturn());
        $this->actingAs($customer)->get(route('orders.show', $order))
            ->assertOk()
            ->assertSee('Payment status')
            ->assertSee('Cash')
            ->assertSee('Submit return request')
            ->assertSee('My return requests');

        $this->actingAs($customer)->post(route('returns.store', $order), [
            'items' => [['product_id' => 9001, 'quantity' => 1]],
            'reason' => 'changed_mind',
        ])->assertRedirect();

        $this->assertSame('Pending', $order->fresh()->payment_status);
        $this->assertDatabaseHas('order_return_requests', [
            'order_id' => $order->id,
            'user_id' => $customer->id,
            'status' => OrderReturnRequest::STATUS_REQUESTED,
        ]);
    }

    public function test_return_quantities_are_limited_to_purchased_and_unreserved_units(): void
    {
        $customer = User::factory()->create();
        $order = $this->order($customer);
        $payload = ['items' => [['product_id' => 9001, 'quantity' => 2]], 'reason' => 'defective'];
        $this->actingAs($customer)->post(route('returns.store', $order), $payload)->assertSessionHasNoErrors();
        $this->actingAs($customer)->post(route('returns.store', $order), $payload)->assertSessionHasErrors('items.9001');
        $this->assertDatabaseCount('order_return_requests', 1);
    }

    public function test_customer_cannot_read_another_customers_return_request_or_return_unpaid_order(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $order = $this->order($owner);
        $return = OrderReturnRequest::create([
            'order_id' => $order->id, 'user_id' => $owner->id,
            'items' => [['product_id' => 9001, 'quantity' => 1]], 'reason' => 'other',
            'status' => 'requested', 'history' => [],
        ]);

        $this->actingAs($other)->get(route('returns.show', $return))->assertNotFound();
        $unpaid = $this->order($owner, ['payment_status' => 'Pending']);
        $this->actingAs($owner)->post(route('returns.store', $unpaid), [
            'items' => [['product_id' => 9001, 'quantity' => 1]], 'reason' => 'other',
        ])->assertSessionHasErrors('order');
    }

    public function test_only_authorized_admin_can_review_and_decision_is_audited(): void
    {
        $customer = User::factory()->create();
        $order = $this->order($customer);
        $return = OrderReturnRequest::create([
            'order_id' => $order->id, 'user_id' => $customer->id,
            'items' => [['product_id' => 9001, 'quantity' => 1]], 'reason' => 'damaged',
            'status' => 'requested', 'history' => [],
        ]);
        $admin = Admin::create(['name' => 'Return Admin', 'email' => 'return-admin@example.test', 'password' => bcrypt('Password1!'), 'role' => 'admin', 'status' => 'active']);
        $session = ['admin_authenticated' => true, 'admin_id' => $admin->id, 'admin_name' => $admin->name];

        $this->withSession($session)->get(route('admin.returns.index'))->assertOk()->assertSee('Return #' . $return->id);
        $this->withSession($session)->get(route('admin.returns.show', $return))->assertOk()->assertSee('Return request #' . $return->id);
        $this->withSession($session)->patch(route('admin.returns.review', $return), ['decision' => 'approved', 'note' => 'Return approved.'])->assertRedirect();
        $this->assertSame(OrderReturnRequest::STATUS_APPROVED, $return->fresh()->status);
        $this->assertDatabaseHas('admin_audit_logs', ['action' => 'return.approved', 'entity_id' => (string) $return->id]);
        $this->withSession($session)->patch(route('admin.returns.review', $return), ['decision' => 'rejected', 'note' => 'Changed decision'])->assertSessionHasErrors('decision');
    }

    public function test_seller_can_only_view_and_comment_on_returns_for_their_products(): void
    {
        $sellerOne = SellerProfile::create(['seller_name' => 'Seller One', 'shop_name' => 'One Shop', 'email' => 'seller-one-return@example.test', 'password' => bcrypt('Password1!'), 'verification_status' => SellerProfile::STATUS_ACTIVE]);
        $sellerTwo = SellerProfile::create(['seller_name' => 'Seller Two', 'shop_name' => 'Two Shop', 'email' => 'seller-two-return@example.test', 'password' => bcrypt('Password1!'), 'verification_status' => SellerProfile::STATUS_ACTIVE]);
        $productOne = Product::create(['seller_id' => $sellerOne->id, 'name' => 'Seller One Item', 'category' => 'Test', 'price' => 100, 'stock' => 2]);
        $productTwo = Product::create(['seller_id' => $sellerTwo->id, 'name' => 'Seller Two Item', 'category' => 'Test', 'price' => 100, 'stock' => 2]);
        $customer = User::factory()->create();
        $orderOne = $this->order($customer, ['seller_id' => $sellerOne->id, 'items' => [['product_id' => $productOne->id, 'seller_id' => $sellerOne->id, 'name' => $productOne->name, 'price' => 100, 'quantity' => 1]]]);
        $orderTwo = $this->order($customer, ['seller_id' => $sellerTwo->id, 'items' => [['product_id' => $productTwo->id, 'seller_id' => $sellerTwo->id, 'name' => $productTwo->name, 'price' => 100, 'quantity' => 1]]]);
        $returnOne = OrderReturnRequest::create(['order_id' => $orderOne->id, 'user_id' => $customer->id, 'items' => $orderOne->items, 'reason' => 'damaged', 'status' => 'requested', 'history' => []]);
        $returnTwo = OrderReturnRequest::create(['order_id' => $orderTwo->id, 'user_id' => $customer->id, 'items' => $orderTwo->items, 'reason' => 'damaged', 'status' => 'requested', 'history' => []]);

        $sellerSession = ['seller_login' => true, 'seller_id' => $sellerOne->id, 'seller_email' => $sellerOne->email];
        $this->withSession($sellerSession)->get(route('seller.returns.index'))->assertOk()->assertSee('Seller One Item')->assertDontSee('Seller Two Item');
        $this->withSession($sellerSession)->post(route('seller.returns.note', $returnOne), ['note' => 'Please include the original packaging.'])->assertRedirect();
        $this->assertDatabaseHas('order_return_requests', ['id' => $returnOne->id, 'seller_note' => 'Please include the original packaging.']);
        $this->withSession($sellerSession)->post(route('seller.returns.note', $returnTwo), ['note' => 'Unauthorized note'])->assertNotFound();
    }

    public function test_provider_confirmed_refund_updates_the_customer_return_state(): void
    {
        config([
            'services.razorpay.key' => 'rzp_test_public',
            'services.razorpay.secret' => 'refund-api-secret',
            'services.razorpay.webhook_secret' => 'return-webhook-secret',
        ]);
        Http::fake([
            'https://api.razorpay.com/v1/payments/pay_return_001/refund' => Http::response(['id' => 'rfnd_return_001', 'status' => 'processed']),
        ]);

        $customer = User::factory()->create();
        $order = $this->order($customer, ['total' => 200, 'amount' => 200]);
        $payment = Payment::create(['user_id' => $customer->id, 'gateway' => 'razorpay', 'payment_method' => 'Card', 'status' => 'paid', 'amount' => '200.00', 'currency' => 'INR']);
        $payment->orders()->attach($order->id);
        PaymentTransaction::create([
            'payment_id' => $payment->id, 'user_id' => $customer->id, 'access_token' => str()->random(64),
            'gateway' => 'razorpay', 'gateway_order_id' => 'order_return_001', 'gateway_payment_id' => 'pay_return_001',
            'payment_method' => 'Card', 'status' => 'paid', 'amount' => '200.00', 'amount_paise' => 20000,
            'currency' => 'INR', 'items_snapshot' => [], 'customer_details' => ['name' => $customer->name],
            'order_ids' => [$order->id], 'expires_at' => now()->addMinutes(30),
        ]);
        $return = OrderReturnRequest::create([
            'order_id' => $order->id, 'user_id' => $customer->id,
            'items' => [['product_id' => 9001, 'seller_id' => 44, 'name' => 'Test Product', 'unit_price' => 100, 'quantity' => 1]],
            'reason' => 'damaged', 'status' => 'approved', 'history' => [],
        ]);
        $admin = Admin::create(['name' => 'Refund Admin', 'email' => 'return-refund-admin@example.test', 'password' => bcrypt('Password1!'), 'role' => 'admin', 'status' => 'active']);

        $this->withSession(['admin_authenticated' => true, 'admin_id' => $admin->id])->post(route('admin.returns.refund', $return))
            ->assertSessionHas('success');
        $this->assertSame(OrderReturnRequest::STATUS_REFUND_PENDING, $return->fresh()->status);
        $this->assertSame('100.00', $return->fresh()->refund_amount);

        $payload = json_encode(['event' => 'refund.processed', 'payload' => ['refund' => ['entity' => [
            'id' => 'rfnd_return_001', 'payment_id' => 'pay_return_001', 'amount' => 10000, 'currency' => 'INR', 'status' => 'processed',
        ]]]], JSON_THROW_ON_ERROR);
        $headers = [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_X_RAZORPAY_SIGNATURE' => hash_hmac('sha256', $payload, 'return-webhook-secret'),
            'HTTP_X_RAZORPAY_EVENT_ID' => 'evt_return_001',
            'HTTP_X_RAZORPAY_EVENT' => 'refund.processed',
        ];
        $this->call('POST', route('payments.razorpay.webhook'), [], [], [], $headers, $payload)->assertOk();
        $this->assertSame(OrderReturnRequest::STATUS_REFUNDED, $return->fresh()->status);
        $this->assertDatabaseHas('refunds', ['gateway_refund_id' => 'rfnd_return_001', 'status' => 'refunded']);
    }
}
