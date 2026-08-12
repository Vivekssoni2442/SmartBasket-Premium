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

class OrderController extends Controller
{
    public function placeOrder(Request $request, CheckoutOrderService $checkout, RazorpayPaymentGateway $gateway)
    {
        $customerDetails = $checkout->customerDetailsFromRequest($request);
        $paymentMethod = $request->payment_method ?? 'COD';
        $itemsBySeller = $checkout->itemsBySellerForCurrentCheckout();
        $user = Auth::user();

        try {
            $checkout->assertCheckoutCanProceed($itemsBySeller, $paymentMethod);
        } catch (\RuntimeException $exception) {
            return $exception->getMessage() === 'Your cart is empty.'
                ? redirect('/cart')->with('error', $exception->getMessage())
                : back()->with('error', $exception->getMessage());
        }

        if (! $checkout->isOnlineMethod($paymentMethod)) {
            $checkout->createConfirmedOrders($itemsBySeller, $customerDetails, $user?->id, 'COD', 'Pending');
            $checkout->clearCurrentCheckout($user?->id);

            return redirect('/order-success')->with('success', 'Order placed successfully.');
        }

        $payment = PaymentTransaction::create([
            'user_id' => $user?->id,
            'access_token' => Str::random(64),
            'gateway' => 'razorpay',
            'payment_method' => $paymentMethod,
            'status' => 'pending',
            'amount' => $checkout->totalForItems($itemsBySeller),
            'amount_paise' => (int) round($checkout->totalForItems($itemsBySeller) * 100),
            'currency' => 'INR',
            'items_snapshot' => $itemsBySeller,
            'customer_details' => $customerDetails,
            'expires_at' => now()->addMinutes(30),
        ]);

        session(['payment_transaction_token.' . $payment->id => $payment->access_token]);

        $gatewayOrder = $gateway->createOrder($payment);
        if (! $gatewayOrder['success']) {
            $payment->update([
                'status' => 'pending',
                'failure_reason' => $gatewayOrder['message'],
            ]);

            return redirect()->route('payments.show', $payment)
                ->with('error', $gatewayOrder['message']);
        }

        $payment->update([
            'gateway_order_id' => $gatewayOrder['gateway_order_id'],
            'status' => 'processing',
        ]);

        return redirect()->route('payments.show', $payment);
    }

    public function myOrders()
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        $orders = Order::with('deliveryDetail.deliveryPartner')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        $products = Product::whereIn('id', $orders->flatMap(fn ($order) => collect($order->items ?? [])->pluck('product_id'))->filter()->unique())->get()->keyBy('id');

        return view('orders.index', compact('orders', 'products'));
    }

    public function show(Order $order)
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        abort_unless((int) $order->user_id === (int) Auth::id(), 403);

        $order->load('deliveryDetail.deliveryPartner');
        $products = Product::whereIn('id', collect($order->items ?? [])->pluck('product_id')->filter())->get()->keyBy('id');

        return view('orders.show', compact('order', 'products'));
    }

    public function cancel(Request $request, Order $order)
    {
        abort_unless(Auth::check() && (int) $order->user_id === (int) Auth::id(), 403);
        abort_unless($order->isCancellable(), 422, 'This order can no longer be cancelled.');
        $validated = $request->validate(['cancellation_reason' => ['nullable', 'string', 'max:500']]);

        DB::transaction(function () use ($order, $validated) {
            $lockedOrder = Order::lockForUpdate()->findOrFail($order->id);
            abort_unless($lockedOrder->isCancellable(), 422, 'This order can no longer be cancelled.');
            $lockedOrder->update(['status' => 'Cancelled', 'order_status' => 'Cancelled', 'delivery_status' => 'Cancelled', 'cancellation_reason' => $validated['cancellation_reason'] ?? null, 'cancelled_at' => now()]);
            if ($lockedOrder->deliveryDetail) $lockedOrder->deliveryDetail->update(['status' => 'Cancelled']);
            foreach ($lockedOrder->items ?? [] as $item) Product::whereKey($item['product_id'] ?? null)->lockForUpdate()->increment('stock', (int) ($item['quantity'] ?? 0));
        });

        return redirect()->route('orders.index')->with('success', 'Order cancelled successfully. Payment status was left unchanged because no refund workflow is configured.');
    }
}
