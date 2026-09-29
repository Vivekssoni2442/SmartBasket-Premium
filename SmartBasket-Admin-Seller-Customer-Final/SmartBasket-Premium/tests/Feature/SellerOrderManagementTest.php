<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\SellerProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerOrderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_can_update_order_status(): void
    {
        $seller = SellerProfile::create([
            'seller_name' => 'Seller A', 'shop_name' => 'Shop A', 'email' => 'seller-a@example.test',
            'mobile_number' => '9999999999', 'password' => bcrypt('Password1!'),
        ]);
        $product = Product::create(['seller_id' => $seller->id, 'name' => 'Smart Lamp', 'category' => 'Home', 'price' => 1500, 'stock' => 5]);
        $order = Order::create([
            'seller_id' => $seller->id,
            'name' => 'Dinesh',
            'mobile' => '9999999999',
            'address' => '456 Market Street',
            'city' => 'Pune',
            'total' => 1500,
            'amount' => 1500,
            'status' => 'Confirmed',
            'payment_status' => 'Paid',
            'payment_method' => 'UPI',
            'order_status' => 'Confirmed',
            'delivery_status' => 'Pending',
            'items' => [[
                'product_id' => $product->id,
                'seller_id' => $seller->id,
                'name' => 'Smart Lamp',
                'quantity' => 1,
                'price' => 1500,
            ]],
        ]);

        session(['seller_login' => true, 'seller_id' => $seller->id]);

        $response = $this->post('/seller/orders/' . $order->id . '/status', [
            'order_status' => 'Packed',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_status' => 'Packed',
        ]);
    }
}
