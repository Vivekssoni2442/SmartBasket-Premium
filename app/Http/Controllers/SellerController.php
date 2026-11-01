<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Notification;
use App\Models\SellerProfile;
use App\Services\SiteSettings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

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

        if ($seller && $seller->isBlocked()) {
            return back()->withInput($request->only('email'))->with('error', 'This seller account is blocked. Please contact Smart Basket support for assistance.');
        }

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
        $request->session()->forget(['seller_face_pending_id', 'seller_face_unlocked_at']);

        if ($seller->face_unlock_enabled) {
            if (! $seller->hasPasskeysEnabled()) {
                return back()->withInput($request->only('email'))->with('error', 'Face unlock is enabled but this account has no registered device. Contact support to restore access.');
            }

            Auth::guard('seller')->logout();
            $request->session()->put('seller_face_pending_id', $seller->id);

            return redirect()->route('seller.face-unlock');
        }

        Auth::guard('seller')->login($seller);

        $request->session()->put([
            'seller_login' => true,
            'seller_email' => $seller->email,
            'seller_id' => $seller->id,
        ]);

        $request->session()->flash('seller_login_welcome', true);

        if ($seller->isApproved() || $seller->isActive()) {
            return redirect()->route('seller.dashboard');
        }

        if (
            $seller->isApplicationSubmitted() ||
            $seller->isRejected() ||
            $seller->isSuspended()
        ) {
            return redirect()->route(
                'seller.verification.status'
            );
        }

        return redirect()->route(
            'seller.verification.index'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SELLER REGISTRATION
    |--------------------------------------------------------------------------
    */

    public function showRegistration()
    {
        abort_unless(app(SiteSettings::class)->enabled('seller_registration_enabled'), 404);
        return view('auth.seller-register');
    }

    public function register(Request $request)
    {
        abort_unless(app(SiteSettings::class)->enabled('seller_registration_enabled'), 404);
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

            'verification_status' =>
                SellerProfile::STATUS_DRAFT,

            'onboarding_step' =>
                1,
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

        /*
        |--------------------------------------------------------------------------
        | SELLER PRODUCTS
        |--------------------------------------------------------------------------
        */

        $products = Product::where(
            'seller_id',
            $sellerId
        )
            ->with('images')
            ->latest()
            ->get();

        $totalProducts =
            $products->count();

        /*
        |--------------------------------------------------------------------------
        | SELLER ORDERS
        |--------------------------------------------------------------------------
        */

        $sellerProductIds = $products
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->values();

        $sellerOrders = Order::query()
            ->where(function ($query) use (
                $sellerId,
                $sellerProductIds
            ) {
                $query
                    ->where(
                        'seller_id',
                        $sellerId
                    )
                    ->orWhereJsonContains(
                        'items',
                        [
                            'seller_id' => $sellerId,
                        ]
                    );

                if (
                    $sellerProductIds->isNotEmpty()
                ) {
                    $query->orWhere(
                        function ($legacy) use (
                            $sellerProductIds
                        ) {
                            foreach (
                                $sellerProductIds
                                as $productId
                            ) {
                                $legacy->orWhereJsonContains(
                                    'items',
                                    [
                                        'product_id' =>
                                            $productId,
                                    ]
                                );
                            }
                        }
                    );
                }
            });

        /*
        |--------------------------------------------------------------------------
        | TOTAL ORDERS
        |--------------------------------------------------------------------------
        */

        $totalOrders =
            (clone $sellerOrders)->count();

        /*
        |--------------------------------------------------------------------------
        | PENDING ORDERS
        |--------------------------------------------------------------------------
        */

        $pendingOrders =
            (clone $sellerOrders)
                ->where(
                    function ($query) {
                        $query
                            ->where(
                                'status',
                                'Pending'
                            )
                            ->orWhere(
                                'order_status',
                                'Pending'
                            );
                    }
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | EARNING ORDERS
        |--------------------------------------------------------------------------
        */

        $earningOrders =
            (clone $sellerOrders)
                ->where(
                    function ($query) {
                        $query
                            ->whereNull('status')
                            ->orWhereNotIn(
                                'status',
                                [
                                    'Cancelled',
                                    'Canceled',
                                ]
                            );
                    }
                )
                ->get([
                    'id',
                    'seller_id',
                    'total',
                    'items',
                ]);

        /*
        |--------------------------------------------------------------------------
        | LEGACY PRODUCT SELLER MAP
        |--------------------------------------------------------------------------
        */

        $legacyProductIds =
            $earningOrders
                ->flatMap(
                    fn ($order) =>
                        collect(
                            $order->items ?? []
                        )
                )
                ->filter(
                    fn ($item) =>
                        empty($item['seller_id']) &&
                        !empty($item['product_id'])
                )
                ->pluck('product_id')
                ->map(
                    fn ($id) =>
                        (int) $id
                )
                ->unique()
                ->values();

        $legacyProductSellerMap =
            $legacyProductIds->isNotEmpty()
                ? Product::whereIn(
                    'id',
                    $legacyProductIds
                )->pluck(
                    'seller_id',
                    'id'
                )
                : collect();

        /*
        |--------------------------------------------------------------------------
        | TOTAL EARNINGS
        |--------------------------------------------------------------------------
        */

        $totalEarnings =
            $earningOrders->sum(
                function ($order) use (
                    $sellerId,
                    $legacyProductSellerMap
                ) {
                    return collect(
                        $order->items ?? []
                    )->sum(
                        function ($item) use (
                            $sellerId,
                            $legacyProductSellerMap
                        ) {
                            $itemSellerId =
                                $item['seller_id']
                                ?? null;

                            if (
                                $itemSellerId === null &&
                                !empty(
                                    $item['product_id']
                                )
                            ) {
                                $itemSellerId =
                                    $legacyProductSellerMap[
                                        (int)
                                        $item['product_id']
                                    ] ?? null;
                            }

                            if (
                                (int) $itemSellerId !==
                                (int) $sellerId
                            ) {
                                return 0;
                            }

                            $quantity =
                                max(
                                    1,
                                    (int) (
                                        $item['quantity']
                                        ?? 1
                                    )
                                );

                            $price =
                                (float) (
                                    $item['price']
                                    ?? 0
                                );

                            return
                                $price *
                                $quantity;
                        }
                    );
                }
            );

        $totalEarnings =
            round(
                (float) $totalEarnings,
                2
            );

        /*
        |--------------------------------------------------------------------------
        | TOTAL REVENUE
        |--------------------------------------------------------------------------
        */

        $totalRevenue =
            $totalEarnings;

        /*
        |--------------------------------------------------------------------------
        | PAID ORDERS
        |--------------------------------------------------------------------------
        */

        $paidOrders =
            (clone $sellerOrders)
                ->whereIn(
                    'payment_status',
                    [
                        'Paid',
                        'Successful',
                    ]
                )
                ->where(
                    function ($query) {
                        $query
                            ->whereNull('status')
                            ->orWhereNotIn(
                                'status',
                                [
                                    'Cancelled',
                                    'Canceled',
                                ]
                            );
                    }
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | CANCELLED ORDERS
        |--------------------------------------------------------------------------
        */

        $cancelledOrders =
            (clone $sellerOrders)
                ->whereIn(
                    'status',
                    [
                        'Cancelled',
                        'Canceled',
                    ]
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | UNPAID ORDERS
        |--------------------------------------------------------------------------
        */

        $unpaidOrders =
            (clone $sellerOrders)
                ->whereNotIn(
                    'payment_status',
                    [
                        'Paid',
                        'Successful',
                    ]
                )
                ->count();

        return view(
            'seller.dashboard',
            compact(
                'products',
                'totalProducts',
                'totalOrders',
                'pendingOrders',
                'totalEarnings',
                'totalRevenue',
                'paidOrders',
                'cancelledOrders',
                'unpaidOrders',
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
        $seller =
            $this->currentSeller();

        return view(
            'seller.profile',
            compact('seller')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SELLER PROFILE
    |--------------------------------------------------------------------------
    */

    public function updateProfile(
        Request $request
    ) {
        $seller =
            $this->currentSeller();

        $validated =
            $request->validate([

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
                    )->ignore(
                        $seller->id
                    ),
                ],

                'mobile_number' => [
                    'required',
                    'string',
                    'max:20',
                ],

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

                'aadhaar_number' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

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

                'shop_logo' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,webp',
                    'max:4096',
                ],
            ]);

        $profileFields = [
            'seller_name',
            'shop_name',
            'email',
            'mobile_number',
            'shop_address',
            'city',
            'state',
            'pincode',
            'business_type',
            'gst_number',
            'pan_number',
            'udyam_number',
            'aadhaar_number',
            'bank_name',
            'account_holder_name',
            'account_number',
            'ifsc_code',
            'branch_name',
        ];

        $updateData = [];

        foreach (
            $profileFields as $field
        ) {
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

        if (
            $request->hasFile(
                'shop_logo'
            )
        ) {
            $newLogo =
                $request->file(
                    'shop_logo'
                );

            if (
                !empty(
                    $seller->shop_logo
                )
            ) {
                $oldLogo =
                    ltrim(
                        trim(
                            $seller->shop_logo
                        ),
                        '/'
                    );

                if (
                    str_starts_with(
                        $oldLogo,
                        'storage/'
                    )
                ) {
                    $oldLogo =
                        substr(
                            $oldLogo,
                            strlen(
                                'storage/'
                            )
                        );
                }

                Storage::disk(
                    'public'
                )->delete(
                    $oldLogo
                );

                if (
                    !str_contains(
                        $oldLogo,
                        '/'
                    )
                ) {
                    Storage::disk(
                        'public'
                    )->delete(
                        'seller-logos/' .
                        $oldLogo
                    );
                }
            }

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

            $logoPath =
                $newLogo->storeAs(
                    'seller-logos',
                    $filename,
                    'public'
                );

            if (
                !$logoPath ||
                !Storage::disk(
                    'public'
                )->exists(
                    $logoPath
                )
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'shop_logo' =>
                            'Shop logo could not be saved. Please try again.',
                    ]);
            }

            $updateData[
                'shop_logo'
            ] =
                $logoPath;
        }

        $seller->forceFill(
            $updateData
        );

        $seller->save();

        $seller->refresh();

        session([
            'seller_login' =>
                true,

            'seller_email' =>
                $seller->email,

            'seller_id' =>
                $seller->id,
        ]);

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
            (int) session(
                'seller_id'
            )
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

    /*
    |--------------------------------------------------------------------------
    | STORE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ) {
        if (
            !session(
                'seller_login'
            )
        ) {
            return redirect(
                '/seller-login'
            );
        }

        $seller = $this->currentSeller();
        $sellerId = $seller->id;
        $sellerPreferences = is_array($seller->preferences)
            ? $seller->preferences
            : [];

        $this->rejectPhpUploadErrors($request);

        $maxVideoSizeKb = config('product-media.max_video_size_kb', 102400);
        $maxVideoSizeMb = config('product-media.max_video_size_mb', 100);

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

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

            'sale_title' => 'nullable|string|max:255',
            'sale_offer' => 'nullable|string|max:500',
            'sale_price' => 'nullable|numeric|min:0|lt:price|required_with:sale_starts_at,sale_ends_at',
            'sale_starts_at' => 'nullable|date|required_with:sale_ends_at,sale_price',
            'sale_ends_at' => 'nullable|date|after:sale_starts_at|required_with:sale_starts_at,sale_price',
            'coupon_title' => 'nullable|string|max:255',
            'coupon_code' => 'nullable|string|max:80',
            'coupon_description' => 'nullable|string|max:500',
            'coupon_discount_type' => 'nullable|in:percent,fixed',
            'coupon_discount_value' => ['nullable', 'numeric', 'min:0', 'required_with:coupon_discount_type', Rule::when($request->input('coupon_discount_type') === 'percent', ['max:100'])],
            'coupon_starts_at' => 'nullable|date|required_with:coupon_title,coupon_code',
            'coupon_ends_at' => 'nullable|date|after:coupon_starts_at|required_with:coupon_title,coupon_code',
            'coupon_design' => 'nullable|in:royal,sunset,emerald,gold',

            'description' =>
                'nullable|string',

            'image' =>
                'required|image|mimes:jpeg,png,jpg,webp|max:2048',

            /*
            |--------------------------------------------------------------------------
            | PRODUCT VIDEO
            |--------------------------------------------------------------------------
            */

            'video' =>
                'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime|max:' . $maxVideoSizeKb,

            'video_poster' =>
                'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'videos' => 'nullable|array|max:8',
            'videos.*' => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime|max:' . $maxVideoSizeKb,
            'remove_video_ids' => 'nullable|array|max:8',
            'remove_video_ids.*' => 'integer|distinct',

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
        ], [
            'video.max' => "Product video must not exceed {$maxVideoSizeMb} MB.",
            'videos.*.max' => "Each additional product video must not exceed {$maxVideoSizeMb} MB.",
        ]);

        /*
        |--------------------------------------------------------------------------
        | MAIN PRODUCT IMAGE
        |--------------------------------------------------------------------------
        */

        $imageName =
            time() .
            '_' .
            uniqid() .
            '.' .
            $request
                ->image
                ->extension();

        $request->image->move(
            public_path(
                'products'
            ),
            $imageName
        );

        /*
        |--------------------------------------------------------------------------
        | CREATE PRODUCT
        |--------------------------------------------------------------------------
        */

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

                'sale_title' => $request->sale_title,
                'sale_offer' => $request->sale_offer,
                'sale_price' => $request->sale_price,
                'sale_starts_at' => $request->sale_starts_at,
                'sale_ends_at' => $request->sale_ends_at,
                'coupon_title' => $request->coupon_title,
                'coupon_code' => filled($request->coupon_code) ? strtoupper(trim($request->coupon_code)) : null,
                'coupon_description' => $request->coupon_description,
                'coupon_discount_type' => $request->coupon_discount_type,
                'coupon_discount_value' => $request->coupon_discount_value,
                'coupon_starts_at' => $request->coupon_starts_at,
                'coupon_ends_at' => $request->coupon_ends_at,
                'coupon_design' => $request->coupon_design,

                'rating' =>
                    $request->rating
                    ?? ($sellerPreferences['default_rating'] ?? 4.5),

                'stock' =>
                    $request->stock,

                'size' =>
                    $request->size,

                'color' =>
                    $request->color,

                'status' =>
                    $request->status
                    ?? ($sellerPreferences['default_product_status'] ?? 'active'),
            ]);

        /*
        |--------------------------------------------------------------------------
        | PRODUCT VIDEO
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile(
                'video'
            )
        ) {
            $video =
                $request->file(
                    'video'
                );

            $videoName =
                'product_' .
                $product->id .
                '_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $video->extension();

            $videoPath =
                $video->storeAs(
                    'product-videos',
                    $videoName,
                    'public'
                );

            if (
                !$videoPath ||
                !Storage::disk(
                    'public'
                )->exists(
                    $videoPath
                )
            ) {
                Log::error('Seller product video storage verification failed.', [
                    'request_id' => $this->productUploadRequestId($request),
                    'product_id' => $product->id,
                    'field' => 'video',
                    'path_returned' => (bool) $videoPath,
                ]);

                return back()
                    ->withInput()
                    ->withErrors([
                        'video' =>
                            'Product video could not be saved. Please try again.',
                    ]);
            }

            $product->video =
                $videoPath;

            $product->save();
        }

        if ($request->hasFile('video_poster')) {
            $posterPath = $request->file('video_poster')->store('product-video-posters', 'public');
            if (!$posterPath || !Storage::disk('public')->exists($posterPath)) {
                Log::error('Seller product poster storage verification failed.', [
                    'request_id' => $this->productUploadRequestId($request),
                    'product_id' => $product->id,
                    'field' => 'video_poster',
                    'path_returned' => (bool) $posterPath,
                ]);

                return back()->withInput()->withErrors([
                    'video_poster' => 'The video poster could not be saved. Please try again.',
                ]);
            }
            $product->video_poster = $posterPath;
            $product->save();
        }

        /*
        |--------------------------------------------------------------------------
        | ADDITIONAL PRODUCT IMAGES
        |--------------------------------------------------------------------------
        */

        $this->storeAdditionalImages(
            $request,
            $product
        );

        $this->storeAdditionalVideos($request, $product);

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

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

    public function edit(
        $id
    ) {
        if (
            !session(
                'seller_login'
            )
        ) {
            return redirect(
                '/seller-login'
            );
        }

        $product =
            Product::where(
                'seller_id',
                $this->currentSeller()->id
            )
                ->with(['images', 'videos'])
                ->findOrFail(
                    $id
                );

        return view(
            'seller.edit-product',
            compact(
                'product'
            )
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
        if (
            !session(
                'seller_login'
            )
        ) {
            return redirect(
                '/seller-login'
            );
        }

        $seller =
            $this->currentSeller();

        /*
        |--------------------------------------------------------------------------
        | GET SELLER PRODUCT
        |--------------------------------------------------------------------------
        */

        $product =
            Product::where(
                'seller_id',
                $seller->id
            )
                ->findOrFail(
                    $id
                );

        $this->rejectPhpUploadErrors($request);

        $maxVideoSizeKb = config('product-media.max_video_size_kb', 102400);
        $maxVideoSizeMb = config('product-media.max_video_size_mb', 100);

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

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

            'sale_title' => 'nullable|string|max:255',
            'sale_offer' => 'nullable|string|max:500',
            'sale_price' => 'nullable|numeric|min:0|lt:price|required_with:sale_starts_at,sale_ends_at',
            'sale_starts_at' => 'nullable|date|required_with:sale_ends_at,sale_price',
            'sale_ends_at' => 'nullable|date|after:sale_starts_at|required_with:sale_starts_at,sale_price',
            'coupon_title' => 'nullable|string|max:255',
            'coupon_code' => 'nullable|string|max:80',
            'coupon_description' => 'nullable|string|max:500',
            'coupon_discount_type' => 'nullable|in:percent,fixed',
            'coupon_discount_value' => ['nullable', 'numeric', 'min:0', 'required_with:coupon_discount_type', Rule::when($request->input('coupon_discount_type') === 'percent', ['max:100'])],
            'coupon_starts_at' => 'nullable|date|required_with:coupon_title,coupon_code',
            'coupon_ends_at' => 'nullable|date|after:coupon_starts_at|required_with:coupon_title,coupon_code',
            'coupon_design' => 'nullable|in:royal,sunset,emerald,gold',

            'description' =>
                'nullable|string',

            'image' =>
                'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            /*
            |--------------------------------------------------------------------------
            | PRODUCT VIDEO
            |--------------------------------------------------------------------------
            */

            'video' =>
                'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime|max:' . $maxVideoSizeKb,

            'videos' => 'nullable|array|max:8',
            'videos.*' => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime|max:' . $maxVideoSizeKb,
            'remove_video_ids' => 'nullable|array|max:8',
            'remove_video_ids.*' => 'integer|distinct',

            'video_poster' =>
                'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'remove_video' =>
                'nullable|boolean',

            'video_playback_speed' =>
                'nullable|numeric|min:0.25|max:4',

            'video_volume' =>
                'nullable|numeric|min:0|max:1',

            'video_rotation' =>
                'nullable|integer|in:0,90,180,270',

            'video_autoplay' =>
                'nullable|boolean',

            'video_loop' =>
                'nullable|boolean',

            'video_muted' =>
                'nullable|boolean',

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
        ], [
            'video.max' => "Product video must not exceed {$maxVideoSizeMb} MB.",
            'videos.*.max' => "Each additional product video must not exceed {$maxVideoSizeMb} MB.",
        ]);

        /*
        |--------------------------------------------------------------------------
        | BASIC PRODUCT DATA
        |--------------------------------------------------------------------------
        */

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

            'sale_title' => $request->sale_title,
            'sale_offer' => $request->sale_offer,
            'sale_price' => $request->sale_price,
            'sale_starts_at' => $request->sale_starts_at,
            'sale_ends_at' => $request->sale_ends_at,
            'coupon_title' => $request->coupon_title,
            'coupon_code' => filled($request->coupon_code) ? strtoupper(trim($request->coupon_code)) : null,
            'coupon_description' => $request->coupon_description,
            'coupon_discount_type' => $request->coupon_discount_type,
            'coupon_discount_value' => $request->coupon_discount_value,
            'coupon_starts_at' => $request->coupon_starts_at,
            'coupon_ends_at' => $request->coupon_ends_at,
            'coupon_design' => $request->coupon_design,

            'rating' =>
                $request->rating
                ?? 4.5,

            'stock' =>
                $request->stock,

            'size' =>
                $request->size,

            'color' =>
                $request->color,

            'status' =>
                $request->status
                ?? 'active',
        ];

        /*
        |--------------------------------------------------------------------------
        | REPLACE MAIN PRODUCT IMAGE
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile(
                'image'
            )
        ) {
            $imageName =
                time() .
                '_' .
                uniqid() .
                '.' .
                $request
                    ->image
                    ->extension();

            $request->image->move(
                public_path(
                    'products'
                ),
                $imageName
            );

            /*
            |----------------------------------------------------------------------
            | DELETE OLD IMAGE
            |----------------------------------------------------------------------
            */

            if (
                !empty(
                    $product->image
                )
            ) {
                $oldImage =
                    public_path(
                        'products/' .
                        $product->image
                    );

                if (
                    is_file(
                        $oldImage
                    )
                ) {
                    @unlink(
                        $oldImage
                    );
                }
            }

            $data['image'] =
                $imageName;
        }

        $oldVideoPath = $product->video;
        $oldPosterPath = $product->video_poster;

        /*
        |--------------------------------------------------------------------------
        | REMOVE EXISTING VIDEO
        |--------------------------------------------------------------------------
        */

        if (
            $request->boolean(
                'remove_video'
            )
        ) {
            $data['video'] =
                null;
            $data['video_poster'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | REPLACE PRODUCT VIDEO
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile(
                'video'
            )
        ) {
            /*
            |----------------------------------------------------------------------
            | NEW VIDEO
            |----------------------------------------------------------------------
            */

            $video =
                $request->file(
                    'video'
                );

            $videoName =
                'product_' .
                $product->id .
                '_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $video->extension();

            $videoPath =
                $video->storeAs(
                    'product-videos',
                    $videoName,
                    'public'
                );

            if (
                !$videoPath ||
                !Storage::disk(
                    'public'
                )->exists(
                    $videoPath
                )
            ) {
                Log::error('Seller product video storage verification failed.', [
                    'request_id' => $this->productUploadRequestId($request),
                    'product_id' => $product->id,
                    'field' => 'video',
                    'path_returned' => (bool) $videoPath,
                ]);

                return back()
                    ->withInput()
                    ->withErrors([
                        'video' =>
                            'Product video could not be saved. Please try again.',
                    ]);
            }

            $data['video'] =
                $videoPath;

            // A poster belongs to the video it was uploaded with. Clear the old
            // one on replacement unless the seller supplies a replacement poster.
            if (!$request->hasFile('video_poster')) {
                $data['video_poster'] = null;
            }
        }

        if ($request->hasFile('video_poster')) {
            $posterPath = $request->file('video_poster')->store('product-video-posters', 'public');
            if (!$posterPath || !Storage::disk('public')->exists($posterPath)) {
                Log::error('Seller product poster storage verification failed.', [
                    'request_id' => $this->productUploadRequestId($request),
                    'product_id' => $product->id,
                    'field' => 'video_poster',
                    'path_returned' => (bool) $posterPath,
                ]);

                return back()->withInput()->withErrors([
                    'video_poster' => 'The video poster could not be saved. Please try again.',
                ]);
            }
            $data['video_poster'] = $posterPath;
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE PRODUCT
        |--------------------------------------------------------------------------
        */

        $product->update(
            $data
        );

        if (
            !empty($oldVideoPath) &&
            array_key_exists('video', $data) &&
            $oldVideoPath !== $data['video']
        ) {
            Storage::disk('public')->delete($oldVideoPath);
        }

        if (!empty($oldPosterPath) && array_key_exists('video_poster', $data) && $oldPosterPath !== $data['video_poster']) {
            Storage::disk('public')->delete($oldPosterPath);
        }

        $this->removeAdditionalVideos($request, $product);

        /*
        |--------------------------------------------------------------------------
        | ADDITIONAL IMAGES
        |--------------------------------------------------------------------------
        */

        $this->storeAdditionalImages(
            $request,
            $product
        );

        $this->storeAdditionalVideos($request, $product);

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

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

    public function destroy(
        $id
    ) {
        if (
            !session(
                'seller_login'
            )
        ) {
            return redirect(
                '/seller-login'
            );
        }

        $product =
            Product::where(
                'seller_id',
                $this->currentSeller()->id
            )
                ->findOrFail(
                    $id
                );

        /*
        |--------------------------------------------------------------------------
        | DELETE PRODUCT VIDEO
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $product->video
            )
        ) {
            Storage::disk(
                'public'
            )->delete(
                $product->video
            );
        }

        foreach ($product->videos as $extraVideo) {
            Storage::disk('public')->delete($extraVideo->path);
        }

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
        if (
            !session(
                'seller_login'
            )
        ) {
            return redirect(
                '/seller-login'
            );
        }

        $this->currentSeller();

        abort_unless(
            $order->belongsToSeller(
                (int) session(
                    'seller_id'
                )
            ),
            404
        );

        $validated = $request->validate([
            'order_status' =>
                'required|in:Placed,Confirmed,Packed,Picked By Delivery Partner,Out For Delivery,Near Customer,Delivered,Cancelled',
        ]);

        $currentStatus = $order->order_status ?: $order->status ?: 'Placed';
        if (str_contains(strtolower((string) $order->payment_method), 'upi')
            && ! in_array(strtolower((string) $order->payment_status), ['paid', 'successful', 'verified'], true)
            && in_array($validated['order_status'], ['Confirmed', 'Packed', 'Picked By Delivery Partner', 'Out For Delivery', 'Near Customer', 'Delivered'], true)) {
            return back()->with('error', 'Verify the UPI credit in UPI Payment Reviews before confirming or dispatching this order.');
        }

        $allowedTransitions = [
            'Placed' => ['Confirmed', 'Cancelled'],
            'Confirmed' => ['Packed', 'Cancelled'],
            'Packed' => ['Picked By Delivery Partner', 'Cancelled'],
            'Picked By Delivery Partner' => ['Out For Delivery', 'Cancelled'],
            'Out For Delivery' => ['Near Customer', 'Delivered'],
            'Near Customer' => ['Delivered'],
            'Delivered' => [],
            'Cancelled' => [],
        ];

        $nextStatus = $validated['order_status'];
        if ($nextStatus !== $currentStatus && ! in_array($nextStatus, $allowedTransitions[$currentStatus] ?? [], true)) {
            return back()->with('error', 'This order status transition is not allowed.');
        }

        $order->update([

            'order_status' =>
                $nextStatus,

            'status' =>
                $nextStatus,

            'delivery_status' =>
                $nextStatus,
        ]);

        Notification::create([
            'user_id' => $order->user_id,
            'role' => 'user',
            'type' => 'order_status',
            'title' => 'Order status updated',
            'message' => 'Order #' . $order->id . ' is now ' . $nextStatus . '.',
            'data' => ['order_id' => $order->id, 'order_status' => $nextStatus],
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
                        $seller->preferences
                        ?? []
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
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.seller_delivery' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.platform_delivery' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.pickup_option' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.same_day_delivery' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.express_delivery' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.auto_accept_orders' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.allow_order_cancellation' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.allow_return_requests' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.allow_exchange_requests' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.auto_update_order_status' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.order_confirmation_notification' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.delivery_status_notification' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.default_product_status' =>
                    [
                        'sometimes',
                        'in:active,inactive',
                    ],

                'preferences.default_rating' =>
                    [
                        'sometimes',
                        'numeric',
                        'min:0',
                        'max:5',
                    ],

                'preferences.low_stock_threshold' =>
                    [
                        'sometimes',
                        'integer',
                        'min:0',
                        'max:100000',
                    ],

                'preferences.allow_customer_reviews' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.allow_customer_questions' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.show_stock_quantity' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.product_visibility_enabled' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.auto_hide_out_of_stock' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.profile_visibility' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.shop_visibility' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.show_mobile_number' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.show_email' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.show_business_information' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.allow_customer_messages' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.auto_reply' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

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
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.show_gst_on_invoice' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.show_seller_address_on_invoice' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.show_customer_address_on_invoice' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.show_payment_details_on_invoice' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.show_qr_on_invoice' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

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
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.temporarily_closed' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

                'preferences.vacation_mode' =>
                    [
                        'sometimes',
                        'boolean',
                    ],

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
            ] as $field
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
                    $seller->preferences
                    ?? []
                );

            $data['preferences'] =
                array_merge(
                    $current,
                    $validated['preferences']
                );
        }

        $seller->update(
            $data
        );

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
                $validated[
                    'current_password'
                ],
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
                    $validated[
                        'password'
                    ]
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

        if (!$seller) {
            return back()->with(
                'error',
                'Seller session not found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE OLD QR
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $seller->payment_qr
            )
        ) {
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
                        strlen(
                            'storage/'
                        )
                    );
            }

            Storage::disk(
                'public'
            )->delete(
                $oldQr
            );
        }

        /*
        |--------------------------------------------------------------------------
        | STORE NEW QR
        |--------------------------------------------------------------------------
        */

        $qrPath =
            $data[
                'payment_qr'
            ]->store(
                'seller-payment-qr',
                'public'
            );

        if (
            !$qrPath ||
            !Storage::disk(
                'public'
            )->exists(
                $qrPath
            )
        ) {
            return back()->with(
                'error',
                'Payment QR could not be saved.'
            );
        }

        $seller->payment_qr =
            $qrPath;

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

        if (
            !empty(
                $seller->payment_qr
            )
        ) {
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
                        strlen(
                            'storage/'
                        )
                    );
            }

            Storage::disk(
                'public'
            )->delete(
                $oldQr
            );
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
        /*
        |--------------------------------------------------------------------------
        | ADDITIONAL IMAGE UPLOAD
        |--------------------------------------------------------------------------
        |
        | The old implementation used only Laravel's `image` rule. When PHP
        | rejects an uploaded file before Laravel can process it (for example
        | because upload_max_filesize/post_max_size is too small), Laravel
        | reports `images.0 failed to upload`.
        |
        | This version validates the array first, checks every UploadedFile's
        | actual upload status, stores each image on the public disk, verifies
        | that the file really exists, and only then creates the DB record.
        |
        | Maximum: 8 gallery images, 8 MB each.
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'images' => [
                'nullable',
                'array',
                'max:8',
            ],

            'images.*' => [
                'nullable',
                'file',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:8192',
            ],
        ]);

        $files = $request->file('images', []);

        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $index => $image) {
            if (!$image) {
                continue;
            }

            if (!$image->isValid()) {
                $error = $image->getError();
                $message = $image->getErrorMessage();

                throw \Illuminate\Validation\ValidationException::withMessages([
                    "images.$index" =>
                        'Image upload failed. ' . $message .
                        ($error === UPLOAD_ERR_INI_SIZE
                            ? ' Increase PHP upload_max_filesize and post_max_size.'
                            : ''),
                ]);
            }

            $path = $image->store('product-images', 'public');

            if (!$path || !Storage::disk('public')->exists($path)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "images.$index" =>
                        'The additional product image could not be saved. Please try again.',
                ]);
            }

            $product->images()->create([
                'path' => $path,
                'sort_order' => (int) $index,
            ]);
        }
    }

    /** Log PHP-level upload failures before Laravel's generic `uploaded` message hides the cause. */
    private function rejectPhpUploadErrors(Request $request): void
    {
        $inspect = function ($files, string $field = '') use (&$inspect, $request): void {
            foreach ((array) $files as $key => $file) {
                $name = $field === '' ? (string) $key : $field . '.' . $key;

                if (is_array($file)) {
                    $inspect($file, $name);
                    continue;
                }

                if (! $file instanceof SymfonyUploadedFile) {
                    continue;
                }

                $error = $file->getError();
                if ($error === UPLOAD_ERR_OK || $error === UPLOAD_ERR_NO_FILE) {
                    continue;
                }

                $messages = [
                    UPLOAD_ERR_INI_SIZE => 'The file exceeds the server per-file upload limit (' . ini_get('upload_max_filesize') . ').',
                    UPLOAD_ERR_FORM_SIZE => 'The file exceeds the upload limit for this form.',
                    UPLOAD_ERR_PARTIAL => 'The file upload was interrupted. Please retry the upload.',
                    UPLOAD_ERR_NO_TMP_DIR => 'The server could not receive the file. Please contact support.',
                    UPLOAD_ERR_CANT_WRITE => 'The server could not write the uploaded file. Please contact support.',
                    UPLOAD_ERR_EXTENSION => 'The server blocked this file upload. Please contact support.',
                ];
                $message = $messages[$error] ?? 'The server could not receive this file. Please retry the upload.';
                $requestId = $this->productUploadRequestId($request);
                $tempDirectory = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();

                Log::warning('Seller product file rejected by PHP upload handling.', [
                    'request_id' => $requestId,
                    'field' => $name,
                    'php_upload_error' => $error,
                    'php_version' => PHP_VERSION,
                    'php_sapi' => PHP_SAPI,
                    'upload_max_filesize' => ini_get('upload_max_filesize'),
                    'post_max_size' => ini_get('post_max_size'),
                    'file_uploads' => ini_get('file_uploads'),
                    'upload_tmp_dir_configured' => (bool) ini_get('upload_tmp_dir'),
                    'upload_tmp_dir_writable' => is_dir($tempDirectory) && is_writable($tempDirectory),
                ]);

                throw ValidationException::withMessages([$name => $message]);
            }
        };

        $inspect($request->allFiles());
    }

    private function productUploadRequestId(Request $request): string
    {
        $requestId = $request->attributes->get('product_upload_request_id');
        if (! is_string($requestId) || ! Str::isUuid($requestId)) {
            $requestId = (string) Str::uuid();
            $request->attributes->set('product_upload_request_id', $requestId);
        }

        return $requestId;
    }

    /** Store additional product videos without replacing the legacy primary video. */
    private function storeAdditionalVideos(Request $request, Product $product): void
    {
        $files = $request->file('videos', []);
        if (! is_array($files)) {
            $files = [$files];
        }

        $files = array_values(array_filter($files));
        if ($product->videos()->count() + count($files) > 8) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'videos' => 'A product can have up to 8 additional videos.',
            ]);
        }

        foreach ($files as $index => $video) {
            if (! $video) {
                continue;
            }

            if (! $video->isValid()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "videos.$index" => 'Video upload failed. Please try a smaller file.',
                ]);
            }

            $path = $video->store('product-videos', 'public');
            if (! $path || ! Storage::disk('public')->exists($path)) {
                Log::error('Additional seller product video storage verification failed.', [
                    'request_id' => $this->productUploadRequestId($request),
                    'product_id' => $product->id,
                    'field' => "videos.$index",
                    'path_returned' => (bool) $path,
                ]);

                throw \Illuminate\Validation\ValidationException::withMessages([
                    "videos.$index" => 'The product video could not be saved. Please try again.',
                ]);
            }

            $product->videos()->create([
                'path' => $path,
                'mime_type' => $video->getMimeType(),
                'sort_order' => (int) ($product->videos()->max('sort_order') ?? -1) + 1,
            ]);
        }
    }

    /** Remove only records belonging to this seller-owned product. */
    private function removeAdditionalVideos(Request $request, Product $product): void
    {
        $ids = array_map('intval', $request->input('remove_video_ids', []));
        if ($ids === []) {
            return;
        }

        $videos = $product->videos()->whereIn('id', $ids)->get();
        if ($videos->count() !== count(array_unique($ids))) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'remove_video_ids' => 'One or more selected videos do not belong to this product.',
            ]);
        }

        $paths = $videos->pluck('path')->all();
        $product->videos()->whereIn('id', $ids)->delete();
        Storage::disk('public')->delete($paths);
    }
}
