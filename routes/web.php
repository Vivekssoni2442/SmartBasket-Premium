<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AiHubController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\VirtualTryOnController;
use App\Http\Controllers\CustomerSettingsController;
use App\Http\Controllers\SellerPaymentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AICameraAssistantController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Mail\FailedLoginAlert;


/*
|--------------------------------------------------------------------------
| SMART BASKET PREMIUM ROUTES
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('splash');
});


/*
|--------------------------------------------------------------------------
| CUSTOMER AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {

    if (Auth::check()) {
        return redirect('/products');
    }

    return view('auth.login');

})->name('login');


Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::user();

        if (
            $user->securitySetting &&
            $user->securitySetting->security_enabled
        ) {

            session([
                'pin_user_id' => $user->id
            ]);

            Auth::logout();

            return redirect('/security/verify-page');
        }

        return redirect('/products')
            ->with(
                'success',
                'Welcome to SMART BASKET 🎉'
            );
    }

    $user = User::where(
        'email',
        $request->email
    )->first();

    if ($user) {

        Mail::to($user->email)
            ->send(
                new FailedLoginAlert()
            );
    }

    return back()->with(
        'error',
        'Wrong password. Security email sent.'
    );

})->name('login.submit');


Route::get('/register', function () {
    return view('auth.register');
})->name('register');


Route::post('/register', function (Request $request) {

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make(
            $request->password
        ),
    ]);

    return redirect('/login')
        ->with(
            'success',
            'Registration successful. Please login.'
        );

})->name('register.submit');


Route::post('/send-otp', [
    OtpController::class,
    'sendOtp'
])->name('send.otp');


Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');


Route::get('/success', function () {
    return view('auth.success');
});


/*
|--------------------------------------------------------------------------
| SELLER AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/seller-login', [
    SellerController::class,
    'showLogin'
])->name('seller.login');


Route::post('/seller-login', [
    SellerController::class,
    'login'
])->name('seller.login.submit');


Route::get('/seller-register', [
    SellerController::class,
    'showRegistration'
])->name('seller.register');


Route::post('/seller-register', [
    SellerController::class,
    'register'
])->name('seller.register.submit');


/*
|--------------------------------------------------------------------------
| SELLER DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/seller-dashboard', [
    SellerController::class,
    'dashboard'
])
    ->name('seller.dashboard')
    ->middleware('seller.auth');


/*
|--------------------------------------------------------------------------
| SELLER PRODUCTS
|--------------------------------------------------------------------------
*/

Route::get('/seller-my-products', [
    SellerController::class,
    'myProducts'
])
    ->name('seller.products.index')
    ->middleware('seller.auth');


Route::get('/seller-product-add', [
    SellerController::class,
    'create'
])
    ->name('seller.product.add')
    ->middleware('seller.auth');


Route::post('/seller-product-store', [
    SellerController::class,
    'store'
])
    ->name('seller.product.store')
    ->middleware('seller.auth');


Route::get('/seller-product-edit/{id}', [
    SellerController::class,
    'edit'
])
    ->name('seller.product.edit')
    ->middleware('seller.auth');


Route::post('/seller-product-update/{id}', [
    SellerController::class,
    'update'
])
    ->name('seller.product.update')
    ->middleware('seller.auth');


Route::post('/seller-product-delete/{id}', [
    SellerController::class,
    'destroy'
])
    ->name('seller.product.delete')
    ->middleware('seller.auth');


/*
|--------------------------------------------------------------------------
| SELLER PROFILE
|--------------------------------------------------------------------------
*/

Route::get('/seller-profile', [
    SellerController::class,
    'profile'
])
    ->name('seller.profile')
    ->middleware('seller.auth');


Route::put('/seller-profile', [
    SellerController::class,
    'updateProfile'
])
    ->name('seller.profile.update')
    ->middleware('seller.auth');


Route::post('/seller-profile/payment-qr', [
    SellerController::class,
    'updatePaymentQr'
])
    ->name('seller.payment-qr.update')
    ->middleware('seller.auth');


Route::delete('/seller-profile/payment-qr', [
    SellerController::class,
    'deletePaymentQr'
])
    ->name('seller.payment-qr.delete')
    ->middleware('seller.auth');


/*
|--------------------------------------------------------------------------
| SELLER SETTINGS
|--------------------------------------------------------------------------
*/

Route::get('/seller-settings', [
    SellerController::class,
    'settings'
])
    ->name('seller.settings')
    ->middleware('seller.auth');


Route::put('/seller-settings', [
    SellerController::class,
    'updateSettings'
])
    ->name('seller.settings.update')
    ->middleware('seller.auth');


