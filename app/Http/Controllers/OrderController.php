<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Models\Product;
use App\Services\CheckoutOrderService;
use App\Services\RazorpayPaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PLACE ORDER
    |--------------------------------------------------------------------------
    */

    public function placeOrder(
        Request $request,
        CheckoutOrderService $checkout,
        RazorpayPaymentGateway $gateway
    ) {
        $customerDetails =
            $checkout->customerDetailsFromRequest($request);

        $paymentMethod =
            $request->payment_method ?? 'COD';

        $itemsBySeller =
            $checkout->itemsBySellerForCurrentCheckout();

        $user =
            Auth::user();

        try {

            $checkout->assertCheckoutCanProceed(
                $itemsBySeller,
                $paymentMethod
            );

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

        if (! $checkout->isOnlineMethod($paymentMethod)) {

            $checkout->createConfirmedOrders(
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
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ONLINE PAYMENT
        |--------------------------------------------------------------------------
        */

        $total =
            $checkout->totalForItems(
                $itemsBySeller
            );


        $payment = PaymentTransaction::create([

            'user_id' =>
                $user?->id,

            'access_token' =>
                Str::random(64),

            'gateway' =>
                'razorpay',

            'payment_method' =>
                $paymentMethod,

            'status' =>
                'pending',

            'amount' =>
                $total,

            'amount_paise' =>
                (int) round($total * 100),

            'currency' =>
                'INR',

            'items_snapshot' =>
                $itemsBySeller,

            'customer_details' =>
                $customerDetails,

            'expires_at' =>
                now()->addMinutes(30),

        ]);


        session([
            'payment_transaction_token.' .
            $payment->id =>
                $payment->access_token
        ]);


        /*
        |--------------------------------------------------------------------------
        | CREATE RAZORPAY ORDER
        |--------------------------------------------------------------------------
        */

        $gatewayOrder =
            $gateway->createOrder($payment);


        if (! $gatewayOrder['success']) {

            $payment->update([

                'status' =>
                    'pending',

                'failure_reason' =>
                    $gatewayOrder['message'],

            ]);

            return redirect()
                ->route(
                    'payments.show',
                    $payment
                )
                ->with(
                    'error',
                    $gatewayOrder['message']
                );
        }


        $payment->update([

            'gateway_order_id' =>
                $gatewayOrder['gateway_order_id'],

            'status' =>
                'processing',

        ]);


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


        return view(
            'orders.show',
            compact(
                'order',
                'products'
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
            ?? $order->payment_status
            ?? 'Pending';


        $paymentId =
            $payment?->gateway_payment_id;


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

    public function cancel(
        Request $request,
        Order $order
    ) {
        abort_unless(
            Auth::check() &&
            (int) $order->user_id ===
            (int) Auth::id(),
            403
        );


        abort_unless(
            $order->isCancellable(),
            422,
            'This order can no longer be cancelled.'
        );


        $validated =
            $request->validate([
                'cancellation_reason' =>
                    [
                        'nullable',
                        'string',
                        'max:500'
                    ],
            ]);


        DB::transaction(
            function () use (
                $order,
                $validated
            ) {

                $lockedOrder =
                    Order::lockForUpdate()
                        ->findOrFail(
                            $order->id
                        );


                abort_unless(
                    $lockedOrder->isCancellable(),
                    422,
                    'This order can no longer be cancelled.'
                );


                $lockedOrder->update([

                    'status' =>
                        'Cancelled',

                    'order_status' =>
                        'Cancelled',

                    'delivery_status' =>
                        'Cancelled',

                    'cancellation_reason' =>
                        $validated[
                            'cancellation_reason'
                        ] ?? null,

                    'cancelled_at' =>
                        now(),

                ]);


                if (
                    $lockedOrder->deliveryDetail
                ) {

                    $lockedOrder
                        ->deliveryDetail
                        ->update([
                            'status' =>
                                'Cancelled'
                        ]);
                }


                foreach (
                    $lockedOrder->items ?? []
                    as $item
                ) {

                    Product::whereKey(
                        $item['product_id'] ?? null
                    )
                    ->lockForUpdate()
                    ->increment(
                        'stock',
                        (int) (
                            $item['quantity']
                            ?? 0
                        )
                    );
                }
            }
        );


        return redirect() 
            ->route('orders.index')
            ->with(
                'success',
                'Order cancelled successfully. Payment status was left unchanged because no refund workflow is configured.'
            );
    }
}