<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\PriceWatch;
use App\Models\Product;
use App\Services\PersonalizedRecommendationService;
use Illuminate\Http\Request;

class CustomerDiscoveryController extends Controller
{
    private function userId(): int { abort_unless(auth()->check(), 403); return (int) auth()->id(); }

    public function buyAgain()
    {
        $items = Order::where('user_id', $this->userId())->latest()->get()->flatMap(fn ($order) => collect($order->items ?? [])->map(fn ($item) => $item + ['purchased_at' => $order->created_at]))
            ->groupBy('product_id')->map(fn ($rows) => $rows->sortByDesc('purchased_at')->first());
        $products = Product::with('seller')->whereIn('id', $items->keys())->get()->keyBy('id');
        return view('customer.buy-again', compact('items', 'products'));
    }

    public function forYou(PersonalizedRecommendationService $recommendations)
    {
        return view('customer.for-you', ['products' => $recommendations->forUser($this->userId())]);
    }

    public function watches()
    {
        $watches = PriceWatch::with('product.seller')->where('user_id', $this->userId())
            ->whereHas('product', fn ($products) => $products->customerVisible())
            ->latest()->get();
        foreach ($watches as $watch) $this->checkDrop($watch);
        return view('customer.price-watches', compact('watches'));
    }

    public function storeWatch(Product $product)
    {
        $userId = $this->userId();
        PriceWatch::firstOrCreate(['user_id' => $userId, 'product_id' => $product->id], ['tracked_price' => $product->sellingPrice()]);
        return back()->with('success', 'Price tracking enabled for this product.');
    }

    public function destroyWatch(PriceWatch $priceWatch)
    {
        abort_unless((int) $priceWatch->user_id === $this->userId(), 403);
        $priceWatch->delete();
        return back()->with('success', 'Price tracking stopped.');
    }

    private function checkDrop(PriceWatch $watch): void
    {
        if (! $watch->product) return;
        $current = $watch->product->sellingPrice();
        if ($current < (float) $watch->tracked_price) {
            $exists = Notification::where('user_id', $watch->user_id)->where('role', 'user')->where('type', 'price_drop')->whereJsonContains('data->price_watch_id', $watch->id)->exists();
            if (! $exists) Notification::create(['user_id' => $watch->user_id, 'role' => 'user', 'type' => 'price_drop', 'title' => 'Price dropped', 'message' => $watch->product->name . ' is now cheaper.', 'data' => ['price_watch_id' => $watch->id, 'product_id' => $watch->product_id, 'old_price' => (float) $watch->tracked_price, 'new_price' => $current]]);
            $watch->update(['previous_price' => $watch->tracked_price, 'tracked_price' => $current]);
        }
    }
}
