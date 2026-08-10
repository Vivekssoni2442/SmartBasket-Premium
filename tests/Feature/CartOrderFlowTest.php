<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartOrderFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_quantity_updates_and_order_is_created_with_payment_details(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Smart Lamp',
            'category' => 'Home',
            'description' => 'Ambient lighting',
            'image' => 'lamp.jpg',
            'price' => 750.00,
            'rating' => 4.5,
            'stock' => 20,
        ]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($user);

        $this->post('/cart/update/' . $product->id, ['quantity' => 3]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response = $this->post('/place-order', [
            'name' => 'Ravi Kumar',
            'mobile' => '9123456780',
            'address' => '10, Main Road',
            'city' => 'Delhi',
            'payment_method' => 'UPI',
        ]);

        $response->assertRedirect('/order-success');
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method' => 'UPI',
            'payment_status' => 'Paid',
            'order_status' => 'Confirmed',
        ]);
    }
}
