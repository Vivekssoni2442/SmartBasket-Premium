<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'address' => 'required|string',
            'city' => 'nullable|string|max:255',
        ]);

        $itemsBySeller = [];
        $user = Auth::user();
        $buyProductId = session()->get('buy_product');

        if ($buyProductId) {
            $product = Product::find($buyProductId);
            if ($product) {
                $itemsBySeller[(int) $product->seller_id][] = [
                    'product_id' => $product->id,
                    'seller_id' => $product->seller_id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => (float) $product->price,
                ];
            }
        } elseif ($user) {
            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                if (! $product) {
                    continue;
                }

                $quantity = max(1, (int) $cartItem->quantity);
                $itemsBySeller[(int) $product->seller_id][] = [
                    'product_id' => $product->id,
                    'seller_id' => $product->seller_id,
                    'name' => $product->name,
                    'quantity' => $quantity,
                    'price' => (float) $product->price,
                ];
            }
        } else {
            $cart = session()->get('cart', []);

            foreach ($cart as $id => $quantity) {
                $product = Product::find($id);
                if ($product) {
                    $quantity = max(1, (int) $quantity);
                    $itemsBySeller[(int) $product->seller_id][] = [
                        'product_id' => $product->id,
                        'seller_id' => $product->seller_id,
                        'name' => $product->name,
                        'quantity' => $quantity,
                        'price' => (float) $product->price,
                    ];
                }
            }
        }

        if ($itemsBySeller === []) {
            return redirect('/cart')->with('error', 'Your cart is empty.');
        }

        if (array_key_exists(0, $itemsBySeller)) {
            return back()->with('error', 'One or more products are not assigned to a seller and cannot be checked out.');
        }

        $paymentMethod = $request->payment_method ?? 'COD';
        $onlineMethods = ['Card', 'UPI', 'Google Pay', 'PhonePe', 'Net Banking'];
        if (in_array($paymentMethod, $onlineMethods, true)
            && SellerProfile::whereIn('id', array_keys($itemsBySeller))->where('online_payments_enabled', true)->count() !== count($itemsBySeller)) {
            return back()->with('error', 'Online payment is not enabled by every seller in this checkout.');
        }

        // Checkout has no gateway confirmation callback, so order creation is
        // never treated as proof of a successful payment.
        $paymentStatus = 'Pending';

        DB::transaction(function () use ($itemsBySeller, $user, $request, $paymentStatus, $paymentMethod) {
            foreach ($itemsBySeller as $sellerId => $sellerItems) {
                $sellerTotal = round(collect($sellerItems)->sum(
                    fn (array $item) => (float) $item['price'] * (int) $item['quantity']
                ), 2);

                Order::create([
                    'user_id' => $user?->id,
                    'seller_id' => $sellerId,
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                    'city' => $request->city ?? 'N/A',
                    'total' => $sellerTotal,
                    'amount' => $sellerTotal,
                    'status' => 'Confirmed',
                    'payment_status' => $paymentStatus,
                    'payment_method' => $paymentMethod,
                    'order_status' => 'Placed',
                    'delivery_status' => 'Pending',
                    'items' => $sellerItems,
                ]);

                foreach ($sellerItems as $item) {
                    $product = Product::lockForUpdate()->find($item['product_id']);
                    if (! $product || (int) $product->seller_id !== (int) $sellerId || ($product->stock !== null && $product->stock < $item['quantity'])) {
                        throw new \RuntimeException('A product is no longer available. Please review your cart.');
                    }
                    $product->decrement('stock', $item['quantity']);
                }
            }

            if ($user) {
                Cart::where('user_id', $user->id)->delete();
            }
        });

        session()->forget('cart');
        session()->forget('buy_product');

        return redirect('/order-success')->with('success', 'Order placed successfully.');
    }

    public function myOrders()
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        $orders = Order::with('deliveryDetail.deliveryPartner')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        $products = Product::whereIn('id', $orders->flatMap(fn ($order) => collect($order->items ?? [])->pluck('product_id'))->filter()->unique())->get()->keyBy('id');

        return view('orders.index', compact('orders', 'products'));
    }

    public function show(Order $order)
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        abort_unless((int) $order->user_id === (int) Auth::id(), 403);

        $order->load('deliveryDetail.deliveryPartner');
        $products = Product::whereIn('id', collect($order->items ?? [])->pluck('product_id')->filter())->get()->keyBy('id');

        return view('orders.show', compact('order', 'products'));
    }

    public function cancel(Request $request, Order $order)
    {
        abort_unless(Auth::check() && (int) $order->user_id === (int) Auth::id(), 403);
        abort_unless($order->isCancellable(), 422, 'This order can no longer be cancelled.');
        $validated = $request->validate(['cancellation_reason' => ['nullable', 'string', 'max:500']]);

        DB::transaction(function () use ($order, $validated) {
            $lockedOrder = Order::lockForUpdate()->findOrFail($order->id);
            abort_unless($lockedOrder->isCancellable(), 422, 'This order can no longer be cancelled.');
            $lockedOrder->update(['status' => 'Cancelled', 'order_status' => 'Cancelled', 'delivery_status' => 'Cancelled', 'cancellation_reason' => $validated['cancellation_reason'] ?? null, 'cancelled_at' => now()]);
            if ($lockedOrder->deliveryDetail) $lockedOrder->deliveryDetail->update(['status' => 'Cancelled']);
            foreach ($lockedOrder->items ?? [] as $item) Product::whereKey($item['product_id'] ?? null)->lockForUpdate()->increment('stock', (int) ($item['quantity'] ?? 0));
        });

        return redirect()->route('orders.index')->with('success', 'Order cancelled successfully. Payment status was left unchanged because no refund workflow is configured.');
    }
}
