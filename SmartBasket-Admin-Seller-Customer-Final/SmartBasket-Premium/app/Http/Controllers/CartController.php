<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return (float) $item->product?->price * (int) $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $validated = $request->validate(['quantity' => ['nullable', 'integer', 'min:1']]);
        $quantity = (int) ($validated['quantity'] ?? 1);
        if ($product->stock !== null && $quantity > (int) $product->stock) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->quantity = max(1, (int) $cart->quantity + $quantity);
            if ($product->stock !== null && $cart->quantity > (int) $product->stock) {
                return back()->with('error', 'Requested quantity exceeds available stock.');
            }
            $cart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', 'Product added to cart');
    }

    public function update(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $request->validate(['quantity' => 'required|integer|min:1']);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if (! $cartItem) {
            return back()->with('error', 'Item not found in cart.');
        }

        $cartItem->quantity = (int) $request->quantity;
        $cartItem->save();

        return back()->with('success', 'Cart updated.');
    }

    public function remove($id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
