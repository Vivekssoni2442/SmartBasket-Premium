<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::latest()->get();

        $sellerProducts = $query->filter(function ($product) {
            return $this->isSellerUploadedProduct($product);
        })->values();

        $search = trim((string) $request->get('search', ''));
        $category = trim((string) $request->get('category', ''));

        if ($search !== '') {
            $sellerProducts = $sellerProducts->filter(function ($product) use ($search) {
                return stripos($product->name, $search) !== false
                    || stripos($product->category, $search) !== false;
            })->values();
        }

        if ($category !== '') {
            $sellerProducts = $sellerProducts->filter(function ($product) use ($category) {
                return strcasecmp($product->category, $category) === 0;
            })->values();
        }

        $perPage = 8;
        $page = max(1, (int) $request->get('page', 1));
        $pagedProducts = new LengthAwarePaginator(
            $sellerProducts->slice(($page - 1) * $perPage, $perPage)->values(),
            $sellerProducts->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $categories = Product::query()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('products.index', compact('pagedProducts', 'categories', 'search', 'category'));
    }

    private function isSellerUploadedProduct(Product $product): bool
    {
        if (empty($product->image)) {
            return false;
        }

        $image = $product->image;

        if ($image === null || $image === '') {
            return false;
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return false;
        }

        $relativePath = ltrim($image, '/');
        $candidate = str_starts_with($relativePath, 'products/')
            ? public_path($relativePath)
            : public_path('products/' . $relativePath);

        return file_exists($candidate);
    }
}