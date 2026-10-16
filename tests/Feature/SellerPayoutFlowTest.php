<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Order;
use App\Models\SellerEarning;
use App\Models\SellerPayout;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerPayoutFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_payout_request_reserves_earnings_and_prevents_a_duplicate_request(): void
    {
        [$seller, $earning] = $this->availableEarning('150.25');

        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])
            ->post(route('seller.payouts.request'), ['amount' => '150.25'])
            ->assertSessionHas('success');

        $payout = SellerPayout::firstOrFail();
        $this->assertSame('payout_requested', $earning->fresh()->status);
        $this->assertSame('150.25', (string) $payout->earnings()->firstOrFail()->pivot->amount);
        $this->assertDatabaseCount('seller_payout_earnings', 1);

        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])
            ->post(route('seller.payouts.request'), ['amount' => '150.25'])
            ->assertStatus(422);

        $this->assertDatabaseCount('seller_payouts', 1);
    }

    public function test_admin_rejection_releases_earnings_and_paid_status_requires_reference(): void
    {
        [$seller, $earning] = $this->availableEarning('220.00');
        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])
            ->post(route('seller.payouts.request'), ['amount' => '220.00'])
            ->assertSessionHas('success');
        $payout = SellerPayout::firstOrFail();
        $admin = Admin::create([
            'name' => 'Payment Administrator',
            'email' => 'payout-admin@example.test',
            'password' => bcrypt('Password1!'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);

        $session = ['admin_authenticated' => true, 'admin_id' => $admin->id];
        $this->withSession($session)
            ->patch(route('admin.payouts.update', $payout), ['status' => 'paid'])
            ->assertStatus(422);
        $this->assertSame('payout_requested', $earning->fresh()->status);

        $this->withSession($session)
            ->patch(route('admin.payouts.update', $payout), [
                'status' => 'paid',
                'reference' => 'bank-transfer-001',
            ])
            ->assertSessionHas('success');

        $this->assertSame('paid', $earning->fresh()->status);
        $this->assertSame('paid', $payout->fresh()->status);
        $this->assertSame('bank-transfer-001', $payout->fresh()->reference);
    }

    private function availableEarning(string $amount): array
    {
        $seller = SellerProfile::create([
            'seller_name' => 'Payout Seller',
            'shop_name' => 'Payout Shop',
            'email' => 'payout-seller@example.test',
            'mobile_number' => '9999999999',
            'password' => bcrypt('Password1!'),
        ]);
        $customer = User::factory()->create();
        $order = Order::create([
            'user_id' => $customer->id,
            'seller_id' => $seller->id,
            'name' => $customer->name,
            'mobile' => '9876543210',
            'address' => 'Payout Street',
            'city' => 'Pune',
            'total' => $amount,
            'amount' => $amount,
            'status' => 'Confirmed',
            'payment_status' => 'Paid',
            'payment_method' => 'UPI',
            'order_status' => 'Placed',
            'delivery_status' => 'Pending',
            'items' => [],
        ]);
        $earning = SellerEarning::create([
            'seller_id' => $seller->id,
            'order_id' => $order->id,
            'gross_amount' => $amount,
            'platform_fee' => '0.00',
            'net_amount' => $amount,
            'status' => 'available',
        ]);

        return [$seller, $earning];
    }
}
