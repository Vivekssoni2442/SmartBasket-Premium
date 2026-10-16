<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisualWebsiteEditorTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(string $role = 'admin'): Admin
    {
        return Admin::create([
            'name' => 'Design Admin',
            'email' => 'design-' . $role . '@example.test',
            'password' => bcrypt('Password1!'),
            'role' => $role,
            'status' => 'active',
        ]);
    }

    private function adminSession(Admin $admin): array
    {
        return ['admin_authenticated' => true, 'admin_id' => $admin->id, 'admin_name' => $admin->name];
    }

    public function test_editor_routes_require_admin_role_and_reject_customer_accounts(): void
    {
        $this->get(route('admin.visual-editor.index'))->assertRedirect('/admin/login');
        $this->withSession(['seller_login' => true, 'seller_id' => 42])->get(route('admin.visual-editor.index'))->assertRedirect('/admin/login');
        $this->actingAs(User::factory()->create())->get(route('admin.visual-editor.index'))->assertForbidden();

        $moderator = $this->createAdmin('moderator');
        $this->withSession($this->adminSession($moderator))->get(route('admin.visual-editor.index'))->assertForbidden();

        $admin = $this->createAdmin();
        $this->withSession($this->adminSession($admin))->get(route('admin.visual-editor.index'))
            ->assertOk()->assertSee('Visual Website Editor')->assertSee('Welcome hero');
    }

    public function test_admin_can_save_publish_and_rollback_a_persistent_page_design(): void
    {
        $admin = $this->createAdmin();
        $session = $this->adminSession($admin);
        $payload = [
            'page_key' => 'customer.home',
            'component_key' => 'hero',
            'base_revision_id' => 0,
            'change_note' => 'Spring home update',
            'settings' => [
                'background' => '#14213d',
                'text_color' => '#f8fafc',
                'accent' => '#06b6d4',
                'radius' => 28,
                'tablet_radius' => 20,
                'mobile_radius' => 14,
                'shadow' => 'soft',
                'content' => ['title' => 'A new Smart Basket welcome', 'body' => 'A tested database-backed heading.', 'button_label' => 'Shop now'],
            ],
        ];

        $response = $this->withSession($session)->postJson(route('admin.visual-editor.drafts.store'), $payload)
            ->assertOk()->assertJsonPath('success', true);
        $draftId = $response->json('revision_id');
        $this->assertDatabaseHas('website_design_revisions', ['id' => $draftId, 'status' => 'draft', 'created_by' => $admin->id]);

        $this->withSession($session)->get(route('admin.visual-editor.preview', $draftId))
            ->assertOk()->assertSee('A new Smart Basket welcome')->assertSee('#14213d');

        $this->withSession($session)->post(route('admin.visual-editor.publish', $draftId))->assertRedirect();
        $this->assertDatabaseHas('website_design_revisions', ['id' => $draftId, 'status' => 'published']);

        $customer = User::factory()->create();
        $this->actingAs($customer)->get(route('dashboard'))->assertOk()->assertSee('A new Smart Basket welcome');

        $this->withSession($session)->postJson(route('admin.visual-editor.drafts.store'), array_merge($payload, [
            'base_revision_id' => $draftId,
            'settings' => ['background' => '#ffffff', 'content' => ['title' => 'Temporary title']],
        ]))->assertOk();
        $secondDraft = \App\Models\WebsiteDesignRevision::where('status', 'draft')->latest('id')->firstOrFail();
        $this->withSession($session)->post(route('admin.visual-editor.publish', $secondDraft))->assertRedirect();

        $this->withSession($session)->post(route('admin.visual-editor.rollback', $draftId))->assertRedirect();
        $this->assertDatabaseHas('website_design_revisions', ['page_key' => 'customer.home', 'status' => 'published', 'change_note' => 'Restored revision #1']);
        $this->assertStringContainsString('#14213d', app(\App\Services\WebsiteDesignService::class)->renderCss('customer.home'));
        $this->assertStringNotContainsString('seller.dashboard', app(\App\Services\WebsiteDesignService::class)->renderCss('customer.home'));
    }

    public function test_editor_rejects_unsafe_css_and_detects_stale_base_revisions(): void
    {
        $admin = $this->createAdmin();
        $session = $this->adminSession($admin);
        $payload = [
            'page_key' => 'customer.products',
            'component_key' => 'hero',
            'base_revision_id' => 0,
            'settings' => ['background' => 'url(javascript:alert(1))'],
        ];
        $this->withSession($session)->post(route('admin.visual-editor.drafts.store'), $payload)->assertSessionHasErrors('settings.background');

        $valid = array_merge($payload, ['settings' => ['background' => '#123456']]);
        $draft = $this->withSession($session)->postJson(route('admin.visual-editor.drafts.store'), $valid)->assertOk()->json('revision_id');
        $this->withSession($session)->post(route('admin.visual-editor.publish', $draft))->assertRedirect();

        $valid['base_revision_id'] = 0;
        $this->withSession($session)->postJson(route('admin.visual-editor.drafts.store'), $valid)->assertStatus(409);
    }
}
