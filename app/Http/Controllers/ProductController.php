<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Customer catalog remains global; seller ownership is enforced only in seller queries.
        $sellerProducts = Product::query()->with('seller')->where(function ($query) {
            $query->whereNull('status')->orWhere('status', 'active');
        })->latest()->get();

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

    /** Display the selected real product with its own images and seller. */
    public function show(Product $product)
    {
        $product->load(['images', 'seller']);

        if (auth()->check()) {
            \App\Models\RecentlyViewedProduct::firstOrCreate([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ]);
        }

        $relatedProducts = Product::query()
            ->whereKeyNot($product->id)
            ->where('category', $product->category)
            ->where(fn ($query) => $query->whereNull('status')->orWhere('status', 'active'))
            ->latest()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

}
