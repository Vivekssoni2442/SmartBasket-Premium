<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\AdminAuditLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use App\Services\CheckoutOrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminAccountManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(string $role = 'admin'): Admin
    {
        return Admin::create([
            'name' => 'Account Admin',
            'email' => 'admin-'.$role.'@example.test',
            'password' => bcrypt('Password1!'),
            'role' => $role,
            'status' => 'active',
        ]);
    }

    private function sessionFor(Admin $admin): array
    {
        return ['admin_authenticated' => true, 'admin_id' => $admin->id, 'admin_name' => $admin->name];
    }

    private function seller(array $attributes = []): SellerProfile
    {
        return SellerProfile::create(array_merge([
            'seller_name' => 'Sample Seller',
            'shop_name' => 'Sample Shop',
            'email' => 'seller@example.test',
            'password' => bcrypt('Password1!'),
            'verification_status' => SellerProfile::STATUS_ACTIVE,
        ], $attributes));
    }

    public function test_admin_can_list_and_block_unblock_customer_and_audit_each_change(): void
    {
        $admin = $this->admin();
        $customer = User::factory()->create(['name' => 'Test Customer']);
        $session = $this->sessionFor($admin);

        $this->withSession($session)->get(route('admin.customers.index'))
            ->assertOk()->assertSee('Test Customer')->assertSee('Block reason');

        $this->withSession($session)->post(route('admin.customers.block', $customer), ['reason' => 'Repeated payment abuse'])
            ->assertRedirect()->assertSessionHas('success');
        $this->assertNotNull($customer->fresh()->blocked_at);
        $this->assertDatabaseHas('admin_audit_logs', ['admin_id' => $admin->id, 'action' => 'customer.block', 'entity_id' => (string) $customer->id]);

        $this->withSession($session)->post(route('admin.customers.unblock', $customer))->assertRedirect();
        $this->assertNull($customer->fresh()->blocked_at);
        $this->assertSame(2, AdminAuditLog::where('entity_id', (string) $customer->id)->count());
    }

    public function test_blocked_customer_cannot_login_or_use_an_existing_session(): void
    {
        $customer = User::factory()->create(['password' => bcrypt('Password1!'), 'blocked_at' => now()]);

        $this->post(route('login.submit'), ['email' => $customer->email, 'password' => 'Password1!'])
            ->assertRedirect()->assertSessionHas('error');

        $this->actingAs($customer)->get(route('dashboard'))
            ->assertRedirect(route('login'))->assertSessionHas('error');
    }

    public function test_admin_can_block_seller_without_changing_verification_status_and_seller_access_is_denied(): void
    {
        $admin = $this->admin();
        $seller = $this->seller();
        $session = $this->sessionFor($admin);

        $this->withSession($session)->get(route('admin.sellers.index'))->assertOk()->assertSee('Sample Seller');
        $this->withSession($session)->post(route('admin.sellers.block', $seller), ['reason' => 'Policy review'])->assertRedirect();

        $this->assertNotNull($seller->fresh()->blocked_at);
        $this->assertSame(SellerProfile::STATUS_ACTIVE, $seller->fresh()->verification_status);
        $this->post(route('seller.login.submit'), ['email' => $seller->email, 'password' => 'Password1!'])
            ->assertRedirect()->assertSessionHas('error');
        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])->get(route('seller.dashboard'))
            ->assertRedirect('/seller-login')->assertSessionHas('error');

        $this->withSession($session)->post(route('admin.sellers.unblock', $seller))->assertRedirect();
        $this->assertNull($seller->fresh()->blocked_at);
        $this->assertSame(SellerProfile::STATUS_ACTIVE, $seller->fresh()->verification_status);
    }

    public function test_non_admin_cannot_manage_accounts_and_only_super_admin_can_deactivate(): void
    {
        $customer = User::factory()->create();
        $seller = $this->seller();
        $this->actingAs($customer)->get(route('admin.customers.index'))->assertForbidden();
        Auth::logout();
        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])->get(route('admin.customers.index'))->assertRedirect('/admin/login');

        $admin = $this->admin();
        $moderator = $this->admin('moderator');
        $this->withSession($this->sessionFor($moderator))->get(route('admin.customers.index'))->assertForbidden();
        $this->withSession($this->sessionFor($admin))->delete(route('admin.customers.delete', $customer), ['confirmation' => 'DELETE'])->assertForbidden();

        $root = $this->admin('super_admin');
        $this->withSession($this->sessionFor($root))->delete(route('admin.customers.delete', $customer), ['confirmation' => 'DELETE'])->assertRedirect();
        $this->assertSoftDeleted('users', ['id' => $customer->id]);
        $this->assertDatabaseHas('admin_audit_logs', ['admin_id' => $root->id, 'action' => 'customer.deactivate']);
        $this->assertNotNull($seller->fresh());
    }

    public function test_deactivation_requires_typed_confirmation_and_retains_order_history(): void
    {
        $root = $this->admin('super_admin');
        $customer = User::factory()->create();
        $order = Order::create([
            'user_id' => $customer->id,
            'name' => $customer->name,
            'mobile' => '1234567890',
            'address' => '1 Test Road',
            'city' => 'Test City',
            'total' => 120,
            'status' => 'Pending',
        ]);

        $this->withSession($this->sessionFor($root))->delete(route('admin.customers.delete', $customer), ['confirmation' => 'REMOVE'])->assertSessionHasErrors('confirmation');
        $this->assertDatabaseHas('users', ['id' => $customer->id, 'deleted_at' => null]);

        $this->withSession($this->sessionFor($root))->delete(route('admin.customers.delete', $customer), ['confirmation' => 'DELETE'])->assertRedirect();
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'user_id' => $customer->id]);
        $this->assertSoftDeleted('users', ['id' => $customer->id]);
    }

    public function test_blocked_sellers_products_are_hidden_and_cannot_be_checked_out(): void
    {
        $seller = $this->seller(['verification_status' => SellerProfile::STATUS_ACTIVE]);
        $product = Product::create([
            'seller_id' => $seller->id,
            'name' => 'Test Listing',
            'category' => 'Accessories',
            'price' => 250,
            'stock' => 5,
            'status' => 'active',
        ]);
        $seller->forceFill(['blocked_at' => now()])->save();

        $this->assertDatabaseHas('products', ['id' => $product->id]);
        $this->assertFalse(Product::query()->customerVisible()->whereKey($product->id)->exists());

        try {
            app(CheckoutOrderService::class)->assertCheckoutCanProceed([
                $seller->id => [['product_id' => $product->id, 'quantity' => 1, 'price' => '250.00']],
            ], 'Cash on Delivery');
            $this->fail('A blocked seller checkout should be rejected.');
        } catch (\RuntimeException $exception) {
            $this->assertSame('A seller is currently unavailable. Please review your cart.', $exception->getMessage());
        }
    }

    public function test_super_admin_can_restore_deactivated_seller(): void
    {
        $root = $this->admin('super_admin');
        $seller = $this->seller();
        $product = Product::create([
            'seller_id' => $seller->id,
            'name' => 'Retained Seller Listing',
            'category' => 'Accessories',
            'price' => 250,
            'stock' => 5,
            'status' => 'active',
        ]);
        $this->withSession($this->sessionFor($root))->delete(route('admin.sellers.delete', $seller), ['confirmation' => 'DELETE'])->assertRedirect();
        $this->assertSoftDeleted('seller_profiles', ['id' => $seller->id]);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'seller_id' => $seller->id]);

        $this->withSession($this->sessionFor($root))->post(route('admin.sellers.restore', $seller->id))->assertRedirect();
        $this->assertNotNull(SellerProfile::find($seller->id));
        $this->assertDatabaseHas('admin_audit_logs', ['admin_id' => $root->id, 'action' => 'seller.restore']);
    }
}
