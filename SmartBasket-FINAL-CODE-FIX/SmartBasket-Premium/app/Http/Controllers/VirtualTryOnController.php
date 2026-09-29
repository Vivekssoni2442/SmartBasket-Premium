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

        if (! $this->supportsCategory((string) $product->category)) {
            return $this->reply($request, false, 'AI Virtual Try-On is not available for this product category.', 422);
        }

        $validated = $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'product_image_id' => ['nullable', 'integer'],
        ]);
        $productFile = $this->productFile($product, $validated['product_image_id'] ?? null);
        if (! $productFile) {
            Log::warning('Virtual try-on product image could not be safely resolved.', ['product_id' => $product->id]);
            return $this->reply($request, false, 'AI Virtual Try-On is temporarily unavailable. Please try again later.', 503);
        }

        $photo = $validated['photo'];
        $token = Str::random(40);
        $customerPath = $photo->storeAs('virtual-tryon/' . $token, 'customer.' . $photo->extension(), 'local');
        $customerAbsolute = Storage::disk('local')->path($customerPath);

        try {
            $result = $service->generateFromFiles($customerAbsolute, $photo->getMimeType(), $productFile['path'], $productFile['mime'], $product->name, (string) $product->category);
        } finally {
            Storage::disk('local')->delete($customerPath);
        }

        if (! $result['success']) {
            return $this->reply($request, false, $result['message'], $result['reason'] === 'not_configured' ? 503 : 502);
        }

        $resultPath = 'virtual-tryon/results/' . $token . '.png';
        Storage::disk('local')->put($resultPath, $result['binary']);
        $request->session()->put('virtual_tryon_results.' . $token, ['product_id' => $product->id, 'path' => $resultPath]);

        return $this->reply($request, true, 'AI Virtual Try-On Result generated.', 200, [
            'result_url' => route('products.virtual-try-on.result', ['product' => $product, 'token' => $token]),
        ]);
    }

    public function result(Request $request, Product $product, string $token)
    {
        $record = $request->session()->get('virtual_tryon_results.' . $token);
        abort_unless(is_array($record) && $record['product_id'] === $product->id && Storage::disk('local')->exists($record['path']), 404);
        return response(Storage::disk('local')->get($record['path']), 200, ['Content-Type' => 'image/png', 'Cache-Control' => 'private, no-store']);
    }

    private function productFile(Product $product, ?int $productImageId = null): ?array
    {
        if ($productImageId) {
            $additional = ProductImage::where('product_id', $product->id)->find($productImageId);
            if (! $additional) return null;
            $path = Storage::disk('public')->path($additional->path);
            if (! is_file($path) || ! ($mime = mime_content_type($path)) || ! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) return null;
            return compact('path', 'mime');
        }

        $image = (string) $product->image;
        if ($image === '' || str_contains($image, '://')) return null; // Never fetch browser-controlled/remote paths for an image edit.
        $path = public_path('products/' . basename($image));
        if (! is_file($path) || ! ($mime = mime_content_type($path)) || ! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) return null;
        return compact('path', 'mime');
    }

    private function supportsCategory(string $category): bool
    {
        return (bool) preg_match('/shirt|t-?shirt|jacket|blazer|dress|kurta|saree|pants|jeans|trouser|skirt|hoodie|sweater|glasses|watch|jewelry|jewellery|bag|shoe/i', $category);
    }

    private function reply(Request $request, bool $success, string $message, int $status, array $extra = [])
    {
        return $request->expectsJson() ? response()->json(['success' => $success, 'message' => $message] + $extra, $status) : back()->with($success ? 'success' : 'error', $message);
    }
}
