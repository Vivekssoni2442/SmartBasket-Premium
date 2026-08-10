<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $items = [];
        $total = 0;
        $user = Auth::user();
        $buyProductId = session()->get('buy_product');

        if ($buyProductId) {
            $product = Product::find($buyProductId);
            if ($product) {
                $items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => (float) $product->price,
                ];
                $total = round((float) $product->price, 2);
            }
        } elseif ($user) {
            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                if (! $product) {
                    continue;
                }

                $quantity = max(1, (int) $cartItem->quantity);
                $itemTotal = round((float) $product->price * $quantity, 2);

                $items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $quantity,
                    'price' => (float) $product->price,
                ];
                $total += $itemTotal;
            }
        } else {
            $cart = session()->get('cart', []);

            foreach ($cart as $id => $quantity) {
                $product = Product::find($id);
                if ($product) {
                    $quantity = max(1, (int) $quantity);
                    $items[] = [
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'quantity' => $quantity,
                        'price' => (float) $product->price,
                    ];
                    $total += round((float) $product->price * $quantity, 2);
                }
            }
        }

        if ($items === []) {
            return redirect('/cart')->with('error', 'Your cart is empty.');
        }

        $paymentMethod = $request->payment_method ?? 'COD';
        $paymentStatus = in_array($paymentMethod, ['Card', 'UPI', 'Google Pay', 'PhonePe', 'Net Banking'], true) ? 'Paid' : 'Pending';

        Order::create([
            'user_id' => $user?->id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'city' => $request->city ?? 'N/A',
            'total' => round($total, 2),
            'amount' => round($total, 2),
            'status' => 'Confirmed',
            'payment_status' => $paymentStatus,
            'payment_method' => $paymentMethod,
            'order_status' => $paymentStatus === 'Paid' ? 'Confirmed' : 'Placed',
            'delivery_status' => 'Pending',
            'items' => $items,
        ]);

        if ($user) {
            Cart::where('user_id', $user->id)->delete();
        }

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
}
