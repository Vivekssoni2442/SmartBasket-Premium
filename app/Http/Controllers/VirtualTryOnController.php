<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\VirtualTryOnService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VirtualTryOnController extends Controller
{
    public function generate(Request $request, Product $product, VirtualTryOnService $service)
    {
        if (! auth()->check()) {
            return $this->reply($request, false, 'Please login to create an AI Virtual Try-On preview.', 401);
        }

        if (! Product::customerVisible()->whereKey($product->getKey())->exists()) {
            return $this->reply($request, false, 'This product is not currently available.', 404);
        }
        $validated = $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'product_image_id' => ['nullable', 'integer'],
            'privacy_consent' => ['accepted'],
        ]);
        $productFile = $this->productFile($product, $validated['product_image_id'] ?? null);
        if (! $productFile) {
            Log::warning('Virtual try-on product image could not be safely resolved.', ['product_id' => $product->id]);
            return $this->reply($request, false, 'AI Virtual Try-On is temporarily unavailable. Please try again later.', 503);
        }

        $photo = $validated['photo'];
        $token = Str::random(40);
        $customerPath = $photo->storeAs('virtual-tryon/' . $token, 'customer.' . $photo->extension(), 'local');
        if (! $customerPath) {
            return $this->reply($request, false, 'Your photo could not be stored securely. Please try again.', 500);
        }
        $customerAbsolute = Storage::disk('local')->path($customerPath);

        try {
            $result = $service->generateFromFiles(
                $customerAbsolute,
                $photo->getMimeType(),
                $productFile['path'],
                $productFile['mime'],
                (string) $product->name,
                (string) $product->category,
                (string) $product->description,
                trim(implode(' ', array_filter([(string) $product->color, (string) $product->size])))
            );
        } finally {
            try {
                Storage::disk('local')->delete($customerPath);
                Storage::disk('local')->deleteDirectory(dirname($customerPath));
            } catch (\Throwable $exception) {
                Log::warning('Virtual try-on temporary customer photo cleanup failed.', ['request_id' => $token]);
            }
        }

        if (! $result['success']) {
            return $this->reply($request, false, $result['message'], $result['reason'] === 'not_configured' ? 503 : 502);
        }

        $resultPath = 'virtual-tryon/results/' . $token . '.png';
        if (! $this->isValidPng($result['binary'])) {
            Log::warning('Virtual try-on provider returned invalid image bytes.', ['product_id' => $product->id]);
            return $this->reply($request, false, 'The AI provider returned an invalid image. Please try again.', 502);
        }
        try {
            Storage::disk('local')->put($resultPath, $result['binary']);
            $this->removeExpiredResults();
        } catch (\Throwable $exception) {
            Log::error('Virtual try-on result could not be stored privately.', ['product_id' => $product->id]);
            return $this->reply($request, false, 'The generated preview could not be saved. Please try again.', 500);
        }
        $request->session()->put('virtual_tryon_results.' . $token, [
            'product_id' => $product->id,
            'path' => $resultPath,
            'expires_at' => now()->addHours(24)->timestamp,
        ]);

        return $this->reply($request, true, 'AI Virtual Try-On Result generated.', 200, [
            'result_url' => route('products.virtual-try-on.result', ['product' => $product, 'token' => $token]),
            'download_url' => route('products.virtual-try-on.download', ['product' => $product, 'token' => $token]),
            'discard_url' => route('products.virtual-try-on.discard', ['product' => $product, 'token' => $token]),
        ]);
    }

    public function generateProductImage(Request $request, Product $product, VirtualTryOnService $service)
    {
        if (! auth()->check()) {
            return $this->reply($request, false, 'Please login to create an AI product image.', 401);
        }
        if (! Product::customerVisible()->whereKey($product->getKey())->exists()) {
            return $this->reply($request, false, 'This product is not currently available.', 404);
        }
        if (! $service->isConfigured()) {
            return $this->reply($request, false, 'AI product image creation has not been configured by the site administrator yet.', 503);
        }

        $validated = $request->validate([
            'prompt' => ['required', 'string', 'min:4', 'max:500'],
            'product_image_id' => ['nullable', 'integer'],
            'privacy_consent' => ['accepted'],
        ]);
        $productFile = $this->productFile($product, $validated['product_image_id'] ?? null);
        if (! $productFile) {
            return $this->reply($request, false, 'A usable product image is unavailable for AI generation.', 422);
        }

        $result = $service->generateProductImage(
            $productFile['path'],
            $productFile['mime'],
            (string) $product->name,
            (string) $product->category,
            (string) $product->description,
            (string) $validated['prompt']
        );
        if (! $result['success']) {
            return $this->reply($request, false, $result['message'], $result['reason'] === 'not_configured' ? 503 : 502);
        }
        if (! $this->isValidPng($result['binary'])) {
            Log::warning('Product image assistant provider returned invalid image bytes.', ['product_id' => $product->id]);
            return $this->reply($request, false, 'The AI provider returned an invalid image. Please try again.', 502);
        }

        $token = Str::random(40);
        $resultPath = 'ai-product/results/' . $token . '.png';
        try {
            Storage::disk('local')->put($resultPath, $result['binary']);
            $this->removeExpiredResults();
        } catch (\Throwable $exception) {
            Log::error('Generated product image could not be saved privately.', ['product_id' => $product->id]);
            return $this->reply($request, false, 'The generated image could not be saved. Please try again.', 500);
        }
        $request->session()->put('product_ai_images.' . $token, [
            'product_id' => $product->id,
            'path' => $resultPath,
            'expires_at' => now()->addHours(24)->timestamp,
        ]);

        return $this->reply($request, true, 'Your product image is ready.', 200, [
            'result_url' => route('products.ai-image.result', ['product' => $product, 'token' => $token]),
            'download_url' => route('products.ai-image.download', ['product' => $product, 'token' => $token]),
            'discard_url' => route('products.ai-image.discard', ['product' => $product, 'token' => $token]),
        ]);
    }

    public function productImageResult(Request $request, Product $product, string $token)
    {
        $record = $this->ownedProductImage($request, $product, $token);
        return response(Storage::disk('local')->get($record['path']), 200, ['Content-Type' => 'image/png', 'Cache-Control' => 'private, no-store']);
    }

    public function downloadProductImage(Request $request, Product $product, string $token)
    {
        $record = $this->ownedProductImage($request, $product, $token);
        return response()->streamDownload(
            fn () => print Storage::disk('local')->get($record['path']),
            'smart-basket-ai-product.png',
            ['Content-Type' => 'image/png', 'Cache-Control' => 'private, no-store']
        );
    }

    public function discardProductImage(Request $request, Product $product, string $token)
    {
        $record = $this->ownedProductImage($request, $product, $token);
        Storage::disk('local')->delete($record['path']);
        $request->session()->forget('product_ai_images.' . $token);
        return response()->json(['success' => true]);
    }

    public function result(Request $request, Product $product, string $token)
    {
        $record = $this->ownedResult($request, $product, $token);
        return response(Storage::disk('local')->get($record['path']), 200, ['Content-Type' => 'image/png', 'Cache-Control' => 'private, no-store']);
    }

    public function download(Request $request, Product $product, string $token)
    {
        $record = $this->ownedResult($request, $product, $token);
        return response()->streamDownload(
            fn () => print Storage::disk('local')->get($record['path']),
            'smart-basket-try-on.png',
            ['Content-Type' => 'image/png', 'Cache-Control' => 'private, no-store']
        );
    }

    public function discard(Request $request, Product $product, string $token)
    {
        $record = $this->ownedResult($request, $product, $token);
        Storage::disk('local')->delete($record['path']);
        $request->session()->forget('virtual_tryon_results.' . $token);
        return response()->json(['success' => true]);
    }

    private function ownedResult(Request $request, Product $product, string $token): array
    {
        $key = 'virtual_tryon_results.' . $token;
        $record = $request->session()->get($key);
        abort_unless(is_array($record)
            && ($record['product_id'] ?? null) === $product->id
            && ($record['expires_at'] ?? 0) >= now()->timestamp
            && isset($record['path'])
            && Storage::disk('local')->exists($record['path']), 404);
        return $record;
    }

    private function ownedProductImage(Request $request, Product $product, string $token): array
    {
        $key = 'product_ai_images.' . $token;
        $record = $request->session()->get($key);
        abort_unless(is_array($record)
            && ($record['product_id'] ?? null) === $product->id
            && ($record['expires_at'] ?? 0) >= now()->timestamp
            && isset($record['path'])
            && Storage::disk('local')->exists($record['path']), 404);
        return $record;
    }

    private function isValidPng(string $binary): bool
    {
        if (strlen($binary) < 24 || ! str_starts_with($binary, "\x89PNG\r\n\x1a\n")) return false;
        $info = @getimagesizefromstring($binary);
        return is_array($info) && ($info['mime'] ?? null) === 'image/png';
    }

    private function productFile(Product $product, ?int $productImageId = null): ?array
    {
        if ($productImageId) {
            $additional = ProductImage::where('product_id', $product->id)->find($productImageId);
            if (! $additional) return null;
            $path = $this->safePublicPath((string) $additional->path);
            if (! $path) return null;
            if (! is_file($path) || filesize($path) > 10 * 1024 * 1024 || ! ($mime = mime_content_type($path)) || ! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true) || ! @getimagesize($path)) return null;
            return compact('path', 'mime');
        }

        $image = (string) $product->image;
        if ($image === '' || str_contains($image, '://')) return null; // Never fetch browser-controlled/remote paths for an image edit.
        $path = public_path('products/' . basename($image));
        if (! is_file($path) || filesize($path) > 10 * 1024 * 1024 || ! ($mime = mime_content_type($path)) || ! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true) || ! @getimagesize($path)) return null;
        return compact('path', 'mime');
    }

    private function safePublicPath(string $relativePath): ?string
    {
        if ($relativePath === '' || str_contains($relativePath, '://')) return null;
        $root = realpath(Storage::disk('public')->path(''));
        $path = realpath(Storage::disk('public')->path($relativePath));
        return $root && $path && str_starts_with($path, $root . DIRECTORY_SEPARATOR) ? $path : null;
    }

    private function removeExpiredResults(): void
    {
        foreach (['virtual-tryon/results', 'ai-product/results'] as $directory) {
            foreach (Storage::disk('local')->files($directory) as $path) {
                if (Storage::disk('local')->lastModified($path) < now()->subHours(24)->timestamp) {
                    Storage::disk('local')->delete($path);
                }
            }
        }
    }

    private function reply(Request $request, bool $success, string $message, int $status, array $extra = [])
    {
        return $request->expectsJson() ? response()->json(['success' => $success, 'message' => $message] + $extra, $status) : back()->with($success ? 'success' : 'error', $message);
    }
}
