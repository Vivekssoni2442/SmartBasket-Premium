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

    public function generateFromFiles(string $customerPath, string $customerMime, string $productPath, string $productMime, string $productName, string $category): array
    {
        if (! $this->isConfigured()) {
            return $this->failure('not_configured');
        }

        try {
            $response = Http::acceptJson()
                ->timeout((int) config('services.virtual_tryon.timeout', 90))
                ->withToken(config('services.virtual_tryon.openai.key'))
                ->attach('image[]', fopen($customerPath, 'r'), 'customer.' . $this->extensionFor($customerMime))
                ->attach('image[]', fopen($productPath, 'r'), 'product.' . $this->extensionFor($productMime))
                ->post(rtrim(config('services.virtual_tryon.openai.url'), '/'), [
                    'model' => config('services.virtual_tryon.openai.model'),
                    'size' => config('services.virtual_tryon.openai.size', '1024x1024'),
                    'prompt' => $this->prompt($productName, $category),
                ]);
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

    private function prompt(string $productName, string $category): string
    {
        return "Use the first image as the person reference and the second image as the exact product reference. Create a realistic virtual try-on preview of the {$category} '{$productName}' being worn or used by that person. Preserve the person's identity, face, hair, pose, body proportions, and background. Preserve the product's exact design, pattern, colour, logo, shape, and important details. Do not invent or substitute another product. This is a visual reference only and not a guarantee of size or fit.";
    }

    private function extensionFor(string $mime): string
    {
        return match ($mime) { 'image/png' => 'png', 'image/webp' => 'webp', default => 'jpg' };
    }

    private function failure(string $reason): array
    {
        return ['success' => false, 'reason' => $reason, 'message' => $reason === 'not_configured'
            ? 'AI Virtual Try-On is currently unavailable. Please configure a supported image-generation provider.'
            : 'AI Virtual Try-On is temporarily unavailable. Please try again later.'];
    }
}