/*
|--------------------------------------------------------------------------
| SELLER LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/seller-logout', function (Request $request) {

    session()->forget([
        'seller_login',
        'seller_email',
        'seller_id'
    ]);

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/seller-login')
        ->with(
            'success',
            'Seller logout successfully'
        );

})->name('seller.logout');


/*
|--------------------------------------------------------------------------
| SELLER ORDERS
|--------------------------------------------------------------------------
*/

Route::get('/seller/orders', [
    SellerOrderController::class,
    'index'
])
    ->name('seller.orders.index')
    ->middleware('seller.auth');


Route::get('/seller/order-details/{order}', [
    SellerOrderController::class,
    'show'
])
    ->name('seller.orders.show')
    ->middleware('seller.auth');


Route::post('/seller/orders/{order}/status', [
    SellerController::class,
    'updateOrderStatus'
])
    ->name('seller.orders.update-status')
    ->middleware('seller.auth');


Route::post('/seller/orders/{order}/delivery', [
    SellerOrderController::class,
    'storeDelivery'
])
    ->name('seller.orders.delivery.store')
    ->middleware('seller.auth');


Route::put('/seller/orders/{order}/delivery', [
    SellerOrderController::class,
    'updateDelivery'
])
    ->name('seller.orders.delivery.update')
    ->middleware('seller.auth');


Route::delete('/seller/orders/{order}/delivery', [
    SellerOrderController::class,
    'destroyDelivery'
])
    ->name('seller.orders.delivery.destroy')
    ->middleware('seller.auth');


Route::post('/assign-delivery/{order}', [
    DeliveryController::class,
    'assign'
])
    ->name('delivery.assign')
    ->middleware('seller.auth');


/*
|--------------------------------------------------------------------------
| SELLER PAYMENTS
|--------------------------------------------------------------------------
*/

