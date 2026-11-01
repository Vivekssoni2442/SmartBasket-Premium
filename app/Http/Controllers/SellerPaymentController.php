<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Notification;
use App\Models\PaymentAuditRecord;
use App\Models\Product;
use App\Models\SellerEarning;
use App\Models\SellerProfile;
use App\Models\PaymentTransaction;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SellerPaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PAYMENT LIST
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $seller = $this->currentSeller();

        $orders = $this->filteredPayments(
            $request,
            $seller->id
        )
            ->latest()
            ->get();

        $this->attachSellerItems(
            $orders,
            $seller->id
        );

        $successfulOrders = $orders->filter(
            fn (Order $order) =>
                $this->status($order) === 'Successful'
        );

        $summary = [
            'received' => $successfulOrders->sum(
                fn (Order $order) =>
                    $this->sellerOrderTotal(
                        $order,
                        $seller->id
                    )
            ),

            'successful' => $successfulOrders->count(),

            'pending' => $orders->filter(
                fn (Order $order) =>
                    $this->status($order) === 'Pending'
            )->count(),

            'failed' => $orders->filter(
                fn (Order $order) =>
                    $this->status($order) === 'Failed'
            )->count(),

            'refunded' => $orders->filter(
                fn (Order $order) =>
                    $this->status($order) === 'Refunded'
            )->count(),
        ];

        return view(
            'seller.payments.index',
            compact(
                'seller',
                'orders',
                'summary'
            )
        );
    }

    /** Seller-only UPI payments waiting for this seller's credit confirmation. */
    public function upiReviews()
    {
        $seller = $this->currentSeller();
        $transactions = PaymentTransaction::query()
            ->with('user')
            ->where('gateway', 'seller_upi')
            ->where('status', 'manual_review')
            ->latest()
            ->get()
            ->filter(function (PaymentTransaction $transaction) use ($seller) {
                $targets = collect($transaction->request_metadata['seller_payments'] ?? []);
                $target = $targets->first(fn ($row) => (int) ($row['seller_id'] ?? 0) === (int) $seller->id);
                if (! $target) {
                    return false;
                }
                $review = $transaction->request_metadata['seller_upi_reviews'][(string) $seller->id] ?? [];

                return ($review['status'] ?? 'pending') === 'pending';
            })
            ->values()
            ->map(function (PaymentTransaction $transaction) use ($seller) {
                $metadata = $transaction->request_metadata ?? [];
                $target = collect($metadata['seller_payments'] ?? [])->first(
                    fn ($row) => (int) ($row['seller_id'] ?? 0) === (int) $seller->id
                );

                return [
                    'transaction' => $transaction,
                    'target' => $target,
                    'reference' => $metadata['upi_references'][$seller->id] ?? 'Not submitted',
                    'orders' => Order::whereIn('id', $transaction->order_ids ?? [])
                        ->where('seller_id', $seller->id)
                        ->with('user')
                        ->get(),
                ];
            });

        return view('seller.payments.upi-reviews', compact('seller', 'transactions'));
    }

    /** Accept only the current seller's UPI credit and confirm only their order. */
    public function acceptSellerUpi(Request $request, PaymentTransaction $transaction)
    {
        $seller = $this->currentSeller();
        abort_unless($transaction->gateway === 'seller_upi', 404);

        $accepted = DB::transaction(function () use ($request, $seller, $transaction) {
            $locked = PaymentTransaction::whereKey($transaction->id)->lockForUpdate()->firstOrFail();
            if ($locked->gateway !== 'seller_upi' || $locked->status !== 'manual_review') {
                return false;
            }

            $metadata = $locked->request_metadata ?? [];
            $target = collect($metadata['seller_payments'] ?? [])->first(
                fn ($row) => (int) ($row['seller_id'] ?? 0) === (int) $seller->id
            );
            $reference = trim((string) ($metadata['upi_references'][$seller->id] ?? ''));
            abort_unless($target && $reference !== '', 403, 'This UPI payment does not belong to your seller account.');

            $reviews = $metadata['seller_upi_reviews'] ?? [];
            if (($reviews[(string) $seller->id]['status'] ?? 'pending') !== 'pending') {
                return false;
            }

            $orders = Order::whereIn('id', $locked->order_ids ?? [])
                ->where('seller_id', $seller->id)
                ->lockForUpdate()
                ->get();
            abort_unless($orders->isNotEmpty(), 422, 'No order for your seller account is linked to this payment.');

            $reviews[(string) $seller->id] = [
                'status' => 'paid',
                'reviewed_at' => now()->toIso8601String(),
                'seller_id' => (int) $seller->id,
                'order_ids' => $orders->pluck('id')->map(fn ($id) => (int) $id)->all(),
            ];
            $metadata['seller_upi_reviews'] = $reviews;
            $allAccepted = collect($metadata['seller_payments'] ?? [])->every(
                fn ($row) => ($reviews[(string) (int) $row['seller_id']]['status'] ?? 'pending') === 'paid'
            );

            foreach ($orders as $order) {
                $order->update(['status' => 'Confirmed', 'order_status' => 'Confirmed', 'payment_status' => 'Paid']);
                if ($order->user_id && $seller->preference('order_confirmation_notification', true)) {
                    Notification::create([
                        'user_id' => $order->user_id,
                        'role' => 'user',
                        'type' => 'order',
                        'title' => 'UPI payment verified',
                        'message' => 'Seller verified your UPI payment and order #' . $order->id . ' is confirmed.',
                        'data' => ['order_id' => $order->id, 'payment_transaction_id' => $locked->id],
                    ]);
                }
                SellerEarning::firstOrCreate(
                    ['seller_id' => $seller->id, 'order_id' => $order->id],
                    ['payment_id' => $locked->payment_id, 'gross_amount' => $order->amount ?? $order->total, 'platform_fee' => 0, 'net_amount' => $order->amount ?? $order->total, 'status' => 'pending']
                );
            }

            $locked->update([
                'request_metadata' => $metadata,
                'status' => $allAccepted ? 'paid' : 'manual_review',
                'verified_at' => $allAccepted ? now() : $locked->verified_at,
                'completed_at' => $allAccepted ? now() : $locked->completed_at,
            ]);
            if ($allAccepted) {
                // Seller UPI references are manual customer-entered UTRs stored on
                // the payment transaction. They are not unique gateway IDs.
                $locked->payment?->update(['status' => 'paid', 'captured_at' => now()]);

            }

            PaymentAuditRecord::create([
                'payment_id' => $locked->payment_id,
                'payment_transaction_id' => $locked->id,
                'user_id' => $seller->user_id,
                'event' => 'seller_upi.seller_verified',
                'from_status' => 'pending',
                'to_status' => 'paid',
                'metadata' => ['seller_id' => $seller->id, 'order_ids' => $orders->pluck('id')->all(), 'reference' => $reference],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return true;
        });

        return redirect()->route('seller.payments.upi-reviews')
            ->with($accepted ? 'success' : 'info', $accepted
                ? 'UPI payment accepted. Your seller order is now confirmed and the customer has been notified.'
                : 'This UPI payment has already been reviewed.');
    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENT DETAILS
    |--------------------------------------------------------------------------
    */

    public function show(Order $order)
    {
        $seller = $this->currentSeller();

        $order = Order::forSeller($seller->id)
            ->whereKey($order->id)
            ->with('user')
            ->firstOrFail();

        $sellerItems = $this->sellerItems(
            $order,
            $seller->id
        );

        $productIds = $sellerItems
            ->pluck('product_id')
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();

        $products = Product::where(
            'seller_id',
            $seller->id
        )
            ->whereIn(
                'id',
                $productIds
            )
            ->get()
            ->keyBy('id');

        $paymentStatus = $this->status($order);
        $paymentTransaction = $this->paymentTransactionForOrder($order);
        if ($paymentStatus === 'Pending' && $order->isCashOnDelivery()) {
            $paymentStatus = 'Cash';
        }

        $customer = $order->user;

        return view(
            'seller.payments.show',
            compact(
                'seller',
                'order',
                'sellerItems',
                'products',
                'paymentStatus',
                'paymentTransaction',
                'customer'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD RECEIPT
    |--------------------------------------------------------------------------
    */

    public function downloadReceipt(Order $order)
    {
        $seller = $this->currentSeller();

        /*
        |--------------------------------------------------------------------------
        | SECURITY
        |--------------------------------------------------------------------------
        */

        $order = Order::forSeller($seller->id)
            ->whereKey($order->id)
            ->with('user')
            ->firstOrFail();

        $customer = $order->user;

        /*
        |--------------------------------------------------------------------------
        | SELLER ITEMS
        |--------------------------------------------------------------------------
        */

        $sellerItems = $this->sellerItems(
            $order,
            $seller->id
        );

        abort_if(
            $sellerItems->isEmpty(),
            404,
            'No products from this seller were found in this order.'
        );

        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */

        $productIds = $sellerItems
            ->pluck('product_id')
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();

        $products = Product::where(
            'seller_id',
            $seller->id
        )
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | PAYMENT
        |--------------------------------------------------------------------------
        */

        $status = $this->status($order);

        $payment = $this->paymentTransactionForOrder(
            $order
        );

        $paymentId = $payment?->gateway_payment_id;
        $gatewayOrderId = $payment?->gateway_order_id;
        $upiReferences = $payment?->request_metadata['upi_references'] ?? [];
        $customerUpiReference = $payment?->gateway === 'seller_upi'
            ? ($upiReferences[(string) $seller->id] ?? $upiReferences[$seller->id] ?? null)
            : null;

        /*
        |--------------------------------------------------------------------------
        | PAYMENT DATE
        |--------------------------------------------------------------------------
        */

        $paymentDate =
            $payment?->verified_at
            ?? $payment?->created_at
            ?? $order->created_at
            ?? now();

        /*
        |--------------------------------------------------------------------------
        | RECEIPT ITEMS
        |--------------------------------------------------------------------------
        */

        $receiptItems = [];

        foreach ($sellerItems as $item) {

            $productId = $item['product_id'] ?? null;

            $product = $products->get(
                (int) $productId
            );

            $name =
                $item['name']
                ?? $product?->name
                ?? 'Product';

            $quantity = max(
                1,
                (int) (
                    $item['quantity'] ?? 1
                )
            );

            $price = (float) (
                $item['price']
                ?? $product?->price
                ?? 0
            );

            $lineTotal = $price * $quantity;

            $imageSource =
                $item['image']
                ?? $product?->image
                ?? null;

            $image = $this->makeImageDataUri(
                $imageSource
            );

            $receiptItems[] = [
                'product_id' => $productId,
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price,
                'line_total' => $lineTotal,
                'image' => $image,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $calculatedTotal = collect(
            $receiptItems
        )->sum('line_total');

        $orderTotal = (float) $calculatedTotal;

        /*
        |--------------------------------------------------------------------------
        | RECEIPT NUMBER
        |--------------------------------------------------------------------------
        */

        $receiptNumber =
            'SB-' .
            str_pad(
                (string) $order->id,
                6,
                '0',
                STR_PAD_LEFT
            );

        /*
        |--------------------------------------------------------------------------
        | PAYMENT METHOD
        |--------------------------------------------------------------------------
        */

        $paymentMethod =
            $order->isCashOnDelivery()
                ? 'CASH'
                : ($order->payment_method
                    ?? $payment?->payment_method
                    ?? 'ONLINE PAYMENT');

        $paymentMethod = strtoupper(
            str_replace(
                ['_', '-'],
                ' ',
                (string) $paymentMethod
            )
        );

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER
        |--------------------------------------------------------------------------
        */

        $customerName =
            $customer?->name
            ?? $order->name
            ?? 'Customer';

        $customerEmail =
            $customer?->email
            ?? null;

        $customerPhone =
            $customer?->phone
            ?? $customer?->mobile
            ?? $customer?->phone_number
            ?? $order->mobile
            ?? null;

        $customerUid =
            $customer?->customer_uid
            ?? null;

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER ADDRESS
        |--------------------------------------------------------------------------
        */

        $customerAddress =
            $order->address
            ?? $customer?->address
            ?? '';

        $customerCity =
            $order->city
            ?? $customer?->city
            ?? '';

        /*
        |--------------------------------------------------------------------------
        | ORDER DATE
        |--------------------------------------------------------------------------
        */

        try {
            $orderDate = Carbon::parse(
                $order->created_at
            )->format(
                'd M Y, h:i A'
            );
        } catch (\Throwable $e) {
            $orderDate = now()->format(
                'd M Y, h:i A'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT DATE
        |--------------------------------------------------------------------------
        */

        try {
            $formattedPaymentDate = Carbon::parse(
                $paymentDate
            )->format(
                'd M Y, h:i A'
            );
        } catch (\Throwable $e) {
            $formattedPaymentDate = now()->format(
                'd M Y, h:i A'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | RECEIPT DATE
        |--------------------------------------------------------------------------
        */

        $receiptDate = now()->format(
            'd M Y'
        );

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $data = [

            'order' => $order,

            'customer' => $customer,

            'customerName' => $customerName,

            'customerEmail' => $customerEmail,

            'customerPhone' => $customerPhone,

            'customerUid' => $customerUid,

            'customerAddress' => $customerAddress,

            'customerCity' => $customerCity,

            'receiptItems' => $receiptItems,

            'receiptNumber' => $receiptNumber,

            'status' => $status,

            'payment' => $payment,

            'paymentId' => $paymentId,

            'customerUpiReference' => $customerUpiReference,

            'gatewayOrderId' => $gatewayOrderId,

            'paymentMethod' => $paymentMethod,

            'paymentDate' => $paymentDate,

            'formattedPaymentDate' => $formattedPaymentDate,

            'orderDate' => $orderDate,

            'formattedOrderDate' => $orderDate,

            'receiptDate' => $receiptDate,

            'orderTotal' => $orderTotal,

            'calculatedTotal' => $calculatedTotal,

            'generatedAt' => now(),

        ];

        /*
        |--------------------------------------------------------------------------
        | LOAD PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'seller.payments.premium-receipt',
            $data
        );

        /*
        |--------------------------------------------------------------------------
        | A4 PORTRAIT
        |--------------------------------------------------------------------------
        */

        $pdf->setPaper(
            'A4',
            'portrait'
        );

        /*
        |--------------------------------------------------------------------------
        | DOMPDF SETTINGS
        |--------------------------------------------------------------------------
        */

        $dompdf = $pdf->getDomPDF();

        $dompdf->set_option(
            'isRemoteEnabled',
            true
        );

        $dompdf->set_option(
            'isHtml5ParserEnabled',
            true
        );

        $dompdf->set_option(
            'isPhpEnabled',
            false
        );

        $dompdf->set_option(
            'defaultFont',
            'DejaVu Sans'
        );

        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD
        |--------------------------------------------------------------------------
        */

        $fileName =
            'SMART-BASKET-RECEIPT-' .
            $receiptNumber .
            '.pdf';

        return $pdf->download(
            $fileName
        );
    }


    /*
    |--------------------------------------------------------------------------
    | IMAGE TO DATA URI
    |--------------------------------------------------------------------------
    */

    private function makeImageDataUri(
        mixed $path
    ): ?string {

        if (
            $path === null ||
            $path === ''
        ) {
            return null;
        }

        if (
            is_string($path) &&
            str_starts_with(
                trim($path),
                'data:image/'
            )
        ) {
            return $path;
        }

        if (!is_string($path)) {
            return null;
        }

        $originalPath = trim($path);

        /*
        |--------------------------------------------------------------------------
        | REMOTE URL
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $originalPath,
                'http://'
            ) ||
            str_starts_with(
                $originalPath,
                'https://'
            )
        ) {

            $parsedPath = parse_url(
                $originalPath,
                PHP_URL_PATH
            );

            if (
                is_string($parsedPath) &&
                $parsedPath !== ''
            ) {

                $localData =
                    $this->makeImageDataUri(
                        $parsedPath
                    );

                if ($localData) {
                    return $localData;
                }
            }

            try {

                $context = stream_context_create([
                    'http' => [
                        'timeout' => 5,
                        'follow_location' => 1,
                    ],
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]);

                $contents = @file_get_contents(
                    $originalPath,
                    false,
                    $context
                );

                if ($contents !== false) {

                    $extension = strtolower(
                        pathinfo(
                            parse_url(
                                $originalPath,
                                PHP_URL_PATH
                            ) ?? '',
                            PATHINFO_EXTENSION
                        )
                    );

                    $mime = match ($extension) {

                        'jpg',
                        'jpeg' => 'image/jpeg',

                        'png' => 'image/png',

                        'gif' => 'image/gif',

                        'webp' => 'image/webp',

                        default => 'image/jpeg',
                    };

                    return 'data:' .
                        $mime .
                        ';base64,' .
                        base64_encode(
                            $contents
                        );
                }

            } catch (\Throwable $e) {
                return null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | NORMALIZE
        |--------------------------------------------------------------------------
        */

        $cleanPath = str_replace(
            '\\',
            '/',
            $originalPath
        );

        $cleanPath = ltrim(
            $cleanPath,
            '/'
        );

        $cleanPath = preg_replace(
            '#^storage/#i',
            '',
            $cleanPath
        );

        $cleanPath = preg_replace(
            '#^public/#i',
            '',
            $cleanPath
        );

        /*
        |--------------------------------------------------------------------------
        | POSSIBLE PATHS
        |--------------------------------------------------------------------------
        */

        $possiblePaths = [

            public_path(
                $cleanPath
            ),

            public_path(
                'storage/' .
                $cleanPath
            ),

            storage_path(
                'app/public/' .
                $cleanPath
            ),

            public_path(
                'images/' .
                basename($cleanPath)
            ),

            storage_path(
                'app/public/images/' .
                basename($cleanPath)
            ),
        ];

        foreach ($possiblePaths as $possiblePath) {

            if (
                is_string($possiblePath) &&
                file_exists($possiblePath) &&
                is_readable($possiblePath)
            ) {

                $dataUri =
                    $this->fileToDataUri(
                        $possiblePath
                    );

                if ($dataUri) {
                    return $dataUri;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | STORAGE FALLBACK
        |--------------------------------------------------------------------------
        */

        try {

            if (
                Storage::disk('public')
                    ->exists($cleanPath)
            ) {

                $contents =
                    Storage::disk('public')
                        ->get($cleanPath);

                $extension = strtolower(
                    pathinfo(
                        $cleanPath,
                        PATHINFO_EXTENSION
                    )
                );

                $mime = match ($extension) {

                    'jpg',
                    'jpeg' => 'image/jpeg',

                    'png' => 'image/png',

                    'gif' => 'image/gif',

                    'webp' => 'image/webp',

                    'svg' => 'image/svg+xml',

                    default => null,
                };

                if (
                    $mime &&
                    $contents !== false
                ) {

                    return 'data:' .
                        $mime .
                        ';base64,' .
                        base64_encode(
                            $contents
                        );
                }
            }

        } catch (\Throwable $e) {
            // Ignore image errors.
        }

        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | FILE TO DATA URI
    |--------------------------------------------------------------------------
    */

    private function fileToDataUri(
        string $path
    ): ?string {

        if (
            !file_exists($path) ||
            !is_readable($path)
        ) {
            return null;
        }

        $extension = strtolower(
            pathinfo(
                $path,
                PATHINFO_EXTENSION
            )
        );

        $mime = match ($extension) {

            'jpg',
            'jpeg' => 'image/jpeg',

            'png' => 'image/png',

            'gif' => 'image/gif',

            'webp' => 'image/webp',

            'svg' => 'image/svg+xml',

            'bmp' => 'image/bmp',

            default => null,
        };

        if (!$mime) {
            return null;
        }

        $contents = @file_get_contents(
            $path
        );

        if (
            $contents === false ||
            $contents === ''
        ) {
            return null;
        }

        return 'data:' .
            $mime .
            ';base64,' .
            base64_encode(
                $contents
            );
    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENT TRANSACTION
    |--------------------------------------------------------------------------
    */

    private function paymentTransactionForOrder(
        Order $order
    ): ?PaymentTransaction {

        $payments = PaymentTransaction::query()
            ->where(
                'user_id',
                $order->user_id
            )
            ->latest('id')
            ->get();

        return $payments->first(
            function (
                PaymentTransaction $payment
            ) use ($order) {

                $orderIds = collect(
                    $payment->order_ids ?? []
                )
                    ->map(
                        fn ($id) =>
                            (int) $id
                    )
                    ->all();

                return in_array(
                    (int) $order->id,
                    $orderIds,
                    true
                );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER PAYMENTS
    |--------------------------------------------------------------------------
    */

    private function filteredPayments(
        Request $request,
        int $sellerId
    ) {

        $query = Order::forSeller(
            $sellerId
        )
            ->with('user');

        if (
            $search = trim(
                (string) $request->input('search')
            )
        ) {

            $productIds = Product::where(
                'seller_id',
                $sellerId
            )
                ->where(
                    'name',
                    'like',
                    "%{$search}%"
                )
                ->pluck('id');

            $query->where(
                function ($orders) use (
                    $search,
                    $productIds
                ) {

                    $orders
                        ->where(
                            'id',
                            $search
                        )
                        ->orWhere(
                            'name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'user',
                            function ($users) use (
                                $search
                            ) {

                                $users
                                    ->where(
                                        'name',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'customer_uid',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        )
                        ->orWhere(
                            function (
                                $orders
                            ) use (
                                $productIds
                            ) {

                                foreach (
                                    $productIds as $productId
                                ) {

                                    $orders->orWhereJsonContains(
                                        'items',
                                        [
                                            'product_id' =>
                                                $productId
                                        ]
                                    );
                                }
                            }
                        );
                }
            );
        }

        if ($request->filled('from')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->input('from')
            );
        }

        if ($request->filled('to')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->input('to')
            );
        }

        if (
            $status = $request->input('status')
        ) {

            $query->whereIn(
                'payment_status',
                match ($status) {

                    'Successful' => [
                        'Paid',
                        'Successful',
                    ],

                    'Pending' => [
                        'Pending',
                    ],

                    'Cash' => [
                        'Pending',
                    ],

                    'Failed' => [
                        'Failed',
                    ],

                    'Refunded' => [
                        'Refunded',
                    ],

                    default => [],
                }
            );

            if ($status === 'Cash') {
                $query->whereIn('payment_method', ['COD', 'cod', 'cash', 'cash_on_delivery', 'Cash on Delivery']);
            } elseif ($status === 'Pending') {
                $query->whereNotIn('payment_method', ['COD', 'cod', 'cash', 'cash_on_delivery', 'Cash on Delivery']);
            }
        }

        if (
            $method = $request->input('method')
        ) {

            if (in_array(strtolower(trim($method)), ['cod', 'cash', 'cash_on_delivery', 'cash on delivery'], true)) {
                $query->whereIn('payment_method', ['COD', 'cod', 'cash', 'cash_on_delivery', 'Cash on Delivery']);
            } else {
                $query->where('payment_method', $method);
            }
        }

        return $query;
    }


    /*
    |--------------------------------------------------------------------------
    | ATTACH SELLER ITEMS
    |--------------------------------------------------------------------------
    */

    private function attachSellerItems(
        $orders,
        int $sellerId
    ): void {

        $products = Product::where(
            'seller_id',
            $sellerId
        )
            ->get()
            ->keyBy('id');

        foreach ($orders as $order) {

            $order->setAttribute(
                'seller_items',
                $this->sellerItems(
                    $order,
                    $sellerId
                )
            );

            $order->setAttribute(
                'seller_products',
                $products
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SELLER ITEMS
    |--------------------------------------------------------------------------
    */

    private function sellerItems(
        Order $order,
        int $sellerId
    ) {

        return collect(
            $order->items ?? []
        )
            ->filter(
                fn ($item) =>
                    (int) (
                        $item['seller_id'] ?? 0
                    ) === $sellerId
            )
            ->values();
    }


    /*
    |--------------------------------------------------------------------------
    | SELLER ORDER TOTAL
    |--------------------------------------------------------------------------
    */

    private function sellerOrderTotal(
        Order $order,
        int $sellerId
    ): float {

        return $this->sellerItems(
            $order,
            $sellerId
        )->sum(
            function ($item) {

                $quantity = max(
                    1,
                    (int) (
                        $item['quantity'] ?? 1
                    )
                );

                $price = (float) (
                    $item['price'] ?? 0
                );

                return $price * $quantity;
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENT STATUS
    |--------------------------------------------------------------------------
    */

    public function status(
        Order $order
    ): string {

        if (
            $order->isCashOnDelivery()
            && in_array(strtolower(trim((string) $order->payment_status)), ['pending', 'cash'], true)
        ) {
            return 'Cash';
        }

        return match (
            $order->payment_status
        ) {

            'Paid',
            'Successful' =>
                'Successful',

            'Failed' =>
                'Failed',

            'Refunded' =>
                'Refunded',

            default =>
                'Pending',
        };
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
}
