<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_place_order_from_database_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
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
            'total' => 2599.98,
        ]);
        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_checkout_page_can_render_buy_now_product_from_session(): void
    {
        $product = Product::create([
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
}