Route::middleware('seller.auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PAYMENT LIST
    |--------------------------------------------------------------------------
    */

    Route::get('/seller/payments', [
        SellerPaymentController::class,
        'index'
    ])->name('seller.payments.index');


    /*
    |--------------------------------------------------------------------------
    | PAYMENT DETAILS
    |--------------------------------------------------------------------------
    */

    Route::get('/seller/payments/{order}', [
        SellerPaymentController::class,
        'show'
    ])->name('seller.payments.show');


    /*
    |--------------------------------------------------------------------------
    | NEW PREMIUM BRANDED RECEIPT
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/seller/payments/{order}/premium-receipt',
        [
            SellerPaymentController::class,
            'premiumReceipt'
        ]
    )->name(
        'seller.payments.premium-receipt'
    );


    /*
    |--------------------------------------------------------------------------
    | OLD RECEIPT
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/seller/payments/{order}/receipt',
        [
            SellerPaymentController::class,
            'downloadReceipt'
        ]
    )->name(
        'seller.payments.receipt'
    );

});


/*
|--------------------------------------------------------------------------
| OTP
|--------------------------------------------------------------------------
*/

Route::get('/verify-otp', function () {
    return view('auth.verify-otp');
})->name('verify.otp');


Route::post('/verify-otp', function (Request $request) {

    $request->validate([
        'otp' => 'required|digits:6'
    ]);

    if (
        $request->otp ==
        session('reset_otp')
    ) {

        return redirect('/reset-password')
            ->with(
                'success',
                'OTP verified successfully'
            );
    }

    return back()->with(
        'error',
        'Invalid OTP'
    );

})->name('verify.otp.submit');


/*
|--------------------------------------------------------------------------
| PASSWORD RESET
|--------------------------------------------------------------------------
*/

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset.password');


Route::post('/reset-password', function (Request $request) {

    $request->validate([
        'password' =>
            'required|min:8|confirmed'
    ]);

    return redirect()
        ->route('password.success');

})->name('reset.password.submit');


Route::get('/password-success', function () {
    return view('auth.password-success');
})->name('password.success');


/*
|--------------------------------------------------------------------------
| PRODUCTS
|--------------------------------------------------------------------------
*/

Route::get('/products', [
    ProductController::class,
    'index'
])->name('products.index');


Route::get('/product/{product}', [
    ProductController::class,
    'show'
])->name('product.show');


Route::get('/products/{product}', [
    ProductController::class,
    'show'
])->name('products.show');


/*
|--------------------------------------------------------------------------
| AI HUB
|--------------------------------------------------------------------------
*/

Route::get('/ai-hub', [
    AiHubController::class,
    'index'
])->name('ai-hub');


Route::get('/overview', [
    AiHubController::class,
    'index'
])->name('overview');


Route::get('/ai-camera', [
    AiHubController::class,
    'camera'
])->name('ai-camera');


Route::post('/ai-camera', [
    AiHubController::class,
    'analyzeCamera'
])->name('ai-camera.analyze');


Route::get('/budget-shopping', [
    AiHubController::class,
    'budget'
])->name('budget-shopping');


Route::get('/gift-finder', [
    AiHubController::class,
    'giftFinder'
])->name('gift-finder');


Route::get('/trending-products', [
    AiHubController::class,
    'trending'
])->name('trending-products');


Route::get('/compare-products', [
    AiHubController::class,
    'compare'
])->name('compare-products');


Route::get('/wishlist', [
    AiHubController::class,
    'wishlist'
])->name('wishlist');


Route::delete('/wishlist/{wishlist}', [
    AiHubController::class,
    'removeWishlist'
])->name('wishlist.remove');


/*
|--------------------------------------------------------------------------
| AI CAMERA ASSISTANT
|--------------------------------------------------------------------------
*/

Route::get('/ai-camera-assistant', [
    AICameraAssistantController::class,
    'index'
])->name('ai-camera-assistant');


Route::post('/ai-camera-assistant', [
    AICameraAssistantController::class,
    'analyze'
])->name('ai-camera-assistant.analyze');


Route::get('/ai-camera-assistant/history', [
    AICameraAssistantController::class,
    'history'
])->name('ai-camera-assistant.history');


Route::delete(
    '/ai-camera-assistant/history/{history}',
    [
        AICameraAssistantController::class,
        'deleteHistory'
    ]
)->name(
    'ai-camera-assistant.history.delete'
);


Route::get(
    '/ai-camera-assistant/virtual-try-on',
    [
        AICameraAssistantController::class,
        'virtualTryOn'
    ]
)->name(
    'ai-camera-assistant.virtual-try-on'
);


Route::post(
    '/ai-camera-assistant/virtual-try-on',
    [
        AICameraAssistantController::class,
        'processVirtualTryOn'
    ]
)->name(
    'ai-camera-assistant.virtual-try-on.process'
);


Route::get(
    '/ai-camera-assistant/result/{file}',
    [
        AICameraAssistantController::class,
        'resultImage'
    ]
)->name(
    'ai-camera-assistant.result'
);


/*
|--------------------------------------------------------------------------
| VIRTUAL TRY ON
|--------------------------------------------------------------------------
*/

Route::post(
    '/products/{product}/virtual-try-on',
    [
        VirtualTryOnController::class,
        'generate'
    ]
)->name(
    'products.virtual-try-on.generate'
);


Route::get(
    '/products/{product}/virtual-try-on/result/{token}',
    [
        VirtualTryOnController::class,
        'result'
    ]
)
    ->where(
        'token',
        '[A-Za-z0-9]{40}'
    )
    ->name(
        'products.virtual-try-on.result'
    );


/*
|--------------------------------------------------------------------------
| WISHLIST ADD
|--------------------------------------------------------------------------
*/

Route::post(
    '/wishlist/add/{product}',
    function ($productId) {

        if (!Auth::check()) {
            return redirect('/login');
        }

        $product =
            Product::findOrFail($productId);

        \App\Models\Wishlist::firstOrCreate([
            'user_id' =>
                Auth::id(),

            'product_id' =>
                $product->id,
        ]);

        return back()
            ->with(
                'success',
                'Added to wishlist.'
            );
    }
)->name('wishlist.add');


/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/

Route::get('/checkout', function () {

    $cartItems = [];

    $total = 0.0;

    if (Auth::check()) {

        $cartItems =
            \App\Models\Cart::with(
                'product.seller'
            )
            ->where(
                'user_id',
                Auth::id()
            )
            ->get();

        foreach ($cartItems as $item) {

            $product =
                $item->product;

            if ($product) {

                $total +=
                    (float) $product->price
                    *
                    max(
                        1,
                        (int) $item->quantity
                    );
            }
        }
    }

    $buyProductId =
        session('buy_product');

    if ($buyProductId) {

        $product =
            \App\Models\Product::with(
                'seller'
            )->find($buyProductId);

        if ($product) {

            $cartItems = [[

                'product' =>
                    $product,

                'quantity' =>
                    1,

            ]];

            $total =
                (float) $product->price;
        }
    }

    $checkoutSellers =
        collect($cartItems)
            ->map(
                fn ($item) =>
                    $item['product']
                    ?? $item->product
                    ?? null
            )
            ->filter()
            ->map(
                fn ($product) =>
                    $product->seller
            )
            ->filter()
            ->unique('id');

    $onlinePaymentAvailable =
        $checkoutSellers->isNotEmpty()
        &&
        $checkoutSellers->every(
            fn ($seller) =>
                (bool)
                $seller->online_payments_enabled
        );

    return view(
        'checkout',
        compact(
            'cartItems',
            'total',
            'onlinePaymentAvailable'
        )
    );

});


/*
|--------------------------------------------------------------------------
| ORDERS
|--------------------------------------------------------------------------
*/

Route::post('/place-order', [
    OrderController::class,
    'placeOrder'
])->name('place.order');


Route::get('/order-success', function () {
    return view('order-success');
});


Route::get('/my-orders', [
    OrderController::class,
    'myOrders'
])->name('orders.index');


Route::get('/order-details/{order}', [
    OrderController::class,
    'show'
])->name('orders.show');


/*
|--------------------------------------------------------------------------
| CUSTOMER PAYMENT RECEIPT
|--------------------------------------------------------------------------
*/

Route::get(
    '/order-details/{order}/receipt',
    [
        OrderController::class,
        'downloadReceipt'
    ]
)->name('orders.receipt');


Route::post(
    '/order-details/{order}/cancel',
    [
        OrderController::class,
        'cancel'
    ]
)->name('orders.cancel');


/*
|--------------------------------------------------------------------------
| PAYMENTS
|--------------------------------------------------------------------------
*/

Route::get('/payments/{payment}', [
    PaymentController::class,
    'show'
])->name('payments.show');


Route::post(
    '/payments/{payment}/verify',
    [
        PaymentController::class,
        'verify'
    ]
)->name('payments.verify');


Route::post(
    '/payments/{payment}/cancel',
    [
        PaymentController::class,
        'cancel'
    ]
)->name('payments.cancel');


Route::post(
    '/payments/razorpay/webhook',
    [
        PaymentController::class,
        'webhook'
    ]
)->name('payments.razorpay.webhook');


/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

Route::post(
    '/cart/add/{product}',
    [
        CartController::class,
        'add'
    ]
)->name('cart.add');


Route::post(
    '/cart/update/{product}',
    [
        CartController::class,
        'update'
    ]
)->name('cart.update');


Route::delete(
    '/cart/remove/{id}',
    [
        CartController::class,
        'remove'
    ]
)->name('cart.remove');


Route::get('/cart', [
    CartController::class,
    'index'
])->name('cart.index');


/*
|--------------------------------------------------------------------------
| BUY NOW
|--------------------------------------------------------------------------
*/

Route::get('/buy-now/{id}', function ($id) {

    $product =
        Product::findOrFail($id);

    session([
        'buy_product' =>
            $product->id
    ]);

    return redirect('/checkout');

});


Route::post('/confirm-buy', function () {

    session()->forget(
        'buy_product'
    );

    return redirect('/products')
        ->with(
            'success',
            'Order Placed Successfully 🎉'
        );

});


/*
|--------------------------------------------------------------------------
| CUSTOMER PROFILE
|--------------------------------------------------------------------------
*/

Route::get('/profile', [
    ProfileController::class,
    'index'
])->name('profile');


Route::post('/profile/update', [
    ProfileController::class,
    'update'
])->name('profile.update');


Route::post('/logout', [
    ProfileController::class,
    'logout'
])->name('logout');


/*
|--------------------------------------------------------------------------
| CUSTOMER SETTINGS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/settings', [
        CustomerSettingsController::class,
        'edit'
    ])->name('settings');

    Route::put('/settings', [
        CustomerSettingsController::class,
        'update'
    ])->name('settings.update');

});


/*
|--------------------------------------------------------------------------
| SECURITY
|--------------------------------------------------------------------------
*/

Route::post(
    '/security/save-pin',
    [
        SecurityController::class,
        'savePin'
    ]
)->name('security.save');


Route::post(
    '/security/verify',
    [
        SecurityController::class,
        'verifyPin'
    ]
)->name('security.verify');


Route::post(
    '/security/disable',
    [
        SecurityController::class,
        'disable'
    ]
)->name('security.disable');


Route::get(
    '/security/verify-page',
    function () {

        return view(
            'security.verify'
        );

    }
)->name('security.verify.page');


/*
|--------------------------------------------------------------------------
| TEST ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/test-profile', function () {
    return "TEST PROFILE OK";
});


Route::get('/abc-test', function () {
    return "ABC TEST WORKING";
});


Route::get('/profile-test', function () {
    return "PROFILE TEST OK";
});


/*
|--------------------------------------------------------------------------
| CREATE QR FILE
|--------------------------------------------------------------------------
*/

Route::get('/create-qr-file', function () {

    $folder =
        public_path('images');

    if (!File::exists($folder)) {

        File::makeDirectory(
            $folder,
            0755,
            true
        );
    }

    $image =
        file_get_contents(
            'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=upi://pay?pa=smartbasket@upi&pn=SMART%20BASKET'
        );

    file_put_contents(
        public_path(
            'images/my-qr.png'
        ),
        $image
    );

    return "my-qr.png created successfully";

});


/*
|--------------------------------------------------------------------------
| AI CHAT
|--------------------------------------------------------------------------
*/

Route::post('/ai-chat', [
    AiHubController::class,
    'aiChat'
])->name('ai.chat');


Route::get('/ai-chat', function () {

    return view(
        'ai-hub.chat'
    );

});