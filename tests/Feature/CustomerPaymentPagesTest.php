<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Models\Refund;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            ->assertSee((string) $ownPayment->id)
            ->assertSee('pay_customer_001')
            ->assertDontSee((string) $otherPayment->id)
            ->assertDontSee('pay_other_001');
    }

    public function test_customer_cannot_view_another_customers_payment_or_receipt(): void
    {
        $customer = User::factory()->create();
        $otherPayment = $this->payment(User::factory()->create());

        $this->actingAs($customer)->get(route('payments.show', $otherPayment))->assertForbidden();
        $this->actingAs($customer)->get(route('payments.receipt', $otherPayment))->assertForbidden();
    }

    public function test_failed_payment_displays_retry_and_does_not_create_an_order_when_gateway_is_unavailable(): void
    {
        $customer = User::factory()->create();
        $payment = $this->payment($customer, [
            'status' => 'failed',
            'failure_reason' => 'Bank declined the transaction.',
        ]);

        $this->actingAs($customer)
            ->get(route('payments.show', $payment))
            ->assertOk()
            ->assertSee('Retry Payment')
            ->assertSee('Bank declined the transaction.');

        $this->actingAs($customer)
            ->post(route('payments.retry', $payment))
            ->assertRedirect(route('payments.show', $payment));

        $this->assertDatabaseCount('payment_transactions', 1);
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('payment_transactions', ['id' => $payment->id, 'status' => 'failed']);
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
}
