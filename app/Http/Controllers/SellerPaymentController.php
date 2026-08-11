<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\SellerProfile;
use Illuminate\Http\Request;

class SellerPaymentController extends Controller
{
    public function index(Request $request)
    {
        $seller = $this->currentSeller();
        $orders = $this->filteredPayments($request, $seller->id)->latest()->get();
        $this->attachSellerItems($orders, $seller->id);
        $summary = [
            'received' => $orders->filter(fn (Order $order) => $this->status($order) === 'Successful')->sum('total'),
            'successful' => $orders->filter(fn (Order $order) => $this->status($order) === 'Successful')->count(),
            'pending' => $orders->filter(fn (Order $order) => $this->status($order) === 'Pending')->count(),
            'failed' => $orders->filter(fn (Order $order) => $this->status($order) === 'Failed')->count(),
            'refunded' => $orders->filter(fn (Order $order) => $this->status($order) === 'Refunded')->count(),
        ];

        return view('seller.payments.index', compact('seller', 'orders', 'summary'));
    }

    public function show(Order $order)
    {
        $seller = $this->currentSeller();
        $order = Order::forSeller($seller->id)->whereKey($order->id)->firstOrFail();

        $sellerItems = $this->sellerItems($order, $seller->id);
        $products = Product::where('seller_id', $seller->id)
            ->whereIn('id', $sellerItems->pluck('product_id')->filter())
            ->get()->keyBy('id');
        $paymentStatus = $this->status($order);

        $customer = $order->user;
        return view('seller.payments.show', compact('seller', 'order', 'sellerItems', 'products', 'paymentStatus', 'customer'));
    }

    private function filteredPayments(Request $request, int $sellerId)
    {
        $query = Order::forSeller($sellerId)->with('user');

        if ($search = trim((string) $request->input('search'))) {
            $productIds = Product::where('seller_id', $sellerId)->where('name', 'like', "%{$search}%")->pluck('id');
            $query->where(fn ($orders) => $orders->where('id', $search)
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhereHas('user', fn ($users) => $users->where('name', 'like', "%{$search}%")->orWhere('customer_uid', 'like', "%{$search}%"))
                ->orWhere(function ($orders) use ($productIds) {
                    foreach ($productIds as $productId) $orders->orWhereJsonContains('items', ['product_id' => $productId]);
                }));
        }
        if ($request->filled('from')) $query->whereDate('created_at', '>=', $request->input('from'));
        if ($request->filled('to')) $query->whereDate('created_at', '<=', $request->input('to'));
        if ($status = $request->input('status')) {
            $query->whereIn('payment_status', match ($status) {
                'Successful' => ['Paid', 'Successful'],
                'Pending' => ['Pending'],
                'Failed' => ['Failed'],
                'Refunded' => ['Refunded'],
                default => [],
            });
        }
        if ($method = $request->input('method')) {
            $query->where('payment_method', $method);
        }

        return $query;
    }

    private function attachSellerItems($orders, int $sellerId): void
    {
        $products = Product::where('seller_id', $sellerId)->get()->keyBy('id');
        foreach ($orders as $order) {
            $order->setAttribute('seller_items', $this->sellerItems($order, $sellerId));
            $order->setAttribute('seller_products', $products);
        }
    }

    private function sellerItems(Order $order, int $sellerId)
    {
        return collect($order->items ?? [])->filter(
            fn ($item) => (int) ($item['seller_id'] ?? 0) === $sellerId
        )->values();
    }

    public function status(Order $order): string
    {
        return match ($order->payment_status) {
            'Paid', 'Successful' => 'Successful',
            'Failed' => 'Failed',
            'Refunded' => 'Refunded',
            default => 'Pending',
        };
    }

    private function currentSeller(): SellerProfile
    {
        abort_unless(session('seller_login') && session('seller_id'), 403);
        return SellerProfile::findOrFail((int) session('seller_id'));
    }
}
