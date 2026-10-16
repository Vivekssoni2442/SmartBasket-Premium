<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Order;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AdminFeatureSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::forget('site-settings.all');
    }

    public function test_admin_feature_controls_persist_and_gate_customer_and_seller_registration(): void
    {
        $admin = Admin::create([
            'name' => 'Settings Admin',
            'email' => 'settings-admin@example.test',
            'password' => bcrypt('Password1!'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);
        $session = ['admin_authenticated' => true, 'admin_id' => $admin->id];

        $this->get(route('register'))->assertOk();
        $this->get(route('seller.register'))->assertOk();

        $this->withSession($session)->put(route('admin.settings.features.update'), [
            'customer_registration_enabled' => '0',
            'seller_registration_enabled' => '0',
            'return_requests_enabled' => '1',
        ])->assertRedirect(route('admin.settings'));

        $this->assertDatabaseHas('site_settings', ['key' => 'customer_registration_enabled', 'value' => '0']);
        $this->assertDatabaseHas('site_settings', ['key' => 'seller_registration_enabled', 'value' => '0']);
        $this->assertDatabaseHas('admin_audit_logs', ['action' => 'update_store_features']);
        $this->get(route('register'))->assertNotFound();
        $this->post(route('register.submit'), [])->assertNotFound();
        $this->get(route('seller.register'))->assertNotFound();
        $this->post(route('seller.register.submit'), [])->assertNotFound();
        $this->get(route('login'))->assertOk()->assertDontSee('Create Account');
        $this->get(route('seller.login'))->assertOk()->assertDontSee('Create a Seller Account');
    }

    public function test_disabled_return_requests_are_rejected_on_submission_route(): void
    {
        $customer = User::factory()->create();
        $order = Order::create([
            'user_id' => $customer->id,
            'name' => $customer->name,
            'mobile' => '9876543210',
            'address' => '10 Test Road',
            'city' => 'Test City',
            'total' => 100,
            'amount' => 100,
            'status' => 'Delivered',
            'order_status' => 'Delivered',
            'delivery_status' => 'Delivered',
            'payment_status' => 'Paid',
            'items' => [['product_id' => 9001, 'name' => 'Test Product', 'price' => 100, 'quantity' => 1]],
        ]);
        SiteSetting::create(['key' => 'return_requests_enabled', 'value' => '0']);

        $this->actingAs($customer)->post(route('returns.store', $order), [
            'items' => [['product_id' => 9001, 'quantity' => 1]],
            'reason' => 'damaged',
        ])->assertNotFound();
    }
}
