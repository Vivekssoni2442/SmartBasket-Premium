<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderCancellationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_cancel_an_early_seller_order_without_changing_payment_status(): void
    {
        $customer = User::factory()->create();
        $seller = SellerProfile::create(['seller_name' => 'Seller A', 'shop_name' => 'Shop A', 'email' => 'seller-a@example.test', 'mobile_number' => '9999999999', 'password' => bcrypt('Password1!')]);
        $product = Product::create(['seller_id' => $seller->id, 'name' => 'Jacket', 'category' => 'Clothing', 'price' => 1000, 'stock' => 3]);
        $order = Order::create(['user_id' => $customer->id, 'seller_id' => $seller->id, 'name' => $customer->name, 'mobile' => '9999999999', 'address' => 'Address', 'city' => 'Pune', 'total' => 1000, 'amount' => 1000, 'status' => 'Confirmed', 'payment_method' => 'UPI', 'payment_status' => 'Pending', 'order_status' => 'Placed', 'delivery_status' => 'Pending', 'items' => [['product_id' => $product->id, 'seller_id' => $seller->id, 'name' => $product->name, 'quantity' => 1, 'price' => 1000]]]);

        $this->actingAs($customer)->post(route('orders.cancel', $order), ['cancellation_reason' => 'Changed my mind'])->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'order_status' => 'Cancelled', 'payment_status' => 'Pending', 'cancellation_reason' => 'Changed my mind']);
        $this->assertSame(4, $product->fresh()->stock);
        $this->assertTrue(Order::forSeller($seller->id)->whereKey($order->id)->exists());
    }
}
