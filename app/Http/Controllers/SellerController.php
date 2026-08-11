<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\SellerProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class SellerController extends Controller
{
    /** Show the existing seller login page. */
    public function showLogin()
    {
        return view('auth.seller-login');
    }

    /** Authenticate a registered seller while preserving seller session keys. */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $seller = SellerProfile::where('email', $credentials['email'])->first();

        if (! $seller || ! Hash::check($credentials['password'], $seller->password)) {
            return back()->withInput($request->only('email'))
                ->with('error', 'Invalid Seller Login');
        }

        $request->session()->regenerate();
        $request->session()->put([
            'seller_login' => true,
            'seller_email' => $seller->email,
            'seller_id' => $seller->id,
        ]);

        return redirect()->route('seller.dashboard');
    }

    /** Show the seller account registration page. */
    public function showRegistration()
    {
        return view('auth.seller-register');
    }

    /** Create a seller profile with a securely hashed password. */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'seller_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:seller_profiles,email'],
            'mobile_number' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        SellerProfile::create([
            'seller_name' => $validated['seller_name'],
            // The existing schema requires a shop name; use the seller name
            // until the existing profile workflow supplies a separate one.
            'shop_name' => $validated['seller_name'],
            'email' => $validated['email'],
            'mobile_number' => $validated['mobile_number'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('seller.login')
            ->with('success', 'Seller account created. Please login.');
    }

    // Seller Dashboard
   public function dashboard()
{
    if(!session()->has('seller_login'))
    {
        return redirect()
        ->route('seller.login')
        ->with('error','Please login first');
    }


    $seller = $this->currentSeller();
    $sellerId = $seller->id;


    $products = Product::where(
        'seller_id',
        $sellerId
    )
    ->latest()
    ->get();


    $totalProducts = $products->count();


    $sellerOrders = Order::forSeller($sellerId);
    $totalOrders = (clone $sellerOrders)->count();
    $pendingOrders = (clone $sellerOrders)->where('status', 'Pending')->count();
    // Earnings are cash actually recorded as paid, never the value of pending
    // orders or products merely listed by this seller.
    $totalRevenue = (clone $sellerOrders)
        ->whereIn('payment_status', ['Paid', 'Successful'])
        ->sum('total');


    return view(
        'seller.dashboard',
        compact(
            'products',
            'totalProducts',
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'seller'
        )
    );

}

    /** Display only the profile associated with the authenticated seller session. */
    public function profile()
    {
        $seller = $this->currentSeller();

        return view('seller.profile', compact('seller'));
    }

    /** Update permitted fields for the authenticated seller only. */
    public function updateProfile(Request $request)
    {
        $seller = $this->currentSeller();
        $validated = $request->validate([
            'seller_name' => ['required', 'string', 'max:255'],
            'shop_name' => ['required', 'string', 'max:255'],
            'mobile_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', Rule::unique('seller_profiles', 'email')->ignore($seller->id)],
            'shop_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('shop_logo')) {
            $validated['shop_logo'] = $request->file('shop_logo')->store('seller-logos', 'public');
        }

        $seller->update($validated);
        session(['seller_email' => $seller->email]);

        return redirect()->route('seller.profile')->with('success', 'Seller profile updated successfully.');
    }

    /** Show only products owned by the authenticated seller. */
    public function myProducts()
    {
        $seller = $this->currentSeller();
        $products = Product::where('seller_id', $seller->id)->with('images')->latest()->get();

        return view('seller.my-products', compact('products'));
    }

    private function currentSeller(): SellerProfile
    {
        abort_unless(session('seller_login') && session('seller_id'), 403);

        return SellerProfile::findOrFail((int) session('seller_id'));
    }

    // Show Add Product Form
    public function create()
    {
        if (!session()->has('seller_login')) {
            return redirect()->route('seller.login');
        }

        $this->currentSeller();

        return view('seller.add-product');
    }

    // Store Product
    public function store(Request $request)
    {
        if (!session('seller_login')) {
            return redirect('/seller-login');
        }

        $sellerId = $this->currentSeller()->id;

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

        $product = Product::create([
            // Ownership always comes from the authenticated seller session,
            // never from form input or a fallback/default seller.
            'seller_id' => $sellerId,
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

        $this->storeAdditionalImages($request, $product);

        return redirect('/seller-dashboard')->with('success', 'Product Added Successfully 🚀');
    }

    // Show Edit Product Form
    public function edit($id)
    {
        if (!session('seller_login')) {
            return redirect('/seller-login');
        }

        $product = Product::where('seller_id', $this->currentSeller()->id)->with('images')->findOrFail($id);

        return view('seller.edit-product', compact('product'));
    }

    // Update Product
    public function update(Request $request, $id)
    {
        if (!session('seller_login')) {
            return redirect('/seller-login');
        }

        $product = Product::where('seller_id', $this->currentSeller()->id)->findOrFail($id);

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
        $this->storeAdditionalImages($request, $product);

        return redirect('/seller-dashboard')->with('success', 'Product Updated Successfully ✅');
    }

    // Delete Product
    public function destroy($id)
    {
        if (!session('seller_login')) {
            return redirect('/seller-login');
        }

        $product = Product::where('seller_id', $this->currentSeller()->id)->findOrFail($id);

        $product->delete();

        return redirect('/seller-dashboard')->with('success', 'Product Deleted Successfully 🗑️');
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        if (!session('seller_login')) {
            return redirect('/seller-login');
        }

        $this->currentSeller();
        abort_unless($order->belongsToSeller((int) session('seller_id')), 404);
        $request->validate(['order_status' => 'required|in:Placed,Confirmed,Packed,Picked By Delivery Partner,Out For Delivery,Near Customer,Delivered,Cancelled']);

        $order->update([
            'order_status' => $request->order_status,
            'status' => $request->order_status,
            'delivery_status' => $request->order_status,
        ]);

        return back()->with('success', 'Order status updated.');
    }

    public function settings()
    {
        return view('seller.settings', ['seller' => $this->currentSeller()]);
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'theme' => ['required', 'in:light,dark,system'],
            'notifications_enabled' => ['required', 'boolean'],
            'online_payments_enabled' => ['required', 'boolean'],
        ]);
        $this->currentSeller()->update($data);
        return back()->with('success', 'Settings saved successfully.');
    }

    public function updatePaymentQr(Request $request)
    {
        $data = $request->validate(['payment_qr' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048']]);
        $seller = $this->currentSeller();
        $seller->payment_qr = $data['payment_qr']->store('seller-payment-qr', 'public');
        $seller->save();
        return back()->with('success', 'Payment QR updated successfully.');
    }

    public function deletePaymentQr()
    {
        $this->currentSeller()->update(['payment_qr' => null]);

        return back()->with('success', 'Payment QR removed successfully.');
    }

    private function storeAdditionalImages(Request $request, Product $product): void
    {
        $request->validate(['images' => ['nullable', 'array', 'max:8'], 'images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048']]);
        foreach ($request->file('images', []) as $index => $image) {
            $product->images()->create(['path' => $image->store('product-images', 'public'), 'sort_order' => $index]);
        }
    }
}
