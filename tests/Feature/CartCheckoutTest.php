<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use App\Services\CheckoutOrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_place_order_from_database_cart(): void
    {
        $user = User::factory()->create();
        $seller = $this->seller('A');
        $product = Product::create([
            'seller_id' => $seller->id,
            'name' => 'Wireless Headphones',
            'category' => 'Electronics',
            'description' => 'Premium audio',
            'image' => 'headphones.jpg',
            'price' => 1299.99,
            'rating' => 4.8,
            'stock' => 10,
        ]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->actingAs($user);

        $response = $this->post('/place-order', [
            'name' => 'Asha Verma',
            'mobile' => '9876543210',
            'address' => '123 Market Street',
            'city' => 'Mumbai',
        ]);

        $response->assertRedirect('/order-success');
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'seller_id' => $seller->id,
            'total' => 2599.98,
        ]);
        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_checkout_page_can_render_buy_now_product_from_session(): void
    {
        $customer = User::factory()->create();
        $seller = $this->seller('B');
        $product = Product::create([
            'seller_id' => $seller->id,
            'name' => 'Smart Watch',
            'category' => 'Wearables',
            'description' => 'Fitness tracking',
            'image' => 'watch.jpg',
            'price' => 899.00,
            'rating' => 4.6,
            'stock' => 8,
        ]);

        $response = $this->actingAs($customer)
            ->withSession(['buy_product' => $product->id])
            ->get('/checkout');

        $response->assertOk();
        $response->assertSee($product->name);
        $response->assertDontSee('Seller Payment QR');
        $response->assertDontSee('id="cardNumber"');
        $response->assertDontSee('id="upiId"');
        $response->assertDontSee('Please enter your UPI ID.');
        $response->assertDontSee('Please enter a valid card number.');
    }

    public function test_multi_seller_cart_creates_isolated_orders(): void
    {
        $user = User::factory()->create();
        $sellerA = $this->seller('A');
        $sellerB = $this->seller('B');
        $productA = Product::create(['seller_id' => $sellerA->id, 'name' => 'A1', 'category' => 'Test', 'price' => 100, 'stock' => 5]);
        $productB = Product::create(['seller_id' => $sellerB->id, 'name' => 'B1', 'category' => 'Test', 'price' => 200, 'stock' => 5]);
        Cart::create(['user_id' => $user->id, 'product_id' => $productA->id, 'quantity' => 2]);
        Cart::create(['user_id' => $user->id, 'product_id' => $productB->id, 'quantity' => 1]);

        $this->actingAs($user)->post('/place-order', [
            'name' => 'Buyer', 'mobile' => '9876543210', 'address' => 'Test Address', 'city' => 'Pune',
        ])->assertRedirect('/order-success');

        $this->assertDatabaseHas('orders', ['seller_id' => $sellerA->id, 'total' => 200]);
        $this->assertDatabaseHas('orders', ['seller_id' => $sellerB->id, 'total' => 200]);
        $orderA = \App\Models\Order::where('seller_id', $sellerA->id)->firstOrFail();
        $orderB = \App\Models\Order::where('seller_id', $sellerB->id)->firstOrFail();
        $this->assertSame($productA->id, $orderA->items[0]['product_id']);
        $this->assertSame($productB->id, $orderB->items[0]['product_id']);

        $this->withSession(['seller_login' => true, 'seller_id' => $sellerB->id])
            ->get(route('seller.orders.show', $orderA))
            ->assertNotFound();
    }

    public function test_checkout_totals_are_calculated_as_integer_paise(): void
    {
        $checkout = app(CheckoutOrderService::class);
        $items = [
            12 => [
                ['price' => '0.29', 'quantity' => 3],
                ['price' => '0.10', 'quantity' => 3],
            ],
        ];

        $this->assertSame(117, $checkout->totalForItemsInPaise($items));
        $this->assertSame('1.17', $checkout->totalForItems($items));
    }

    public function test_duplicate_online_checkout_submission_reuses_the_provider_order(): void
    {
        config([
            'services.razorpay.key' => 'rzp_test_public',
            'services.razorpay.secret' => 'test_secret',
        ]);
        Http::fake([
            'https://api.razorpay.com/v1/orders' => Http::response(['id' => 'order_idempotent_001']),
        ]);

        $customer = User::factory()->create();
        $seller = $this->seller('IDEMPOTENT');
        $seller->online_payments_enabled = true;
        $seller->save();
        $product = Product::create([
            'seller_id' => $seller->id,
            'name' => 'Idempotent Payment Product',
            'category' => 'Test',
            'price' => '10.29',
            'stock' => 4,
            'status' => 'active',
        ]);
        Cart::create(['user_id' => $customer->id, 'product_id' => $product->id, 'quantity' => 3]);
        $checkoutRequest = [
            'name' => $customer->name,
            'mobile' => '9876543210',
            'address' => 'Test Address',
            'city' => 'Pune',
            'payment_method' => 'UPI',
        ];

        $this->actingAs($customer)->withSession(['checkout_payment_nonce' => 'checkout-nonce-001'])
            ->post('/place-order', $checkoutRequest)
            ->assertRedirect();
        $this->post('/place-order', $checkoutRequest)->assertRedirect();

        $this->assertDatabaseCount('payments', 1);
        $this->assertDatabaseCount('payment_transactions', 1);
        $this->assertDatabaseHas('payment_transactions', [
            'gateway_order_id' => 'order_idempotent_001',
            'amount_paise' => 3087,
            'status' => 'processing',
        ]);
        Http::assertSentCount(1);
    }

    private function seller(string $suffix): SellerProfile
    {
        return SellerProfile::create([
            'seller_name' => "Seller {$suffix}", 'shop_name' => "Shop {$suffix}",
            'email' => "seller-{$suffix}@example.test", 'mobile_number' => '9999999999', 'password' => bcrypt('Password1!'),
        ]);
    }
}
