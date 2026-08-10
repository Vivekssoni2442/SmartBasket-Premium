<?php

namespace Tests\Feature;

use App\Models\AICameraHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VirtualTryOnTest extends TestCase
{
    use RefreshDatabase;

    public function test_virtual_try_on_endpoint_returns_json_result()
    {
        $image = public_path('products/1785564606.jpg');

        if (! file_exists($image)) {
            $this->markTestSkipped('No sample image available for virtual try-on test.');
        }

        $response = $this->post('/ai-camera-assistant/virtual-try-on', [
            'image' => new \Illuminate\Http\UploadedFile($image, 'sample.jpg', 'image/jpeg', null, true),
            'label' => 'Test Outfit',
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'success',
            'message',
            'processor',
            'result_image',
            'meta',
        ]);
    }

    public function test_virtual_try_on_saves_history_for_logged_in_user()
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

        $response->assertOk();
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('ai_camera_histories', [
            'user_id' => $user->id,
            'query'   => 'Virtual Try-On: Test Outfit',
        ]);
    }
}
