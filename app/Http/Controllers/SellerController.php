<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class SellerController extends Controller
{
    // Seller Dashboard
   public function dashboard()
{
    if(!session()->has('seller_login'))
    {
        return redirect()
        ->route('seller.login')
        ->with('error','Please login first');
    }


    $sellerId = session('seller_id');


    $products = Product::where(
        'seller_id',
        $sellerId
    )
    ->latest()
    ->get();


    $totalProducts = $products->count();


    $totalOrders = Order::count();


    $pendingOrders = Order::where(
        'status',
        'Pending'
    )->count();


    $totalRevenue = Order::sum('total');


    return view(
        'seller.dashboard',
        compact(
            'products',
            'totalProducts',
            'totalOrders',
            'pendingOrders',
            'totalRevenue'
        )
    );

}

    // Show Add Product Form
    public function create()
    {
       if (!session()->has('seller_login')) {
    return redirect()->route('seller.login');
}

        return view('seller.add-product');
    }

    // Store Product
    public function store(Request $request)
    {
        if (!session('seller_login')) {
            return redirect('/seller-login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'rating' => 'nullable|numeric|min:0|max:5',
            'stock' => 'required|integer|min:0',
            'size' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('products'), $imageName);

        Product::create([
            'seller_id' => session('seller_id', 0),
            'name' => $request->name,
            'category' => $request->category,
            'brand' => $request->brand,
            'description' => $request->description,
            'image' => $imageName,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'rating' => $request->rating ?? 4.5,
            'stock' => $request->stock,
            'size' => $request->size,
            'color' => $request->color,
            'status' => $request->status ?? 'active',
        ]);

        return redirect('/seller-dashboard')->with('success', 'Product Added Successfully 🚀');
    }

    // Show Edit Product Form
    public function edit($id)
    {
        if (!session('seller_login')) {
            return redirect('/seller-login');
        }

        $product = Product::findOrFail($id);

        // Security: seller can only edit their own products
        if ($product->seller_id != session('seller_id', 0)) {
            return redirect('/seller-dashboard')->with('error', 'You cannot edit another seller product.');
        }

        return view('seller.edit-product', compact('product'));
    }

    // Update Product
    public function update(Request $request, $id)
    {
        if (!session('seller_login')) {
            return redirect('/seller-login');
        }

        $product = Product::findOrFail($id);

        // Security: seller can only update their own products
        if ($product->seller_id != session('seller_id', 0)) {
            return redirect('/seller-dashboard')->with('error', 'You cannot edit another seller product.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'rating' => 'nullable|numeric|min:0|max:5',
            'stock' => 'required|integer|min:0',
            'size' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        $data = [
            'name' => $request->name,
            'category' => $request->category,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'rating' => $request->rating ?? 4.5,
            'stock' => $request->stock,
            'size' => $request->size,
            'color' => $request->color,
            'status' => $request->status ?? 'active',
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('products'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect('/seller-dashboard')->with('success', 'Product Updated Successfully ✅');
    }

    // Delete Product
    public function destroy($id)
    {
        if (!session('seller_login')) {
            return redirect('/seller-login');
        }

        $product = Product::findOrFail($id);

        // Security: seller can only delete their own products
        if ($product->seller_id != session('seller_id', 0)) {
            return redirect('/seller-dashboard')->with('error', 'You cannot delete another seller product.');
        }

        $product->delete();

        return redirect('/seller-dashboard')->with('success', 'Product Deleted Successfully 🗑️');
    }

    // View Orders
    public function orders()
    {
        if (!session('seller_login')) {
            return redirect('/seller-login');
        }

        $orders = Order::latest()->get();
        return view('seller.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        if (!session('seller_login')) {
            return redirect('/seller-login');
        }

        $request->validate(['order_status' => 'required|string']);

        $order->update([
            'order_status' => $request->order_status,
            'status' => $request->order_status,
            'delivery_status' => $request->order_status,
        ]);

        return back()->with('success', 'Order status updated.');
    }
}