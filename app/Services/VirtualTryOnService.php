<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Creates a real image-editing request from a customer photo and the exact
 * product image selected by the server. It intentionally has no fallback:
 * compositing, pass-through images, and text-only responses are not try-on.
 */
class VirtualTryOnService
{
    public function isConfigured(): bool
    {
        return config('services.virtual_tryon.provider') === 'openai'
            && filled(config('services.virtual_tryon.openai.key'));
    }

    public function generateFromFiles(string $customerPath, string $customerMime, string $productPath, string $productMime, string $productName, string $category, string $description = '', string $attributes = ''): array
    {
        if (! $this->isConfigured()) {
            return $this->failure('not_configured');
        }

        try {
            $payload = [
                'model' => config('services.virtual_tryon.openai.model'),
                'size' => config('services.virtual_tryon.openai.size', '1024x1024'),
                'quality' => config('services.virtual_tryon.quality', 'high'),
                'output_format' => 'png',
                'images' => [
                    ['image_url' => $this->dataUrl($customerPath, $customerMime)],
                    ['image_url' => $this->dataUrl($productPath, $productMime)],
                ],
                'prompt' => $this->prompt($productName, $category, $description, $attributes),
            ];
            if (in_array($payload['model'], ['gpt-image-1', 'gpt-image-1.5'], true)) {
                $payload['input_fidelity'] = 'high';
            }

            $response = Http::acceptJson()
                ->timeout((int) config('services.virtual_tryon.timeout', 120))
                ->withToken(config('services.virtual_tryon.openai.key'))
                ->post(rtrim(config('services.virtual_tryon.openai.url'), '/'), $payload);
        } catch (ConnectionException $exception) {
            Log::warning('Virtual try-on provider connection failed.', ['exception' => $exception->getMessage()]);
            return $this->failure('unavailable');
        } catch (\Throwable $exception) {
            Log::error('Virtual try-on provider request could not be completed.', ['exception' => $exception->getMessage()]);
            return $this->failure('unavailable');
        }

        if ($response->failed()) {
            Log::warning('Virtual try-on provider request failed.', [
                'status' => $response->status(),
                'response' => str($response->body())->limit(1000)->toString(),
            ]);

            return $this->failure(match ($response->status()) {
                401 => 'authentication', 403 => 'permission', 404 => 'model_unavailable',
                429 => 'rate_limited', default => 'unavailable',
            });
        }

        $image = $response->json('data.0.b64_json');
        if (! is_string($image) || $image === '' || ($binary = base64_decode($image, true)) === false) {
            Log::warning('Virtual try-on provider returned no image.', ['response' => str($response->body())->limit(1000)->toString()]);
            return $this->failure('unavailable');
        }

        return ['success' => true, 'binary' => $binary, 'mime' => 'image/png'];
    }

    private function prompt(string $productName, string $category, string $description, string $attributes): string
    {
        $details = mb_substr(trim(implode(' ', array_filter([$description, $attributes]))), 0, 1000);
        return "Create a realistic virtual try-on edit using BOTH supplied images. Image 1 is the source photograph: preserve this same person's recognizable face, identity, hair, pose, body proportions, lighting, and background. Image 2 is the exact product sold as '{$productName}' in category '{$category}'. Apply that specific product to the person, changing only the relevant clothing region. Preserve its actual visible color, cut, pattern, shape, and details; do not substitute or invent a different item. Product notes: {$details}. Make a natural, photorealistic preview. Do not make a collage or show the product separately. The result is an approximate visual preview, not a fit guarantee.";
    }

    private function dataUrl(string $path, string $mime): string
    {
        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
    }

    private function failure(string $reason): array
    {
        return ['success' => false, 'reason' => $reason, 'message' => $reason === 'not_configured'
            ? 'AI Virtual Try-On is currently unavailable. Please configure a supported image-generation provider.'
            : 'AI Virtual Try-On is temporarily unavailable. Please try again later.'];
    }
}
