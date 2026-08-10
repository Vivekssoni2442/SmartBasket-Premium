<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DebugCameraAnalyzeTest extends TestCase
{
    public function test_debug_analyze()
    {
        $image = public_path('products/1785564606.jpg');
        if (! file_exists($image)) {
            $this->fail('No image');
        }

        $response = $this->post('/ai-camera-assistant', [
            'query' => 'best casual outfit',
        ], [], [
            'image' => new \Illuminate\Http\UploadedFile($image, 'sample.jpg', 'image/jpeg', null, true),
        ]);

        fwrite(STDERR, "\n\nSTATUS: " . $response->getStatusCode() . "\n");
        fwrite(STDERR, "CONTENT: " . substr(strip_tags($response->getContent()), 0, 2000) . "\n\n");
        $response->assertOk();
    }
}
