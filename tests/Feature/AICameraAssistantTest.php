<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AICameraAssistantTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The AI Camera Assistant full page renders without Blade errors.
     */
    public function test_ai_camera_assistant_page_renders()
    {
        $response = $this->get('/ai-camera-assistant');

        $response->assertOk();
        $response->assertSee('AI Camera Assistant');
        $response->assertSee('caAnalyzeForm');
    }

    /**
     * The AI Camera Assistant sidebar fragment renders.
     */
    public function test_ai_camera_assistant_sidebar_renders()
    {
        $response = $this->get('/ai-camera-assistant?sidebar=1');

        $response->assertOk();
        $response->assertSee('AI Camera Assistant');
        $response->assertSee('caAnalyzeForm');
    }

    /**
     * The AI HUB index page renders.
     */
    public function test_ai_hub_index_renders()
    {
        $response = $this->get('/ai-hub');

        $response->assertOk();
        $response->assertSee('AI HUB');
    }

    /**
     * The AI analyze endpoint processes an image and returns analysis
     * with recommendations.
     */
    public function test_ai_camera_assistant_analyze_workflow()
    {
        $image = public_path('products/1785564606.jpg');

        if (! file_exists($image)) {
            $this->markTestSkipped('No sample image available for analyze test.');
        }

        $response = $this->post('/ai-camera-assistant', [
            'query' => 'best casual outfit',
        ], [], [
            'image' => new \Illuminate\Http\UploadedFile($image, 'sample.jpg', 'image/jpeg', null, true),
        ]);

        $response->assertOk();
        $response->assertSee('AI Camera Assistant');
    }
}
