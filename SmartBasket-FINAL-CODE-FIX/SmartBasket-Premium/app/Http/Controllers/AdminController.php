<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * AdminController
 *
 * Handles:
 * - Admin authentication
 * - MFA flow
 * - Dashboard
 * - Customer management
 * - Seller management
 * - Product management
 * - Categories
 * - Orders
 * - Returns
 * - Payments
 * - Revenue
 * - Marketing
 * - Analytics
 * - Audit logs
 * - Admin settings
 */
class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN AUTHENTICATION
    |--------------------------------------------------------------------------
    */

    /**
     * Show admin login page.
     */
    public function showLogin()
    {
        if (session('admin_authenticated')) {
            return redirect('/admin/dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle admin login.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::where('email', $validated['email'])->first();

        if (!$admin) {
            Log::warning('Admin login attempt with non-existent email', [
                'email' => $validated['email'],
                'ip' => $request->ip(),
            ]);

            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Invalid credentials.');
        }

        /*
        |--------------------------------------------------------------------------
        | LOCKED ACCOUNT
        |--------------------------------------------------------------------------
        */

        if ($admin->isLocked()) {
            AdminAuditLog::log(
                $admin,
                'login_attempt',
                null,
                null,
                'Login attempt on locked account',
                status: 'failure'
            );

            return back()
                ->withInput($request->only('email'))
                ->with(
                    'error',
                    'Account locked due to too many failed login attempts. Try again in 15 minutes.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | INACTIVE ACCOUNT
        |--------------------------------------------------------------------------
        */

        if (!$admin->isActive()) {
            AdminAuditLog::log(
                $admin,
                'login_attempt',
                null,
                null,
                'Login attempt on inactive account',
                status: 'failure'
            );

            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Admin account is inactive.');
        }

        /*
        |--------------------------------------------------------------------------
        | PASSWORD
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($validated['password'], $admin->password)) {
            $admin->recordFailedAttempt();

            AdminAuditLog::log(
                $admin,
                'login_attempt',
                null,
                null,
                'Failed login: invalid password',
                status: 'failure'
            );

            $message = 'Invalid credentials.';

            if ($admin->login_attempts >= 4) {
                $remaining = max(0, 5 - $admin->login_attempts);

                $message .= " ({$remaining} attempt(s) remaining)";
            }

            return back()
                ->withInput($request->only('email'))
                ->with('error', $message);
        }

        /*
        |--------------------------------------------------------------------------
        | MFA
        |--------------------------------------------------------------------------
        */

        if ($admin->mfa_enabled) {
            session([
                'admin_mfa_pending' => true,
                'admin_id_temp' => $admin->id,
                'admin_email_temp' => $admin->email,
            ]);

            return redirect('/admin/mfa-verify');
        }

        /*
        |--------------------------------------------------------------------------
        | COMPLETE LOGIN
        |--------------------------------------------------------------------------
        */

        $this->completeAdminLogin($admin, $request);

        return redirect('/admin/dashboard')
            ->with(
                'success',
                'Welcome to SmartBasket Admin Center 👑'
            );
    }

    /**
     * Show MFA verification page.
     */
    public function showMfaVerify()
    {
        if (!session('admin_mfa_pending')) {
            return redirect('/admin/login');
        }

        return view('admin.mfa-verify');
    }

    /**
     * Verify MFA code.
     */
    public function verifyMfa(Request $request)
    {
        if (!session('admin_mfa_pending')) {
            return redirect('/admin/login');
        }

        $validated = $request->validate([
            'code' => ['required', 'string', 'size:6'],
            'recovery_code' => ['nullable', 'string'],
        ]);

        $adminId = session('admin_id_temp');

        $admin = Admin::find($adminId);

        if (!$admin) {
            session()->forget([
                'admin_mfa_pending',
                'admin_id_temp',
                'admin_email_temp',
            ]);

            return redirect('/admin/login')
                ->with(
                    'error',
                    'Session expired. Please login again.'
                );
        }

        $mfaValid = false;

        if (!empty($validated['code'])) {
            $mfaValid = $this->verifyTotpCode(
                $admin,
                $validated['code']
            );
        }

        if (
            !$mfaValid &&
            !empty($validated['recovery_code'])
        ) {
            $mfaValid = $admin->useRecoveryCode(
                $validated['recovery_code']
            );
        }

        if (!$mfaValid) {
            return back()
                ->with(
                    'error',
                    'Invalid MFA code or recovery code.'
                );
        }

        $this->completeAdminLogin(
            $admin,
            $request
        );

        session()->forget([
            'admin_mfa_pending',
            'admin_id_temp',
            'admin_email_temp',
        ]);

        return redirect('/admin/dashboard')
            ->with(
                'success',
                'Welcome to SmartBasket Admin Center 👑'
            );
    }

    /**
     * Complete admin login.
     */
    private function completeAdminLogin(
        Admin $admin,
        Request $request
    ): void {
        $admin->clearLoginAttempts();

        /*
        |--------------------------------------------------------------------------
        | Prevent session fixation
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        session([
            'admin_authenticated' => true,
            'admin_id' => $admin->id,
            'admin_email' => $admin->email,
            'admin_name' => $admin->name,
            'admin_role' => $admin->role,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit
        |--------------------------------------------------------------------------
        */

        AdminAuditLog::log(
            $admin,
            'login',
            null,
            null,
            'Admin logged in successfully'
        );

        Log::info(
            'Admin login successful',
            [
                'admin_id' => $admin->id,
                'email' => $admin->email,
                'ip' => $request->ip(),
            ]
        );
    }

    /**
     * Verify TOTP code.
     *
     * Placeholder until a proper TOTP package is configured.
     */
    private function verifyTotpCode(
        Admin $admin,
        string $code
    ): bool {
        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        |
        | Do not enable fake TOTP verification.
        | Configure a proper TOTP package before implementing this.
        |
        */

        return false;
    }

    /**
     * Admin logout.
     */
    public function logout(Request $request)
    {
        $adminId = session('admin_id');

        if ($adminId) {
            $admin = Admin::find($adminId);

            if ($admin) {
                AdminAuditLog::log(
                    $admin,
                    'logout',
                    null,
                    null,
                    'Admin logged out'
                );
            }
        }

        session()->forget([
            'admin_authenticated',
            'admin_id',
            'admin_email',
            'admin_name',
            'admin_role',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    /**
     * Show admin dashboard.
     */
    public function dashboard()
    {
        $sellerProfile = \App\Models\SellerProfile::class;

        /*
        |--------------------------------------------------------------------------
        | Pending seller statuses
        |--------------------------------------------------------------------------
        */

        $pendingStatuses = array_values(
            array_unique(
                array_filter([
                    defined(
                        $sellerProfile . '::STATUS_PENDING_ADMIN_REVIEW'
                    )
                        ? constant(
                            $sellerProfile . '::STATUS_PENDING_ADMIN_REVIEW'
                        )
                        : null,

                    defined(
                        $sellerProfile . '::STATUS_SUBMITTED'
                    )
                        ? constant(
                            $sellerProfile . '::STATUS_SUBMITTED'
                        )
                        : null,

                    defined(
                        $sellerProfile . '::STATUS_UNDER_REVIEW'
                    )
                        ? constant(
                            $sellerProfile . '::STATUS_UNDER_REVIEW'
                        )
                        : null,

                    defined(
                        $sellerProfile . '::STATUS_PENDING_EMAIL'
                    )
                        ? constant(
                            $sellerProfile . '::STATUS_PENDING_EMAIL'
                        )
                        : null,

                    defined(
                        $sellerProfile . '::STATUS_EMAIL_VERIFICATION'
                    )
                        ? constant(
                            $sellerProfile . '::STATUS_EMAIL_VERIFICATION'
                        )
                        : null,
                ])
            )
        );

        $approvedStatus = defined(
            $sellerProfile . '::STATUS_APPROVED'
        )
            ? constant(
                $sellerProfile . '::STATUS_APPROVED'
            )
            : 'approved';

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $stats = [
            'total_customers' =>
                \App\Models\User::count(),

            'total_sellers' =>
                $sellerProfile::count(),

            'pending_sellers' =>
                empty($pendingStatuses)
                    ? 0
                    : $sellerProfile::whereIn(
                        'verification_status',
                        $pendingStatuses
                    )->count(),

            'approved_sellers' =>
                $sellerProfile::where(
                    'verification_status',
                    $approvedStatus
                )->count(),

            'total_products' =>
                \App\Models\Product::count(),

            'total_orders' =>
                \App\Models\Order::count(),

            'total_revenue' =>
                \App\Models\PaymentTransaction::whereIn(
                    'status',
                    [
                        'paid',
                        'verified',
                    ]
                )->sum('amount_paise') / 100,

            'pending_payments' =>
                \App\Models\PaymentTransaction::whereIn(
                    'status',
                    [
                        'pending',
                        'processing',
                    ]
                )->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Recent Orders
        |--------------------------------------------------------------------------
        */

        $recentOrders =
            \App\Models\Order::with('user')
                ->latest()
                ->take(6)
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Customers
        |--------------------------------------------------------------------------
        */

        $recentCustomers =
            \App\Models\User::latest()
                ->take(5)
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Seller Applications
        |--------------------------------------------------------------------------
        */

        $recentApplications =
            $sellerProfile::latest(
                'verification_submitted_at'
            )
                ->take(5)
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Order Summary
        |--------------------------------------------------------------------------
        */

        $orderStatusSummary =
            \App\Models\Order::selectRaw(
                "COALESCE(order_status, status, 'pending') as label, COUNT(*) as total"
            )
                ->groupBy('label')
                ->orderByDesc('total')
                ->get();

        return view(
            'admin.dashboard',
            compact(
                'stats',
                'recentOrders',
                'recentCustomers',
                'recentApplications',
                'orderStatusSummary'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * List customers.
     */
    public function customerIndex(Request $request)
    {
        $query = \App\Models\User::query();

        if ($request->filled('search')) {
            $search = trim(
                $request->input('search')
            );

            $query->where(
                function ($q) use ($search) {
                    $q->where(
                        'seller_name',
                        'like',
                        '%' . $search . '%'
                    )
                        ->orWhere(
                            'email',
                            'like',
                            '%' . $search . '%'
                        );
                }
            );
        }

        $customers =
            $query
                ->withCount('orders')
                ->withSum(
                    [
                        'orders as total_spending' =>
                            function ($orders) {
                                $orders->whereIn(
                                    'payment_status',
                                    [
                                        'paid',
                                        'success',
                                        'verified',
                                    ]
                                );
                            },
                    ],
                    'amount'
                )
                ->latest()
                ->paginate(20)
                ->withQueryString();

        return view(
            'admin.customers.index',
            compact('customers')
        );
    }

    /**
     * Show customer details.
     */
    public function customerShow(
        \App\Models\User $user
    ) {
        $user->load([
            'orders' => function ($orders) {
                $orders
                    ->latest()
                    ->limit(10);
            },
            'wishlists',
            'carts',
        ]);

        return view(
            'admin.customers.show',
            compact('user')
        );
    }

    /**
     * Customer activity.
     */
    public function customerActivity(
        Request $request
    ) {
        $activities =
            \App\Models\Order::with('user')
                ->latest()
                ->paginate(25)
                ->withQueryString();

        return view(
            'admin.customers.activity',
            compact('activities')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SELLER MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * List all sellers.
     *
     * IMPORTANT:
     * No products relationship is loaded here.
     *
     * This avoids the previous:
     *
     * BadMethodCallException:
     * Call to undefined method SellerProfile::products()
     *
     * and:
     *
     * no such column: seller_profiles.seller_id
     */
    public function sellerIndex(
        Request $request
    ) {
        $query =
            \App\Models\SellerProfile::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim(
                $request->input('search')
            );

            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                        ->orWhere(
                            'email',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'business_name',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'phone',
                            'like',
                            '%' . $search . '%'
                        );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where(
                'verification_status',
                $request->input('status')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Seller List
        |--------------------------------------------------------------------------
        |
        | User relationship is safe because SellerProfile::user()
        | is already defined.
        |
        */

        $sellers =
            $query
                ->with('user')
                ->latest('created_at')
                ->paginate(20)
                ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Seller Statistics
        |--------------------------------------------------------------------------
        */

        $sellerModel =
            \App\Models\SellerProfile::class;

        $sellerStats = [
            'total' =>
                $sellerModel::count(),

            'approved' =>
                $sellerModel::where(
                    'verification_status',
                    $sellerModel::STATUS_APPROVED
                )->count(),

            'pending' =>
                $sellerModel::whereIn(
                    'verification_status',
                    [
                        $sellerModel::STATUS_PENDING_ADMIN_REVIEW,
                        $sellerModel::STATUS_UNDER_REVIEW,
                    ]
                )->count(),

            'rejected' =>
                $sellerModel::where(
                    'verification_status',
                    $sellerModel::STATUS_REJECTED
                )->count(),

            'suspended' =>
                $sellerModel::where(
                    'verification_status',
                    $sellerModel::STATUS_SUSPENDED
                )->count(),
        ];

        return view(
            'admin.sellers.index',
            compact(
                'sellers',
                'sellerStats'
            )
        );
    }

    /**
     * Show seller details.
     *
     * IMPORTANT:
     * Products relation is intentionally not loaded.
     * The current database mapping is not confirmed.
     */
    public function sellerShow(
        \App\Models\SellerProfile $seller
    ) {
        try {
            /*
            |--------------------------------------------------------------------------
            | User relationship
            |--------------------------------------------------------------------------
            */

            $seller->load('user');
        } catch (\Throwable $e) {

            Log::warning(
                'Unable to load seller user relationship.',
                [
                    'seller_id' =>
                        $seller->id ?? null,

                    'error' =>
                        $e->getMessage(),
                ]
            );
        }

        return view(
            'admin.sellers.show',
            compact('seller')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUCT MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * List products.
     */
    public function productIndex(
        Request $request
    ) {
        $query =
            \App\Models\Product::query();

        if ($request->filled('search')) {
            $search = trim(
                $request->input('search')
            );

            $query->where(
                'name',
                'like',
                '%' . $search . '%'
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->input('status')
            );
        }

        $products =
            $query
                ->latest()
                ->paginate(20)
                ->withQueryString();

        return view(
            'admin.products.index',
            compact('products')
        );
    }

    /**
     * Show product details.
     */
    public function productShow(
        \App\Models\Product $product
    ) {
        try {
            $product->load('images');
        } catch (\Throwable $e) {

            Log::warning(
                'Unable to load product images.',
                [
                    'product_id' =>
                        $product->id ?? null,

                    'error' =>
                        $e->getMessage(),
                ]
            );
        }

        return view(
            'admin.products.show',
            compact('product')
        );
    }

    /**
     * Product edit page.
     */
    public function productEdit(
        \App\Models\Product $product
    ) {
        return view(
            'admin.products.edit',
            compact('product')
        );
    }

    /**
     * Update product.
     */
    public function productUpdate(
        Request $request,
        \App\Models\Product $product
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
            ],

            'stock' => [
                'required',
                'integer',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        $product->update(
            $validated
        );

        $admin =
            Admin::find(
                session('admin_id')
            );

        if ($admin) {
            AdminAuditLog::log(
                $admin,
                'product_update',
                'Product',
                $product->id,
                "Updated product: {$product->name}"
            );
        }

        return redirect()
            ->route(
                'admin.products.show',
                $product
            )
            ->with(
                'success',
                'Product updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CATEGORY MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * List categories.
     */
    public function categoryIndex(
        Request $request
    ) {
        $categories =
            \App\Models\Product::query()
                ->select('category')
                ->whereNotNull('category')
                ->where(
                    'category',
                    '!=',
                    ''
                )
                ->distinct()
                ->orderBy('category')
                ->pluck('category');

        return view(
            'admin.categories.index',
            compact('categories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * List orders.
     */
    public function orderIndex(
        Request $request
    ) {
        $query =
            \App\Models\Order::query();

        if ($request->filled('search')) {
            $search = trim(
                $request->input('search')
            );

            $query->where(
                'id',
                'like',
                '%' . $search . '%'
            );
        }

        if ($request->filled('payment_status')) {
            $query->where(
                'payment_status',
                $request->input('payment_status')
            );
        }

        if ($request->filled('order_status')) {
            $query->where(
                'order_status',
                $request->input('order_status')
            );
        }

        $orders =
            $query
                ->with([
                    'user',
                    'seller',
                ])
                ->latest()
                ->paginate(20)
                ->withQueryString();

        return view(
            'admin.orders.index',
            compact('orders')
        );
    }

    /**
     * Show order.
     */
    public function orderShow(
        \App\Models\Order $order
    ) {
        $order->load(
            'user',
            'seller',
            'deliveryDetail'
        );

        return view(
            'admin.orders.show',
            compact('order')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RETURNS & REFUNDS
    |--------------------------------------------------------------------------
    */

    /**
     * List returns.
     */
    public function returnIndex(
        Request $request
    ) {
        $returns =
            \App\Models\Order::with('user')
                ->whereNotNull(
                    'cancellation_reason'
                )
                ->latest()
                ->paginate(20)
                ->withQueryString();

        return view(
            'admin.returns.index',
            compact('returns')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * List transactions.
     */
    public function transactionIndex(
        Request $request
    ) {
        $query =
            \App\Models\PaymentTransaction::query();

        if ($request->filled('search')) {
            $search = trim(
                $request->input('search')
            );

            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'gateway_order_id',
                        'like',
                        '%' . $search . '%'
                    )
                        ->orWhere(
                            'gateway_payment_id',
                            'like',
                            '%' . $search . '%'
                        );
                }
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->input('status')
            );
        }

        $transactions =
            $query
                ->with('user')
                ->latest()
                ->paginate(20)
                ->withQueryString();

        return view(
            'admin.transactions.index',
            compact('transactions')
        );
    }

    /**
     * Revenue page.
     */
    public function revenue(
        Request $request
    ) {
        $totalRevenue =
            \App\Models\PaymentTransaction::whereIn(
                'status',
                [
                    'paid',
                    'verified',
                ]
            )->sum('amount_paise') / 100;

        $pendingRevenue =
            \App\Models\PaymentTransaction::where(
                'status',
                'pending'
            )->sum('amount_paise') / 100;

        $failedRevenue =
            \App\Models\PaymentTransaction::where(
                'status',
                'failed'
            )->sum('amount_paise') / 100;

        $recentTransactions =
            \App\Models\PaymentTransaction::with('user')
                ->latest()
                ->take(10)
                ->get();

        $successfulPayments =
            \App\Models\PaymentTransaction::whereIn(
                'status',
                [
                    'paid',
                    'verified',
                ]
            )->count();

        return view(
            'admin.revenue.index',
            compact(
                'totalRevenue',
                'pendingRevenue',
                'failedRevenue',
                'recentTransactions',
                'successfulPayments'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MARKETING
    |--------------------------------------------------------------------------
    */

    /**
     * Coupons.
     */
    public function couponIndex()
    {
        return view(
            'admin.coupons.index'
        );
    }

    /**
     * Offers.
     */
    public function offerIndex()
    {
        return view(
            'admin.offers.index'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ANALYTICS
    |--------------------------------------------------------------------------
    */

    /**
     * Sales analytics.
     */
    public function analyticsSales()
    {
        $totalSales =
            \App\Models\PaymentTransaction::whereIn(
                'status',
                [
                    'paid',
                    'verified',
                ]
            )->sum('amount_paise') / 100;

        $orderCount =
            \App\Models\Order::count();

        $averageOrderValue =
            $orderCount > 0
                ? $totalSales / $orderCount
                : 0;

        $salesByStatus =
            \App\Models\Order::selectRaw(
                "COALESCE(order_status, status, 'pending') as label, COUNT(*) as count"
            )
                ->groupBy('label')
                ->get();

        $revenueByPeriod =
            \App\Models\PaymentTransaction::whereIn(
                'status',
                [
                    'paid',
                    'verified',
                ]
            )
                ->where(
                    'created_at',
                    '>=',
                    now()->subDays(6)
                )
                ->selectRaw(
                    'DATE(created_at) as day, SUM(amount_paise) / 100 as total'
                )
                ->groupBy('day')
                ->orderBy('day')
                ->get();

        return view(
            'admin.analytics.sales',
            compact(
                'totalSales',
                'orderCount',
                'averageOrderValue',
                'salesByStatus',
                'revenueByPeriod'
            )
        );
    }

    /**
     * Customer analytics.
     */
    public function analyticsCustomers()
    {
        $totalCustomers =
            \App\Models\User::count();

        $activeCustomers =
            \App\Models\User::has('orders')
                ->count();

        $newCustomers =
            \App\Models\User::where(
                'created_at',
                '>=',
                now()->subDays(30)
            )->count();

        $ordersPerCustomer =
            $totalCustomers
                ? \App\Models\Order::count()
                    / $totalCustomers
                : 0;

        $totalCustomerSpend =
            \App\Models\PaymentTransaction::whereIn(
                'status',
                [
                    'paid',
                    'verified',
                ]
            )->sum('amount_paise') / 100;

        return view(
            'admin.analytics.customers',
            compact(
                'totalCustomers',
                'activeCustomers',
                'newCustomers',
                'ordersPerCustomer',
                'totalCustomerSpend'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | AUDIT LOGS
    |--------------------------------------------------------------------------
    */

    /**
     * Audit logs.
     */
    public function auditLogIndex(
        Request $request
    ) {
        $query =
            AdminAuditLog::query();

        if ($request->filled('action')) {
            $query->where(
                'action',
                $request->input('action')
            );
        }

        if ($request->filled('date_from')) {
            $query->where(
                'created_at',
                '>=',
                $request->input('date_from')
            );
        }

        if ($request->filled('date_to')) {
            $query->where(
                'created_at',
                '<=',
                $request->input('date_to')
            );
        }

        $logs =
            $query
                ->with('admin')
                ->latest()
                ->paginate(50)
                ->withQueryString();

        return view(
            'admin.audit-logs.index',
            compact('logs')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN SETTINGS
    |--------------------------------------------------------------------------
    */

    /**
     * Admin settings.
     */
    public function settings()
    {
        $admin =
            Admin::find(
                session('admin_id')
            );

        return view(
            'admin.settings',
            compact('admin')
        );
    }
}