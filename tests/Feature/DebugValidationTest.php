<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DebugValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_capture_validation_errors()
    {
        $image = public_path('products/1785564606.jpg');
        if (! file_exists($image)) {
            $this->fail('No image');
        }

        $response = $this->from('/ai-camera-assistant')->post('/ai-camera-assistant', [
            'query' => 'best casual outfit',
        ], [], [
            'image' => new \Illuminate\Http\UploadedFile($image, 'sample.jpg', 'image/jpeg', null, true),
        ]);

        fwrite(STDERR, "\nSTATUS: " . $response->getStatusCode() . "\n");

        $errors = session('errors');
        fwrite(STDERR, "ERRORS RAW: " . json_encode($errors) . "\n");
        fwrite(STDERR, "ERRORS TYPE: " . gettype($errors) . "\n");
    }
}
