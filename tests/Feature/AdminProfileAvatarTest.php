<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProfileAvatarTest extends TestCase
{
    use RefreshDatabase;

    private function profileSession(Admin $admin): array
    {
        return ['admin_authenticated' => true, 'admin_id' => $admin->id, 'admin_name' => $admin->name];
    }

    private function admin(): Admin
    {
        return Admin::create(['name' => 'Profile Admin', 'email' => 'profile-admin@example.test', 'password' => bcrypt('Password1!'), 'role' => 'admin', 'status' => 'active']);
    }

    private function png(int $sizeBytes, string $name = 'avatar.png'): UploadedFile
    {
        $bytes = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/l9sAAAAASUVORK5CYII=', true);
        $bytes = str_pad($bytes, $sizeBytes, "\0");

        return UploadedFile::fake()->createWithContent($name, $bytes);
    }

    public function test_admin_can_upload_a_five_megabyte_avatar_and_old_file_is_removed_after_save(): void
    {
        Storage::fake('public');
        $admin = $this->admin();
        Storage::disk('public')->put('admin-avatars/old.png', 'old-avatar');
        $admin->update(['avatar' => 'old.png']);

        $this->withSession($this->profileSession($admin))->put(route('admin.profile.update'), [
            'name' => 'Profile Admin',
            'email' => $admin->email,
            'avatar' => $this->png(200 * 1024, 'small-avatar.png'),
        ])->assertRedirect(route('admin.profile'))->assertSessionHas('success');
        $smallAvatar = $admin->fresh()->avatar;
        Storage::disk('public')->assertExists('admin-avatars/' . $smallAvatar);

        $this->withSession($this->profileSession($admin))->put(route('admin.profile.update'), [
            'name' => 'Updated Admin',
            'email' => $admin->email,
            'avatar' => $this->png(5 * 1024 * 1024, 'new-avatar.png'),
        ])->assertRedirect(route('admin.profile'))->assertSessionHas('success');

        $admin->refresh();
        $this->assertNotSame('old.png', $admin->avatar);
        $this->assertNotSame($smallAvatar, $admin->avatar);
        Storage::disk('public')->assertExists('admin-avatars/' . $admin->avatar);
        Storage::disk('public')->assertMissing('admin-avatars/old.png');
        Storage::disk('public')->assertMissing('admin-avatars/' . $smallAvatar);
        $this->assertSame('Updated Admin', $admin->name);
    }

    public function test_oversized_or_non_image_upload_is_rejected_without_removing_current_avatar(): void
    {
        Storage::fake('public');
        $admin = $this->admin();
        Storage::disk('public')->put('admin-avatars/current.png', 'previous');
        $admin->update(['avatar' => 'current.png']);

        $this->withSession($this->profileSession($admin))->put(route('admin.profile.update'), [
            'name' => $admin->name,
            'email' => $admin->email,
            'avatar' => $this->png((5 * 1024 * 1024) + 1, 'too-large.png'),
        ])->assertSessionHasErrors('avatar');
        Storage::disk('public')->assertExists('admin-avatars/current.png');

        $this->withSession($this->profileSession($admin))->put(route('admin.profile.update'), [
            'name' => $admin->name,
            'email' => $admin->email,
            'avatar' => UploadedFile::fake()->create('document.pdf', 20, 'application/pdf'),
        ])->assertSessionHasErrors('avatar');
        Storage::disk('public')->assertExists('admin-avatars/current.png');
    }

    public function test_profile_can_be_updated_without_reuploading_avatar_and_unauthenticated_access_is_denied(): void
    {
        Storage::fake('public');
        $admin = $this->admin();
        Storage::disk('public')->put('admin-avatars/current.png', 'current');
        $admin->update(['avatar' => 'current.png']);

        $this->withSession($this->profileSession($admin))->put(route('admin.profile.update'), [
            'name' => 'Name Only', 'email' => $admin->email,
        ])->assertRedirect(route('admin.profile'));
        $this->assertSame('current.png', $admin->fresh()->avatar);
        $this->flushSession();
        $this->get(route('admin.profile'))->assertRedirect('/admin/login');
    }
}
