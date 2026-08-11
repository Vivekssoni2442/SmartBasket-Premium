<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        session(['buy_product' => $product->id]);

        $response = $this->get('/checkout');

        $response->assertOk();
        $response->assertSee($product->name);
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

    private function seller(string $suffix): SellerProfile
    {
        return SellerProfile::create([
            'seller_name' => "Seller {$suffix}", 'shop_name' => "Shop {$suffix}",
            'email' => "seller-{$suffix}@example.test", 'mobile_number' => '9999999999', 'password' => bcrypt('Password1!'),
        ]);
    }
}
