<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\RecentlyViewedProduct;
use App\Models\Wishlist;
use Illuminate\Support\Collection;

class PersonalizedRecommendationService
{
    public function forUser(int $userId, int $limit = 16): Collection
    {
        $categoryScores = [];
        $add = function ($products, int $weight) use (&$categoryScores) {
            foreach ($products as $product) $categoryScores[$product->category] = ($categoryScores[$product->category] ?? 0) + $weight;
        };
        $add(RecentlyViewedProduct::with('product')->where('user_id', $userId)->latest()->limit(30)->get()->pluck('product')->filter(), 3);
        $add(Wishlist::with('product')->where('user_id', $userId)->get()->pluck('product')->filter(), 4);
        $add(Cart::with('product')->where('user_id', $userId)->get()->pluck('product')->filter(), 5);
        $purchased = Product::whereIn('id', Order::where('user_id', $userId)->get()->flatMap(fn ($order) => collect($order->items ?? [])->pluck('product_id'))->filter()->unique())->get();
        $add($purchased, 6);

        return Product::customerVisible()->with('seller')->where(fn ($q) => $q->whereNull('status')->orWhere('status', 'active'))
            ->where('stock', '>', 0)->get()->sortByDesc(fn (Product $product) => ($categoryScores[$product->category] ?? 0) * 100 + (float) ($product->rating ?? 0))->take($limit)->values();
    }
}
