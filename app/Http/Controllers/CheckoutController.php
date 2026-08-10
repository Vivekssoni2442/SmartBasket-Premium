<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $buyProduct = Session::get('buy_product');

        $cartItems = [];
        $total = 0;

        if ($buyProduct) {
            $product = Product::find($buyProduct);
            if ($product) {
                $cartItems[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'price' => $product->price,
                    'qty' => 1,
                    'subtotal' => $product->price,
                ];
                $total = $product->price;
            }
        } else {
            foreach ($cart as $id => $qty) {
                $product = Product::find($id);
                if ($product) {
                    $cartItems[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'image' => $product->image,
                        'price' => $product->price,
                        'qty' => $qty,
                        'subtotal' => $product->price * $qty,
                    ];
                    $total += $product->price * $qty;
                }
            }
        }

        if (count($cartItems) === 0) {
            return redirect('/cart')->with('error', 'Your cart is empty!');
        }

        return view('checkout', compact('cartItems', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
        ]);

        $cart = Session::get('cart', []);
        $buyProduct = Session::get('buy_product');
        $total = 0;
        $items = [];

        if ($buyProduct) {
            $product = Product::find($buyProduct);
            if ($product) {
                $total = $product->price;
                $items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => $product->price,
                ];
            }
        } else {
            foreach ($cart as $id => $qty) {
                $product = Product::find($id);
                if ($product) {
                    $total += $product->price * $qty;
                    $items[] = [
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'quantity' => $qty,
                        'price' => $product->price,
                    ];
                }
            }
        }

        if ($total === 0) {
            return redirect('/cart')->with('error', 'Your cart is empty!');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'city' => $request->city,
            'total' => $total,
            'status' => 'Confirmed',
            'payment_status' => 'Paid',
            'delivery_status' => 'Pending',
            'items' => json_encode($items),
        ]);

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        Session::forget('cart');
        Session::forget('buy_product');

        return redirect('/order-success')->with('success', 'Order placed successfully!');
    }
}