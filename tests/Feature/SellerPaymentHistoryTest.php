<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerPaymentHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_only_sees_their_own_online_payment_history_and_earnings(): void
    {
        $sellerA = $this->seller('a');
        $sellerB = $this->seller('b');
        $productA = Product::create(['seller_id' => $sellerA->id, 'name' => 'A Product', 'category' => 'Test', 'price' => 1000, 'stock' => 1]);
        $productB = Product::create(['seller_id' => $sellerB->id, 'name' => 'B Product', 'category' => 'Test', 'price' => 2000, 'stock' => 1]);
        $rahul = User::factory()->create(['name' => 'Rahul Patel']);
        $priya = User::factory()->create(['name' => 'Priya Shah']);
        $paymentA = $this->payment($sellerA, $productA, $rahul, 1000, 'Paid');
        $secondPaymentA = $this->payment($sellerA, $productA, $rahul, 500, 'Paid');
        $paymentB = $this->payment($sellerB, $productB, $priya, 2000, 'Paid');

        $this->withSession(['seller_login' => true, 'seller_id' => $sellerA->id])
            ->get(route('seller.payments.index'))
            ->assertOk()->assertSee('Rahul Patel')->assertSee($rahul->customer_uid, false)->assertDontSee('Priya Shah');
        $this->withSession(['seller_login' => true, 'seller_id' => $sellerA->id])
            ->get(route('seller.payments.show', $paymentB))->assertNotFound();
        $this->withSession(['seller_login' => true, 'seller_id' => $sellerA->id])
            ->get(route('seller.dashboard'))->assertOk()->assertSee('1,500');
        $this->assertSame($rahul->customer_uid, $secondPaymentA->user->customer_uid);
    }

    private function seller(string $suffix): SellerProfile
    {
        return SellerProfile::create(['seller_name' => "Seller {$suffix}", 'shop_name' => "Shop {$suffix}", 'email' => "{$suffix}@example.test", 'mobile_number' => '9999999999', 'password' => bcrypt('Password1!'), 'online_payments_enabled' => true]);
    }

    private function payment(SellerProfile $seller, Product $product, User $customer, int $total, string $status): Order
    {
        return Order::create(['user_id' => $customer->id, 'seller_id' => $seller->id, 'name' => $customer->name, 'mobile' => '9999999999', 'address' => 'Address', 'city' => 'Pune', 'total' => $total, 'amount' => $total, 'status' => 'Confirmed', 'payment_method' => 'UPI', 'payment_status' => $status, 'order_status' => 'Confirmed', 'delivery_status' => 'Pending', 'items' => [['product_id' => $product->id, 'seller_id' => $seller->id, 'name' => $product->name, 'quantity' => 1, 'price' => $total]]]);
    }
}
