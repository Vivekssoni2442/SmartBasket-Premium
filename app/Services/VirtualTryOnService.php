<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Virtual Try-On Service
|--------------------------------------------------------------------------
| Provider-agnostic processing structure for the AI Camera Assistant
| "Virtual Try-On" feature.
|
| This service receives the user's uploaded/captured image (and an optional
| selected garment/product) and produces a temporary processed "result"
| image. In the current offline placeholder mode it builds a server-side
| composite (the source photo + a garment thumbnail from the existing
| product database) so the full pipeline is demonstrable end-to-end.
|
| AI-MODEL INTEGRATION HOOK
| ------------------------
| Swap the real model later without touching the controller: set
| config('services.ai_vision.provider', 'groq' | 'openai' | ...) and add a
| matching private `buildWith<Provider>(...)` method, or extend
| `generate` to call an external Vision API. The returned payload shape is
| identical regardless of provider.
|
| Privacy: the source image is saved temporarily only so it can be shown in
| the user's own history. It is stored under /virtual-tryon and can be
| removed via the history delete flow.
*/

class VirtualTryOnService
{
    /**
     * Process a source image into a virtual try-on result.
     *
     * @param string $imageBinary  Raw image bytes of the source photo.
     * @param string $mime         Detected mime of the source photo.
     * @param string|null $garmentImage Absolute path or URL of a garment image (optional).
     * @param string|null $garmentLabel Human friendly label for the garment (optional).
     * @return array{
     *     success: bool,
     *     result_image: string|null,
     *     message: string,
     *     processor: string,
     *     meta?: array
     * }
     */
    public function generate(string $imageBinary, string $mime, ?string $garmentImage = null, ?string $garmentLabel = null): array
    {
        try {
            $provider = config('services.ai_vision.provider', 'local');

            // Future hook: switch to a provider-specific builder when a real
            // AI model is available. For now all providers produce the
            // offline composite so the pipeline stays functional.
            $output = $this->buildOfflineComposite($imageBinary, $mime, $garmentImage);

            if (! $output) {
                return [
                    'success'      => false,
                    'result_image' => null,
                    'processor'    => $provider,
                    'message'      => 'Unable to generate the virtual try-on result.',
                ];
            }

            // Store the processed image under the public disk so it can be
            // shown and downloaded (tokenless, user-scoped deletion via history).
            $fileName = 'vto-' . Str::random(24) . '.' . $output['ext'];
            Storage::disk('public')->put(
                'virtual-tryon/' . $fileName,
                $output['binary']
            );

            return [
                'success'      => true,
                'result_image' => 'virtual-tryon/' . $fileName,
                'processor'    => $provider,
                'message'      => 'Virtual try-on complete. A placeholder composite was generated offline.',
                'meta'         => [
                    'width'   => $output['width'],
                    'height'  => $output['height'],
                    'garment' => $garmentLabel,
                    'mode'    => 'offline-composite',
                ],
            ];
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Virtual Try-On failed: ' . $e->getMessage());

            return [
                'success'      => false,
                'result_image' => null,
                'processor'    => config('services.ai_vision.provider', 'local'),
                'message'      => 'Virtual try-on could not be processed.',
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Offline placeholder composite (default demo pipeline)
    |--------------------------------------------------------------------------
    | Builds a single output image: the source photo with a styled overlay
    | header and, when a garment is provided, a garment chip overlaid.
    | Requires GD. If GD is missing it falls back to passing the source
    | through unchanged (the pipeline still returns a valid result image).
    */
    private function buildOfflineComposite(string $imageBinary, string $mime, ?string $garmentImage): ?array
    {
        // Resolve the actual file extension for storage.
        $ext = match ($mime) {
            'image/png'  => 'png',
            'image/webp' => 'webp',
            default      => 'jpg',
        };

if (! function_exists('imagecreatefromstring')) {
            // No GD available: persist the original bytes so the flow works.
            // We cannot inspect dimensions without GD, so use a safe default.
            return [
                'binary' => $imageBinary,
                'ext'    => $ext,
                'width'  => 640,
                'height' => 800,
            ];
        }

        $source = @imagecreatefromstring($imageBinary);
        if ($source === false) {
            return null;
        }

        $srcW = imagesx($source);
        $srcH = imagesy($source);

        // Constrain to a reasonable canvas preserving aspect ratio.
        $maxW = 900;
        $maxH = 1200;
        $ratio = min($maxW / $srcW, $maxH / $srcH, 1.0);
        $newW = (int) round($srcW * $ratio);
        $newH = (int) round($srcH * $ratio);

        $canvas = imagecreatetruecolor($newW, $newH);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newW, $newH, $srcW, $srcH);

        // Dark translucent header band (glassmorphism-inspired accent).
        $bandH = (int) round($newH * 0.14);
        $band  = imagecreatetruecolor($newW, $bandH);
        imagealphablending($band, false);
        imagesavealpha($band, true);
        $fill = imagecolorallocatealpha($band, 15, 23, 42, 95);
        imagefill($band, 0, 0, $fill);
        imagecopy($canvas, $band, 0, 0, 0, 0, $newW, $bandH);
        imagedestroy($band);

        // Garment chip if available.
        if ($garmentImage && file_exists($garmentImage)) {
            $garment = @imagecreatefromstring((string) file_get_contents($garmentImage));
            if ($garment !== false) {
                $chipSize = (int) round($newW * 0.16);
                $gW = imagesx($garment);
                $gH = imagesy($garment);
                $gRatio = min($chipSize / $gW, $chipSize / $gH, 1.0);
                $gNewW = max(1, (int) round($gW * $gRatio));
                $gNewH = max(1, (int) round($gH * $gRatio));
                $gResized = imagecreatetruecolor($gNewW, $gNewH);
                imagealphablending($gResized, false);
                imagesavealpha($gResized, true);
                imagecopyresampled($gResized, $garment, 0, 0, 0, 0, $gNewW, $gNewH, $gW, $gH);
                // Place in the top-right.
                $pad = (int) round($newW * 0.03);
                imagecopy($canvas, $gResized, $newW - $gNewW - $pad, (int) round($bandH / 2 - $gNewH / 2), 0, 0, $gNewW, $gNewH);
                imagedestroy($gResized);
                imagedestroy($garment);
            }
        }

        // Encode to PNG (lossless) for the result.
        ob_start();
        imagepng($canvas);
        $binary = (string) ob_get_clean();
        imagedestroy($canvas);
        imagedestroy($source);

        return [
            'binary' => $binary,
            'ext'    => 'png',
            'width'  => $newW,
            'height' => $newH,
        ];
    }
}

