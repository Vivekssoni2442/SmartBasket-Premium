<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_authenticated_admin_can_save_about_content_and_customers_see_latest_escaped_copy(): void
    {
        $admin = Admin::create([
            'name' => 'About Admin',
            'email' => 'about-admin@example.test',
            'password' => bcrypt('Password1!'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);

        $this->put(route('admin.settings.about.update'), ['introduction' => 'Unauthorized'])
            ->assertRedirect('/admin/login');

        $this->withSession([
            'admin_authenticated' => true,
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
        ])->get(route('admin.settings'))
            ->assertOk()
            ->assertSee('About Smart Basket')
            ->assertSee('Save About Information');

        $this->withSession([
            'admin_authenticated' => true,
            'admin_id' => $admin->id,
        ])->put(route('admin.settings.about.update'), [
            'title' => 'About our shop',
            'introduction' => '<script>alert(1)</script>Friendly store',
            'mission' => 'Make shopping easy.',
            'vision' => '',
            'services' => 'Product discovery',
            'additional_information' => '',
        ])->assertRedirect(route('admin.settings'))
            ->assertSessionHas('success');

        $customer = User::factory()->create();
        $this->actingAs($customer)->get(route('settings'))
            ->assertOk()
            ->assertSee('About our shop')
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;Friendly store', false)
            ->assertDontSee('<script>alert(1)</script>Friendly store', false);

        $this->withSession([
            'admin_authenticated' => true,
            'admin_id' => $admin->id,
        ])->put(route('admin.settings.about.update'), [
            'title' => 'Updated About',
            'introduction' => 'Latest copy',
        ])->assertSessionHas('success');

        $this->actingAs($customer)->get(route('settings'))
            ->assertSee('Updated About')
            ->assertSee('Latest copy');

        $this->flushSession();
        $this->actingAs($customer)->put(route('admin.settings.about.update'), [
            'introduction' => 'Customer edit',
        ])->assertForbidden();

        $this->assertDatabaseHas('about_contents', [
            'id' => 1,
            'introduction' => 'Latest copy',
        ]);
    }

    public function test_customer_about_section_handles_empty_database_content(): void
    {
        $customer = User::factory()->create();

        $this->actingAs($customer)->get(route('settings'))
            ->assertOk()
            ->assertSee('About information will be available here soon.');
    }
}
