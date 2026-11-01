<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderCancellationRequest;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Models\Product;
use App\Services\CheckoutOrderService;
use App\Services\PaymentService;
use App\Services\SellerCancellationSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function success()
    {
        $orderIds = collect(session()->pull('order_success_order_ids', []))
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values();

        $orders = Order::with('seller')
            ->where('user_id', Auth::id())
            ->whereIn('id', $orderIds)
            ->latest()
            ->get();

        $productIds = $orders->flatMap(fn ($order) => collect($order->items ?? [])->pluck('product_id'))
            ->filter()->map(fn ($id) => (int) $id)->unique();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $receipts = $orders->map(function (Order $order) use ($products) {
            $payment = $this->paymentTransactionForOrder($order);
            $sellerUpiReference = $payment?->gateway === 'seller_upi'
                ? ($payment->request_metadata['upi_references'][(string) $order->seller_id] ?? null)
                : null;
            $transactionId = $sellerUpiReference
                ?: $payment?->gateway_transaction_id
                ?: $payment?->gateway_payment_id
                ?: $payment?->gateway_order_id
                ?: ($order->isCashOnDelivery() ? 'COD-' . $order->id : null);
            $items = collect($order->items ?? [])->map(function ($line) use ($products) {
                $product = $products->get((int) ($line['product_id'] ?? 0));

                return [
                    'name' => $line['name'] ?? $product?->name ?? 'Product',
                    'quantity' => (int) ($line['quantity'] ?? 1),
                    'price' => (float) ($line['price'] ?? $line['unit_price'] ?? 0),
                    'image' => $product?->image ? asset('products/' . $product->image) : null,
                ];
            })->values();

            return [
                'order' => $order,
                'items' => $items,
                'transaction_id' => $transactionId,
                'seller_name' => $order->seller?->getSellerDisplayName() ?? 'Seller',
                'receipt_url' => route('orders.receipt', $order),
            ];
        });

        return view('order-success', compact('receipts'));
    }

    /*
    |--------------------------------------------------------------------------
    | PLACE ORDER
    |--------------------------------------------------------------------------
    */

    public function placeOrder(
        Request $request,
        CheckoutOrderService $checkout,
        PaymentService $payments
    ) {
        $customerDetails =
            $checkout->customerDetailsFromRequest($request);

        $paymentMethod = strtoupper(trim((string) $request->input('payment_method', 'COD')));
        if (! in_array($paymentMethod, ['COD', 'UPI', 'CARD'], true)) {
            return back()->withErrors(['payment_method' => 'Choose UPI, card, or Cash on Delivery.'])->withInput();
        }

        $itemsBySeller =
            $checkout->itemsBySellerForCurrentCheckout();

        $user =
            Auth::user();

        try {

            $checkout->assertCheckoutCanProceed($itemsBySeller, $paymentMethod);

        } catch (\RuntimeException $exception) {

            return $exception->getMessage() === 'Your cart is empty.'
                ? redirect('/cart')
                    ->with('error', $exception->getMessage())
                : back()
                    ->with('error', $exception->getMessage());
        }


        /*
        |--------------------------------------------------------------------------
        | CASH ON DELIVERY
        |--------------------------------------------------------------------------
        */

        // COD confirms immediately. Seller UPI is submitted for manual review;
        // card orders continue through the configured payment gateway.
        if ($paymentMethod === 'COD') {

            $orderIds = $checkout->createConfirmedOrders(
                $itemsBySeller,
                $customerDetails,
                $user?->id,
                'COD',
                'Pending'
            );

            $checkout->clearCurrentCheckout(
                $user?->id
            );

            return redirect('/order-success')
                ->with(
                    'success',
                    'Order placed successfully.'
                )
                ->with('order_success_order_ids', $orderIds);
        }

        if ($paymentMethod === 'UPI') {
            $sellerPayments = [];
            foreach ($itemsBySeller as $sellerId => $items) {
                $seller = \App\Models\SellerProfile::find((int) $sellerId);
                if (! $seller || ! $seller->isOnlinePaymentEnabled() || ! $seller->hasValidPaymentConfiguration()) {
                    return back()->with('error', 'A seller has not completed UPI payment setup. Choose Cash on Delivery or remove those products.');
                }

                $sellerAmount = $checkout->totalForItems([(int) $sellerId => $items]);
                $reference = 'SB-' . strtoupper(substr(hash('sha256', session()->getId() . '|' . $sellerId), 0, 10));
                $sellerPayments[] = [
                    'seller_id' => (int) $sellerId,
                    'seller_name' => $seller->getPaymentBusinessName(),
                    'upi_id' => $seller->getPaymentUpiId(),
                    'amount' => $sellerAmount,
                    'order_reference' => $reference,
                    'upi_uri' => $seller->paymentUriForAmount($sellerAmount, $reference),
                ];
            }

            $total = $checkout->totalForItems($itemsBySeller);
            $nonce = (string) session('checkout_payment_nonce', '');
            if ($nonce === '') {
                $nonce = Str::uuid()->toString();
                session(['checkout_payment_nonce' => $nonce]);
            }
            $idempotencyKey = hash('sha256', $nonce . '|' . (string) $user->id . '|seller-upi|' . json_encode($itemsBySeller, JSON_THROW_ON_ERROR));
            $canonicalPayment = Payment::firstOrCreate(
                ['idempotency_key' => $idempotencyKey],
                ['user_id' => $user->id, 'gateway' => 'seller_upi', 'payment_method' => 'UPI', 'status' => 'pending', 'amount' => $total, 'currency' => 'INR', 'metadata' => ['seller_payments' => $sellerPayments]]
            );
            $payment = $canonicalPayment->transactions()->firstOrCreate(
                ['attempt_number' => 1],
                [
                    'user_id' => $user->id,
                    'access_token' => Str::random(80),
                    'gateway' => 'seller_upi',
                    'payment_method' => 'UPI',
                    'status' => 'pending',
                    'amount' => $total,
                    'amount_paise' => (int) round((float) $total * 100),
                    'currency' => 'INR',
                    'items_snapshot' => $itemsBySeller,
                    'customer_details' => $customerDetails,
                    'order_ids' => [],
                    'request_metadata' => ['seller_payments' => $sellerPayments],
                    'initiated_at' => now(),
                    'expires_at' => now()->addHours(24),
                ]
            );
            session(['payment_transaction_token.' . $payment->id => $payment->access_token]);

            return redirect()->route('payments.show', $payment)
                ->with('success', 'Scan each seller QR for the exact amount, then submit each UPI reference number.');
        }

        /*
        |--------------------------------------------------------------------------
        | ONLINE PAYMENT
        |--------------------------------------------------------------------------
        */

        $total = $checkout->totalForItems($itemsBySeller);
        $idempotencySeed = (string) session('checkout_payment_nonce', '');
        if ($idempotencySeed === '') {
            $idempotencySeed = Str::uuid()->toString();
            session(['checkout_payment_nonce' => $idempotencySeed]);
        }
        $idempotencyKey = hash('sha256', implode('|', [
            $idempotencySeed,
            (string) $user->id,
            $paymentMethod,
            json_encode($itemsBySeller, JSON_THROW_ON_ERROR),
            json_encode($customerDetails, JSON_THROW_ON_ERROR),
        ]));

        $canonicalPayment = $payments->createPayment($user, $total, 'INR', $paymentMethod, [], $idempotencyKey);
        $payment = $payments->initiatePayment($canonicalPayment, $itemsBySeller, $customerDetails);
        session(['payment_transaction_token.' . $payment->id => $payment->access_token]);

        if ($payment->status === 'failed') {
            return redirect()->route('payments.show', $payment)->with('error', $payment->failure_reason);
        }


        return redirect()
            ->route(
                'payments.show',
                $payment
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MY ORDERS
    |--------------------------------------------------------------------------
    */

    public function myOrders()
    {
        if (! Auth::check()) {
            return redirect('/login');
        }


        $orders =
            Order::with(
                'deliveryDetail.deliveryPartner'
            )
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->get();


        $products =
            Product::whereIn(
                'id',
                $orders
                    ->flatMap(
                        fn ($order) =>
                            collect(
                                $order->items ?? []
                            )->pluck('product_id')
                    )
                    ->filter()
                    ->unique()
            )
            ->get()
            ->keyBy('id');


        return view(
            'orders.index',
            compact(
                'orders',
                'products'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ORDER DETAILS
    |--------------------------------------------------------------------------
    */

    public function show(Order $order)
    {
        if (! Auth::check()) {
            return redirect('/login');
        }


        abort_unless(
            (int) $order->user_id ===
            (int) Auth::id(),
            403
        );


        $order->load(
            'deliveryDetail.deliveryPartner'
        );


        $products =
            Product::whereIn(
                'id',
                collect(
                    $order->items ?? []
                )
                ->pluck('product_id')
                ->filter()
            )
            ->get()
            ->keyBy('id');

        $orderStatuses = collect([$order->deliveryDetail?->status, $order->delivery_status, $order->order_status, $order->status])
            ->filter()->map(fn ($status) => strtolower(trim((string) $status)));
        $orderIsCancelled = $orderStatuses->contains(fn ($status) => in_array($status, ['cancelled', 'canceled'], true));
        $canRequestReturn = ! $orderIsCancelled
            && $orderStatuses->contains(fn ($status) => in_array($status, ['delivered', 'complete', 'completed'], true))
            && $order->isPaymentEligibleForReturn()
            && $order->created_at?->gte(now()->subDays((int) config('returns.window_days', 30)));
        return view(
            'orders.show',
            compact(
                'order',
                'products',
                'canRequestReturn'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER PAYMENT RECEIPT
    |--------------------------------------------------------------------------
    */

    public function downloadReceipt(Order $order)
    {
        if (! Auth::check()) {
            return redirect('/login');
        }


        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $order->user_id ===
            (int) Auth::id(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products =
            Product::whereIn(
                'id',
                collect(
                    $order->items ?? []
                )
                ->pluck('product_id')
                ->filter()
                ->unique()
            )
            ->get()
            ->keyBy('id');


        /*
        |--------------------------------------------------------------------------
        | Find Payment Transaction
        |--------------------------------------------------------------------------
        */

        $payment =
            $this->paymentTransactionForOrder(
                $order
            );


        /*
        |--------------------------------------------------------------------------
        | Payment information
        |--------------------------------------------------------------------------
        */

        $paymentStatus =
            $payment?->status
            ?? $order->payment_status_label
            ?? 'Pending';


        $paymentId =
            ($payment?->gateway === 'seller_upi'
                ? ($payment->request_metadata['upi_references'][(string) $order->seller_id] ?? null)
                : null)
            ?: $payment?->gateway_transaction_id
            ?: $payment?->gateway_payment_id;


        $gatewayOrderId =
            $payment?->gateway_order_id;


        $paymentDate =
            $payment?->verified_at
            ?? (
                $order->created_at
                ?? now()
            );


        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf =
            Pdf::loadView(
                'orders.receipt',
                [
                    'order' =>
                        $order,

                    'products' =>
                        $products,

                    'payment' =>
                        $payment,

                    'paymentStatus' =>
                        $paymentStatus,

                    'paymentId' =>
                        $paymentId,

                    'gatewayOrderId' =>
                        $gatewayOrderId,

                    'paymentDate' =>
                        $paymentDate,
                ]
            );


        $pdf->setPaper(
            'A4',
            'portrait'
        );


        return $pdf->download(
            'SMART-BASKET-Payment-Receipt-SB-' .
            $order->id .
            '.pdf'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FIND PAYMENT TRANSACTION FOR ORDER
    |--------------------------------------------------------------------------
    */

    private function paymentTransactionForOrder(
        Order $order
    ): ?PaymentTransaction {

        $payments =
            PaymentTransaction::query()
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

                $orderIds =
                    collect(
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
    | CANCEL ORDER
    |--------------------------------------------------------------------------
    */

    public function createCancellationForm(Order $order)
    {
        abort_unless(Auth::check() && (int) $order->user_id === (int) Auth::id(), 404);
        abort_unless($order->isCancellable(), 422, 'This order can no longer be cancelled.');

        $refundRequired = ! $order->isCashOnDelivery()
            && in_array(strtolower((string) $order->payment_status), ['paid', 'successful', 'verified', 'captured'], true);
        $products = Product::whereIn('id', collect($order->items ?? [])->pluck('product_id')->filter())->get()->keyBy('id');

        return response()
            ->view('orders.cancel', compact('order', 'products', 'refundRequired'))
            ->header('Cache-Control', 'private, no-store');
    }

    public function requestOptions(Order $order)
    {
        abort_unless(Auth::check() && (int) $order->user_id === (int) Auth::id(), 404);

        $canCancel = $order->isCancellable();
        $statuses = collect([$order->deliveryDetail?->status, $order->delivery_status, $order->order_status, $order->status])
            ->filter()->map(fn ($status) => strtolower(trim((string) $status)));
        $isCancelled = $statuses->contains(fn ($status) => in_array($status, ['cancelled', 'canceled'], true));
        $canReturn = ! $isCancelled
            && $statuses->contains(fn ($status) => in_array($status, ['delivered', 'complete', 'completed'], true))
            && $order->isPaymentEligibleForReturn()
            && $order->created_at?->gte(now()->subDays((int) config('returns.window_days', 30)));

        return view('orders.request-options', compact('order', 'canCancel', 'canReturn'));
    }

    public function cancel(
        Request $request,
        Order $order,
        SellerCancellationSms $sms
    ) {
        abort_unless(Auth::check() && (int) $order->user_id === (int) Auth::id(), 403);

        $cancellation = DB::transaction(function () use ($request, $order) {
            $lockedOrder = Order::with('seller')->lockForUpdate()->findOrFail($order->id);
            abort_unless((int) $lockedOrder->user_id === (int) Auth::id(), 403);
            abort_unless($lockedOrder->isCancellable(), 422, 'This order can no longer be cancelled.');

            $refundRequired = ! $lockedOrder->isCashOnDelivery()
                && in_array(strtolower((string) $lockedOrder->payment_status), ['paid', 'successful', 'verified', 'captured'], true);
            $savedRefund = Auth::user();
            foreach ([
                'upi_id' => 'refund_upi_id',
                'bank_account_holder' => 'refund_account_holder',
                'bank_name' => 'refund_bank_name',
                'bank_account_number' => 'refund_account_number',
                'bank_ifsc' => 'refund_ifsc',
            ] as $input => $profileField) {
                if (! filled($request->input($input)) && filled($savedRefund?->{$profileField})) {
                    $request->merge([$input => $savedRefund->{$profileField}]);
                }
            }
            if (! filled($request->input('refund_method'))) {
                $request->merge(['refund_method' => filled($savedRefund?->refund_upi_id) ? 'upi' : (filled($savedRefund?->refund_account_number) ? 'bank' : null)]);
            }

            $validated = $request->validate([
                'cancellation_reason' => ['nullable', 'string', 'max:500'],
                'refund_method' => ['required', 'in:upi,bank'],
                'upi_id' => ['nullable', 'required_if:refund_method,upi', 'string', 'max:120', 'regex:/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+$/'],
                'bank_account_holder' => ['nullable', 'required_if:refund_method,bank', 'string', 'max:150'],
                'bank_name' => ['nullable', 'required_if:refund_method,bank', 'string', 'max:150'],
                'bank_account_number' => ['nullable', 'required_if:refund_method,bank', 'regex:/^[0-9]{6,20}$/'],
                'bank_ifsc' => ['nullable', 'required_if:refund_method,bank', 'regex:/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/'],
            ]);

            $refundAmount = $refundRequired ? (float) ($lockedOrder->amount ?? $lockedOrder->total) : 0.0;
            $refundMethod = $validated['refund_method'];
            if ($refundMethod === 'upi') {
                $savedRefund->forceFill(['refund_upi_id' => $validated['upi_id']])->save();
            } else {
                $savedRefund->forceFill([
                    'refund_account_holder' => $validated['bank_account_holder'],
                    'refund_bank_name' => $validated['bank_name'],
                    'refund_account_number' => $validated['bank_account_number'],
                    'refund_ifsc' => strtoupper($validated['bank_ifsc']),
                ])->save();
            }
            $cancellation = OrderCancellationRequest::create([
                'order_id' => $lockedOrder->id,
                'user_id' => $lockedOrder->user_id,
                'seller_id' => $lockedOrder->seller_id,
                'status' => $refundRequired ? OrderCancellationRequest::STATUS_REFUND_PENDING : OrderCancellationRequest::STATUS_NO_REFUND,
                'reason' => $validated['cancellation_reason'] ?? null,
                'refund_amount' => $refundAmount,
                'refund_method' => $refundMethod,
                'upi_id' => $refundMethod === 'upi' ? $validated['upi_id'] : null,
                'bank_account_holder' => $refundMethod === 'bank' ? $validated['bank_account_holder'] : null,
                'bank_name' => $refundMethod === 'bank' ? $validated['bank_name'] : null,
                'bank_account_number' => $refundMethod === 'bank' ? $validated['bank_account_number'] : null,
                'bank_ifsc' => $refundMethod === 'bank' ? strtoupper($validated['bank_ifsc']) : null,
            ]);

            $lockedOrder->update([
                'status' => 'Cancelled',
                'order_status' => 'Cancelled',
                'delivery_status' => 'Cancelled',
                'cancellation_reason' => $validated['cancellation_reason'] ?? null,
                'cancelled_at' => now(),
            ]);

            $lockedOrder->deliveryDetail?->update(['status' => 'Cancelled']);

            foreach ($lockedOrder->items ?? [] as $item) {
                Product::whereKey($item['product_id'] ?? null)
                    ->lockForUpdate()
                    ->increment('stock', (int) ($item['quantity'] ?? 0));
            }

            if ($lockedOrder->seller?->user_id) {
                Notification::create([
                    'user_id' => $lockedOrder->seller->user_id,
                    'seller_id' => $lockedOrder->seller_id,
                    'role' => 'seller',
                    'type' => 'order_cancellation',
                    'title' => 'Customer cancelled order #' . $lockedOrder->id,
                    'message' => $refundRequired
                        ? 'Refund of INR ' . number_format($refundAmount, 2) . ' is pending. Open Order Cancellations to view the secure customer refund details.'
                        : 'The customer cancelled this order. No payment refund is due.',
                    'data' => ['order_id' => $lockedOrder->id, 'cancellation_id' => $cancellation->id],
                ]);
            }

            return $cancellation;
        });

        $smsSent = $sms->send($cancellation->load(['order', 'seller']));

        $message = $cancellation->status === OrderCancellationRequest::STATUS_REFUND_PENDING
            ? 'Order cancelled. Your refund is pending seller payment.'
            : 'Order cancelled successfully.';
        $message .= $smsSent
            ? ' Seller SMS notification queued.'
            : ' Seller SMS alerts need Twilio setup; the cancellation is saved in the seller panel.';

        return redirect()->route('orders.show', $order)->with('success', $message);
    }
}
