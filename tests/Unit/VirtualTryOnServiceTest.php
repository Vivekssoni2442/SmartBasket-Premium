<?php

namespace Tests\Unit;

use App\Services\VirtualTryOnService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class VirtualTryOnServiceTest extends TestCase
{
    public function test_image_edit_sends_customer_and_selected_product_images_to_the_provider(): void
    {
        config([
            'services.virtual_tryon.provider' => 'openai',
            'services.virtual_tryon.openai.key' => 'test-key',
            'services.virtual_tryon.openai.url' => 'https://api.openai.com/v1/images/edits',
            'services.virtual_tryon.openai.model' => 'gpt-image-1',
        ]);
        Http::fake(['api.openai.com/*' => Http::response(['data' => [['b64_json' => base64_encode('generated-image')]]])]);

        $customer = tempnam(sys_get_temp_dir(), 'sb-person-');
        $product = tempnam(sys_get_temp_dir(), 'sb-product-');
        file_put_contents($customer, 'customer-image-bytes');
        file_put_contents($product, 'selected-product-image-bytes');

        try {
            $result = app(VirtualTryOnService::class)->generateFromFiles(
                $customer, 'image/jpeg', $product, 'image/png', 'Blue Cotton Shirt', 'Fashion', 'Cotton shirt', 'Blue, size M'
            );

            $this->assertTrue($result['success']);
            $this->assertSame('generated-image', $result['binary']);
            Http::assertSent(function ($request) {
                $images = $request['images'];
                return $request->url() === 'https://api.openai.com/v1/images/edits'
                    && $request['model'] === 'gpt-image-1'
                    && count($images) === 2
                    && $images[0]['image_url'] === 'data:image/jpeg;base64,' . base64_encode('customer-image-bytes')
                    && $images[1]['image_url'] === 'data:image/png;base64,' . base64_encode('selected-product-image-bytes')
                    && str_contains($request['prompt'], 'Blue Cotton Shirt');
            });
        } finally {
            @unlink($customer);
            @unlink($product);
        }
    }

    public function test_missing_provider_credentials_fails_without_faking_a_result(): void
    {
        config(['services.virtual_tryon.provider' => null, 'services.virtual_tryon.openai.key' => null]);
        Http::fake();

        $result = app(VirtualTryOnService::class)->generateFromFiles('unused', 'image/jpeg', 'unused', 'image/png', 'Shirt', 'Fashion');

        $this->assertFalse($result['success']);
        $this->assertSame('not_configured', $result['reason']);
        Http::assertNothingSent();
    }
}
