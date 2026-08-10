<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerOrderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_can_update_order_status(): void
    {
        $order = Order::create([
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
                'name' => 'Smart Lamp',
                'quantity' => 1,
                'price' => 1500,
            ]],
        ]);

        session(['seller_login' => true]);

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
