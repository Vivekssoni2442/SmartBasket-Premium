<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\SellerProfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SellerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SELLER LOGIN
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.seller-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        $seller = SellerProfile::where(
            'email',
            $credentials['email']
        )->first();

        if (
            !$seller ||
            !Hash::check(
                $credentials['password'],
                $seller->password
            )
        ) {
            return back()
                ->withInput(
                    $request->only('email')
                )
                ->with(
                    'error',
                    'Invalid Seller Login'
                );
        }

        $request->session()->regenerate();

        $request->session()->put([
            'seller_login' => true,
            'seller_email' => $seller->email,
            'seller_id' => $seller->id,
        ]);

        return redirect()->route(
            'seller.dashboard'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SELLER REGISTRATION
    |--------------------------------------------------------------------------
    */

    public function showRegistration()
    {
        return view('auth.seller-register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'seller_name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:seller_profiles,email',
            ],

            'mobile_number' => [
                'required',
                'string',
                'max:20',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        SellerProfile::create([
            'seller_name' =>
                $validated['seller_name'],

            'shop_name' =>
                $validated['seller_name'],

            'email' =>
                $validated['email'],

            'mobile_number' =>
                $validated['mobile_number'],

            'password' =>
                Hash::make(
                    $validated['password']
                ),
        ]);

        return redirect()
            ->route('seller.login')
            ->with(
                'success',
                'Seller account created. Please login.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SELLER DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        if (!session()->has('seller_login')) {
            return redirect()
                ->route('seller.login')
                ->with(
                    'error',
                    'Please login first'
                );
        }

        $seller = $this->currentSeller();

        if (
            $seller->verification_status ===
                SellerProfile::STATUS_PENDING_EMAIL

            ||

            $seller->verification_status ===
                SellerProfile::STATUS_EMAIL_VERIFICATION
        ) {
            return redirect()
                ->route(
                    'seller.verification.email'
                );
        }

        $sellerId = $seller->id;

        $products = Product::where(
            'seller_id',
            $sellerId
        )
            ->with('images')
            ->latest()
            ->get();

        $totalProducts =
            $products->count();

        $sellerOrders =
            Order::forSeller($sellerId);

        $totalOrders =
            (clone $sellerOrders)->count();

        $pendingOrders =
            (clone $sellerOrders)
                ->where(
                    'status',
                    'Pending'
                )
                ->count();

        $totalRevenue =
            (clone $sellerOrders)
                ->whereIn(
                    'payment_status',
                    [
                        'Paid',
                        'Successful',
                    ]
                )
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

    /*
    |--------------------------------------------------------------------------
    | SELLER PROFILE
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
        $seller = $this->currentSeller();

        return view(
            'seller.profile',
            compact('seller')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SELLER PROFILE
    |--------------------------------------------------------------------------
    |
    | ALL ACCOUNT INFORMATION
    | BUSINESS INFORMATION
    | ADDRESS
    | KYC
    | BANK
    | SHOP LOGO
    |
    */

    public function updateProfile(Request $request)
    {
        $seller = $this->currentSeller();

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | BASIC ACCOUNT
            |--------------------------------------------------------------------------
            */

            'seller_name' => [
                'required',
                'string',
                'max:255',
            ],

            'shop_name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique(
                    'seller_profiles',
                    'email'
                )->ignore($seller->id),
            ],

            'mobile_number' => [
                'required',
                'string',
                'max:20',
            ],

            /*
            |--------------------------------------------------------------------------
            | ADDRESS
            |--------------------------------------------------------------------------
            */

            'shop_address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'city' => [
                'nullable',
                'string',
                'max:255',
            ],

            'state' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pincode' => [
                'nullable',
                'string',
                'max:20',
            ],

            /*
            |--------------------------------------------------------------------------
            | BUSINESS DETAILS
            |--------------------------------------------------------------------------
            */

            'business_type' => [
                'nullable',
                'string',
                'max:255',
            ],

            'gst_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'pan_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'udyam_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            /*
            |--------------------------------------------------------------------------
            | AADHAAR
            |--------------------------------------------------------------------------
            */

            'aadhaar_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            /*
            |--------------------------------------------------------------------------
            | BANK DETAILS
            |--------------------------------------------------------------------------
            */

            'bank_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'account_holder_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'account_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'ifsc_code' => [
                'nullable',
                'string',
                'max:50',
            ],

            'branch_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | SHOP LOGO
            |--------------------------------------------------------------------------
            */

            'shop_logo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:4096',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | FIELDS TO UPDATE
        |--------------------------------------------------------------------------
        */

        $profileFields = [

            // Basic
            'seller_name',
            'shop_name',
            'email',
            'mobile_number',

            // Address
            'shop_address',
            'city',
            'state',
            'pincode',

            // Business
            'business_type',
            'gst_number',
            'pan_number',
            'udyam_number',

            // Aadhaar
            'aadhaar_number',

            // Bank
            'bank_name',
            'account_holder_name',
            'account_number',
            'ifsc_code',
            'branch_name',
        ];

        $updateData = [];

        foreach ($profileFields as $field) {

            if (
                array_key_exists(
                    $field,
                    $validated
                )
            ) {
                $updateData[$field] =
                    $validated[$field];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SHOP LOGO
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('shop_logo')) {

            $newLogo =
                $request->file('shop_logo');

            /*
            |--------------------------------------------------------------------------
            | DELETE OLD LOGO
            |--------------------------------------------------------------------------
            */

            if (!empty($seller->shop_logo)) {

                $oldLogo =
                    ltrim(
                        trim(
                            $seller->shop_logo
                        ),
                        '/'
                    );

                /*
                | storage/ prefix remove
                */

                if (
                    str_starts_with(
                        $oldLogo,
                        'storage/'
                    )
                ) {
                    $oldLogo =
                        substr(
                            $oldLogo,
                            strlen('storage/')
                        );
                }

                /*
                | Delete exact stored file
                */

                Storage::disk('public')
                    ->delete($oldLogo);

                /*
                | Legacy filename support
                */

                if (
                    !str_contains(
                        $oldLogo,
                        '/'
                    )
                ) {
                    Storage::disk('public')
                        ->delete(
                            'seller-logos/' .
                            $oldLogo
                        );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | UNIQUE FILE NAME
            |--------------------------------------------------------------------------
            */

            $extension =
                strtolower(
                    $newLogo
                        ->getClientOriginalExtension()
                );

            $filename =
                'seller-' .
                $seller->id .
                '-' .
                time() .
                '-' .
                uniqid() .
                '.' .
                $extension;

            /*
            |--------------------------------------------------------------------------
            | STORE LOGO
            |--------------------------------------------------------------------------
            */

            $logoPath =
                $newLogo->storeAs(
                    'seller-logos',
                    $filename,
                    'public'
                );

            /*
            |--------------------------------------------------------------------------
            | VERIFY LOGO
            |--------------------------------------------------------------------------
            */

            if (
                !$logoPath ||
                !Storage::disk('public')
                    ->exists($logoPath)
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'shop_logo' =>
                            'Shop logo could not be saved. Please try again.',
                    ]);
            }

            /*
            |--------------------------------------------------------------------------
            | DATABASE PATH
            |--------------------------------------------------------------------------
            */

            $updateData['shop_logo'] =
                $logoPath;
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE EVERYTHING TO DATABASE
        |--------------------------------------------------------------------------
        |
        | forceFill() ensures that these profile fields are written even if
        | the SellerProfile model has an incomplete $fillable array.
        |
        */

        $seller->forceFill(
            $updateData
        );

        $seller->save();

        /*
        |--------------------------------------------------------------------------
        | REFRESH DATABASE MODEL
        |--------------------------------------------------------------------------
        */

        $seller->refresh();

        /*
        |--------------------------------------------------------------------------
        | UPDATE SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'seller_login' =>
                true,

            'seller_email' =>
                $seller->email,

            'seller_id' =>
                $seller->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'seller.profile'
            )
            ->with(
                'success',
                'All profile changes saved successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SELLER PRODUCTS
    |--------------------------------------------------------------------------
    */

    public function myProducts()
    {
        $seller =
            $this->currentSeller();

        $products =
            Product::where(
                'seller_id',
                $seller->id
            )
                ->with('images')
                ->latest()
                ->get();

        return view(
            'seller.my-products',
            compact('products')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CURRENT SELLER
    |--------------------------------------------------------------------------
    */

    private function currentSeller(): SellerProfile
    {
        abort_unless(
            session('seller_login') &&
            session('seller_id'),
            403
        );

        return SellerProfile::findOrFail(
            (int) session('seller_id')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADD PRODUCT
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        if (
            !session()->has(
                'seller_login'
            )
        ) {
            return redirect()
                ->route(
                    'seller.login'
                );
        }

        $this->currentSeller();

        return view(
            'seller.add-product'
        );
    }

    public function store(
        Request $request
    ) {
        if (!session('seller_login')) {
            return redirect(
                '/seller-login'
            );
        }

        $sellerId =
            $this->currentSeller()->id;

        $request->validate([

            'name' =>
                'required|string|max:255',

            'category' =>
                'required|string|max:255',

            'brand' =>
                'nullable|string|max:255',

            'price' =>
                'required|numeric|min:0',

            'discount_price' =>
                'nullable|numeric|min:0',

            'description' =>
                'nullable|string',

            'image' =>
                'required|image|mimes:jpeg,png,jpg,webp|max:2048',

            'rating' =>
                'nullable|numeric|min:0|max:5',

            'stock' =>
                'required|integer|min:0',

            'size' =>
                'nullable|string|max:255',

            'color' =>
                'nullable|string|max:255',

            'status' =>
                'nullable|in:active,inactive',
        ]);

        $imageName =
            time() .
            '.' .
            $request->image->extension();

        $request->image->move(
            public_path('products'),
            $imageName
        );

        $product =
            Product::create([

                'seller_id' =>
                    $sellerId,

                'name' =>
                    $request->name,

                'category' =>
                    $request->category,

                'brand' =>
                    $request->brand,

                'description' =>
                    $request->description,

                'image' =>
                    $imageName,

                'price' =>
                    $request->price,

                'discount_price' =>
                    $request->discount_price,

                'rating' =>
                    $request->rating ?? 4.5,

                'stock' =>
                    $request->stock,

                'size' =>
                    $request->size,

                'color' =>
                    $request->color,

                'status' =>
                    $request->status ?? 'active',
            ]);

        $this->storeAdditionalImages(
            $request,
            $product
        );

        return redirect(
            '/seller-dashboard'
        )->with(
            'success',
            'Product Added Successfully 🚀'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT PRODUCT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        if (!session('seller_login')) {
            return redirect(
                '/seller-login'
            );
        }

        $product =
            Product::where(
                'seller_id',
                $this->currentSeller()->id
            )
                ->with('images')
                ->findOrFail($id);

        return view(
            'seller.edit-product',
            compact('product')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {
        if (!session('seller_login')) {
            return redirect(
                '/seller-login'
            );
        }

        $product =
            Product::where(
                'seller_id',
                $this->currentSeller()->id
            )
                ->findOrFail($id);

        $request->validate([

            'name' =>
                'required|string|max:255',

            'category' =>
                'required|string|max:255',

            'brand' =>
                'nullable|string|max:255',

            'price' =>
                'required|numeric|min:0',

            'discount_price' =>
                'nullable|numeric|min:0',

            'description' =>
                'nullable|string',

            'image' =>
                'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'rating' =>
                'nullable|numeric|min:0|max:5',

            'stock' =>
                'required|integer|min:0',

            'size' =>
                'nullable|string|max:255',

            'color' =>
                'nullable|string|max:255',

            'status' =>
                'nullable|in:active,inactive',
        ]);

        $data = [

            'name' =>
                $request->name,

            'category' =>
                $request->category,

            'brand' =>
                $request->brand,

            'description' =>
                $request->description,

            'price' =>
                $request->price,

            'discount_price' =>
                $request->discount_price,

            'rating' =>
                $request->rating ?? 4.5,

            'stock' =>
                $request->stock,

            'size' =>
                $request->size,

            'color' =>
                $request->color,

            'status' =>
                $request->status ?? 'active',
        ];

        if ($request->hasFile('image')) {

            $imageName =
                time() .
                '.' .
                $request->image->extension();

            $request->image->move(
                public_path('products'),
                $imageName
            );

            $data['image'] =
                $imageName;
        }

        $product->update($data);

        $this->storeAdditionalImages(
            $request,
            $product
        );

        return redirect(
            '/seller-dashboard'
        )->with(
            'success',
            'Product Updated Successfully ✅'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        if (!session('seller_login')) {
            return redirect(
                '/seller-login'
            );
        }

        $product =
            Product::where(
                'seller_id',
                $this->currentSeller()->id
            )
                ->findOrFail($id);

        $product->delete();

        return redirect(
            '/seller-dashboard'
        )->with(
            'success',
            'Product Deleted Successfully 🗑️'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER STATUS
    |--------------------------------------------------------------------------
    */

    public function updateOrderStatus(
        Request $request,
        Order $order
    ) {
        if (!session('seller_login')) {
            return redirect(
                '/seller-login'
            );
        }

        $this->currentSeller();

        abort_unless(
            $order->belongsToSeller(
                (int) session('seller_id')
            ),
            404
        );

        $request->validate([
            'order_status' =>
                'required|in:Placed,Confirmed,Packed,Picked By Delivery Partner,Out For Delivery,Near Customer,Delivered,Cancelled',
        ]);

        $order->update([

            'order_status' =>
                $request->order_status,

            'status' =>
                $request->order_status,

            'delivery_status' =>
                $request->order_status,
        ]);

        return back()->with(
            'success',
            'Order status updated.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SELLER SETTINGS
    |--------------------------------------------------------------------------
    */

    public function settings()
    {
        $seller =
            $this->currentSeller();

        return view(
            'seller.settings',
            [
                'seller' =>
                    $seller,

                'preferences' =>
                    array_merge(
                        $this->defaultSellerPreferences(),
                        $seller->preferences ?? []
                    ),
            ]
        );
    }

    public function updateSettings(
        Request $request
    ) {
        $seller =
            $this->currentSeller();

        $validated =
            $request->validate([

                'theme' => [
                    'sometimes',
                    'required',
                    'in:light,dark,system',
                ],

                'notifications_enabled' => [
                    'sometimes',
                    'boolean',
                ],

                'online_payments_enabled' => [
                    'sometimes',
                    'boolean',
                ],

                'preferences' => [
                    'sometimes',
                    'array',
                ],

                'preferences.*' => [
                    'nullable',
                ],

                'preferences.shipping_enabled' =>
                    ['sometimes', 'boolean'],

                'preferences.seller_delivery' =>
                    ['sometimes', 'boolean'],

                'preferences.platform_delivery' =>
                    ['sometimes', 'boolean'],

                'preferences.pickup_option' =>
                    ['sometimes', 'boolean'],

                'preferences.same_day_delivery' =>
                    ['sometimes', 'boolean'],

                'preferences.express_delivery' =>
                    ['sometimes', 'boolean'],

                'preferences.auto_accept_orders' =>
                    ['sometimes', 'boolean'],

                'preferences.allow_order_cancellation' =>
                    ['sometimes', 'boolean'],

                'preferences.allow_return_requests' =>
                    ['sometimes', 'boolean'],

                'preferences.allow_exchange_requests' =>
                    ['sometimes', 'boolean'],

                'preferences.auto_update_order_status' =>
                    ['sometimes', 'boolean'],

                'preferences.order_confirmation_notification' =>
                    ['sometimes', 'boolean'],

                'preferences.delivery_status_notification' =>
                    ['sometimes', 'boolean'],

                'preferences.default_product_status' =>
                    ['sometimes', 'in:active,inactive'],

                'preferences.default_rating' =>
                    ['sometimes', 'numeric', 'min:0', 'max:5'],

                'preferences.low_stock_threshold' =>
                    ['sometimes', 'integer', 'min:0', 'max:100000'],

                'preferences.allow_customer_reviews' =>
                    ['sometimes', 'boolean'],

                'preferences.allow_customer_questions' =>
                    ['sometimes', 'boolean'],

                'preferences.show_stock_quantity' =>
                    ['sometimes', 'boolean'],

                'preferences.product_visibility_enabled' =>
                    ['sometimes', 'boolean'],

                'preferences.auto_hide_out_of_stock' =>
                    ['sometimes', 'boolean'],

                'preferences.profile_visibility' =>
                    ['sometimes', 'boolean'],

                'preferences.shop_visibility' =>
                    ['sometimes', 'boolean'],

                'preferences.show_mobile_number' =>
                    ['sometimes', 'boolean'],

                'preferences.show_email' =>
                    ['sometimes', 'boolean'],

                'preferences.show_business_information' =>
                    ['sometimes', 'boolean'],

                'preferences.allow_customer_messages' =>
                    ['sometimes', 'boolean'],

                'preferences.auto_reply' =>
                    ['sometimes', 'boolean'],

                'preferences.welcome_message' =>
                    [
                        'sometimes',
                        'nullable',
                        'string',
                        'max:1000',
                    ],

                'preferences.order_message' =>
                    [
                        'sometimes',
                        'nullable',
                        'string',
                        'max:1000',
                    ],

                'preferences.cancellation_message' =>
                    [
                        'sometimes',
                        'nullable',
                        'string',
                        'max:1000',
                    ],

                'preferences.delivery_message' =>
                    [
                        'sometimes',
                        'nullable',
                        'string',
                        'max:1000',
                    ],

                'preferences.show_seller_logo_on_invoice' =>
                    ['sometimes', 'boolean'],

                'preferences.show_gst_on_invoice' =>
                    ['sometimes', 'boolean'],

                'preferences.show_seller_address_on_invoice' =>
                    ['sometimes', 'boolean'],

                'preferences.show_customer_address_on_invoice' =>
                    ['sometimes', 'boolean'],

                'preferences.show_payment_details_on_invoice' =>
                    ['sometimes', 'boolean'],

                'preferences.show_qr_on_invoice' =>
                    ['sometimes', 'boolean'],

                'preferences.invoice_prefix' =>
                    [
                        'sometimes',
                        'nullable',
                        'string',
                        'max:30',
                    ],

                'preferences.invoice_footer' =>
                    [
                        'sometimes',
                        'nullable',
                        'string',
                        'max:1000',
                    ],

                'preferences.store_active' =>
                    ['sometimes', 'boolean'],

                'preferences.temporarily_closed' =>
                    ['sometimes', 'boolean'],

                'preferences.vacation_mode' =>
                    ['sometimes', 'boolean'],

                'preferences.delivery_charge' =>
                    [
                        'sometimes',
                        'numeric',
                        'min:0',
                        'max:1000000',
                    ],

                'preferences.free_shipping_threshold' =>
                    [
                        'sometimes',
                        'numeric',
                        'min:0',
                        'max:10000000',
                    ],

                'preferences.estimated_delivery_days' =>
                    [
                        'sometimes',
                        'integer',
                        'min:1',
                        'max:365',
                    ],
            ]);

        $data = [];

        foreach (
            [
                'theme',
                'notifications_enabled',
                'online_payments_enabled',
            ]
            as $field
        ) {
            if (
                array_key_exists(
                    $field,
                    $validated
                )
            ) {
                $data[$field] =
                    $validated[$field];
            }
        }

        if (
            isset(
                $validated['preferences']
            )
        ) {
            $current =
                array_merge(
                    $this->defaultSellerPreferences(),
                    $seller->preferences ?? []
                );

            $data['preferences'] =
                array_merge(
                    $current,
                    $validated['preferences']
                );
        }

        $seller->update($data);

        return back()->with(
            'success',
            'Settings saved successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CHANGE PASSWORD
    |--------------------------------------------------------------------------
    */

    public function updatePassword(
        Request $request
    ) {
        $seller =
            $this->currentSeller();

        $validated =
            $request->validate([

                'current_password' => [
                    'required',
                    'string',
                ],

                'password' => [
                    'required',
                    'confirmed',

                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                ],
            ]);

        if (
            !Hash::check(
                $validated['current_password'],
                $seller->password
            )
        ) {
            return back()
                ->withErrors([
                    'current_password' =>
                        'The current password is incorrect.',
                ]);
        }

        $seller->update([
            'password' =>
                Hash::make(
                    $validated['password']
                ),
        ]);

        return back()->with(
            'success',
            'Password changed successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DEFAULT SELLER PREFERENCES
    |--------------------------------------------------------------------------
    */

    private function defaultSellerPreferences(): array
    {
        return [

            'shipping_enabled' =>
                true,

            'seller_delivery' =>
                true,

            'platform_delivery' =>
                false,

            'pickup_option' =>
                false,

            'same_day_delivery' =>
                false,

            'express_delivery' =>
                false,

            'delivery_charge' =>
                0,

            'free_shipping_threshold' =>
                0,

            'estimated_delivery_days' =>
                3,

            'auto_accept_orders' =>
                false,

            'allow_order_cancellation' =>
                true,

            'allow_return_requests' =>
                true,

            'allow_exchange_requests' =>
                false,

            'auto_update_order_status' =>
                false,

            'order_confirmation_notification' =>
                true,

            'delivery_status_notification' =>
                true,

            'default_product_status' =>
                'active',

            'default_rating' =>
                4.5,

            'low_stock_threshold' =>
                5,

            'allow_customer_reviews' =>
                true,

            'allow_customer_questions' =>
                true,

            'show_stock_quantity' =>
                true,

            'product_visibility_enabled' =>
                true,

            'auto_hide_out_of_stock' =>
                false,

            'profile_visibility' =>
                true,

            'shop_visibility' =>
                true,

            'show_mobile_number' =>
                false,

            'show_email' =>
                false,

            'show_business_information' =>
                true,

            'allow_customer_messages' =>
                true,

            'auto_reply' =>
                false,

            'welcome_message' =>
                '',

            'order_message' =>
                '',

            'cancellation_message' =>
                '',

            'delivery_message' =>
                '',

            'show_seller_logo_on_invoice' =>
                true,

            'show_gst_on_invoice' =>
                true,

            'show_seller_address_on_invoice' =>
                true,

            'show_customer_address_on_invoice' =>
                true,

            'show_payment_details_on_invoice' =>
                true,

            'show_qr_on_invoice' =>
                false,

            'invoice_prefix' =>
                'SB-',

            'invoice_footer' =>
                '',

            'store_active' =>
                true,

            'temporarily_closed' =>
                false,

            'vacation_mode' =>
                false,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT QR
    |--------------------------------------------------------------------------
    */

    public function updatePaymentQr(
        Request $request
    ) {
        $data =
            $request->validate([
                'payment_qr' => [
                    'required',
                    'image',
                    'mimes:jpeg,jpg,png,webp',
                    'max:2048',
                ],
            ]);

        $seller =
            $this->currentSeller();

        /*
        | Delete old QR
        */

        if (!empty($seller->payment_qr)) {

            $oldQr =
                ltrim(
                    $seller->payment_qr,
                    '/'
                );

            if (
                str_starts_with(
                    $oldQr,
                    'storage/'
                )
            ) {
                $oldQr =
                    substr(
                        $oldQr,
                        strlen('storage/')
                    );
            }

            Storage::disk('public')
                ->delete($oldQr);
        }

        /*
        | Store new QR
        */

        $seller->payment_qr =
            $data['payment_qr']
                ->store(
                    'seller-payment-qr',
                    'public'
                );

        $seller->save();

        return back()->with(
            'success',
            'Payment QR updated successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE PAYMENT QR
    |--------------------------------------------------------------------------
    */

    public function deletePaymentQr()
    {
        $seller =
            $this->currentSeller();

        if (!empty($seller->payment_qr)) {

            $oldQr =
                ltrim(
                    $seller->payment_qr,
                    '/'
                );

            if (
                str_starts_with(
                    $oldQr,
                    'storage/'
                )
            ) {
                $oldQr =
                    substr(
                        $oldQr,
                        strlen('storage/')
                    );
            }

            Storage::disk('public')
                ->delete($oldQr);
        }

        $seller->update([
            'payment_qr' =>
                null,
        ]);

        return back()->with(
            'success',
            'Payment QR removed successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADDITIONAL PRODUCT IMAGES
    |--------------------------------------------------------------------------
    */

    private function storeAdditionalImages(
        Request $request,
        Product $product
    ): void {
        $request->validate([

            'images' => [
                'nullable',
                'array',
                'max:8',
            ],

            'images.*' => [
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
            ],
        ]);

        foreach (
            $request->file(
                'images',
                []
            ) as $index => $image
        ) {
            $product->images()->create([

                'path' =>
                    $image->store(
                        'product-images',
                        'public'
                    ),

                'sort_order' =>
                    $index,
            ]);
        }
    }
}