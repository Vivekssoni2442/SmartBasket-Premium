<?php

namespace Tests\Feature;

use App\Models\AICameraHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VirtualTryOnTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_virtual_try_on_endpoint_does_not_fake_an_image_result()
    {
        $image = public_path('products/1785564606.jpg');

        if (! file_exists($image)) {
            $this->markTestSkipped('No sample image available for virtual try-on test.');
        }

        $response = $this->post('/ai-camera-assistant/virtual-try-on', [
            'image' => new \Illuminate\Http\UploadedFile($image, 'sample.jpg', 'image/jpeg', null, true),
            'label' => 'Test Outfit',
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertUnprocessable();
        $response->assertJson([
            'success' => false,
        ]);
    }

    public function test_legacy_virtual_try_on_does_not_store_customer_images_or_history()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $image = public_path('products/1785564606.jpg');

        if (! file_exists($image)) {
            $this->markTestSkipped('No sample image available for virtual try-on test.');
        }

        $response = $this->post('/ai-camera-assistant/virtual-try-on', [
            'image' => new \Illuminate\Http\UploadedFile($image, 'sample.jpg', 'image/jpeg', null, true),
            'label' => 'Test Outfit',
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertUnprocessable();
        $this->assertDatabaseMissing('ai_camera_histories', ['user_id' => $user->id]);
    }
}
