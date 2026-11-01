<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Notification;
use App\Models\Product;
use App\Models\SellerProfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutOrderService
{
    public function customerDetailsFromRequest(Request $request): array
    {
        $validated = $request->validate([
            'address_id' => ['nullable', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:15', 'regex:/^[+\d][\d\s()-]{7,14}$/'],
            'address' => ['required', 'string'],
            'city' => ['nullable', 'string', 'max:255'],
            'pin_code' => ['required', 'digits:6'],
            'payment_method' => ['nullable', 'string', 'max:40'],

        ]);

        if (! empty($validated['address_id'])) {
            $savedAddress = \App\Models\CustomerAddress::whereKey($validated['address_id'])
                ->where('user_id', Auth::id())
                ->first();

            if (! $savedAddress) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'address_id' => 'The selected delivery address is invalid.',
                ]);
            }

            return [
                'name' => $validated['name'],
                'mobile' => $validated['mobile'],
                'address' => trim($savedAddress->address_line . ', ' . $savedAddress->city . ', ' . $savedAddress->state . ' - ' . $savedAddress->pincode . ', ' . $savedAddress->country),
                'city' => $savedAddress->city,

            ];
        }

        return [
            'name' => $validated['name'],
            'mobile' => $validated['mobile'],
            'address' => trim($validated['address'] . ', PIN: ' . $validated['pin_code']),
            'city' => $validated['city'] ?? 'N/A',

        ];
    }

    public function itemsBySellerForCurrentCheckout(): array
    {
        $itemsBySeller = [];
        $user = Auth::user();
        $buyProductId = session()->get('buy_product');

        if ($buyProductId) {
            $product = Product::find($buyProductId);
            if ($product) {
                $this->appendProduct($itemsBySeller, $product, 1);
            }

            return $itemsBySeller;
        }

        if ($user) {
            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

            foreach ($cartItems as $cartItem) {
                if ($cartItem->product) {
                    $this->appendProduct($itemsBySeller, $cartItem->product, max(1, (int) $cartItem->quantity));
                }
            }

            return $itemsBySeller;
        }

        foreach (session()->get('cart', []) as $id => $quantity) {
            $product = Product::find($id);
            if ($product) {
                $this->appendProduct($itemsBySeller, $product, max(1, (int) $quantity));
            }
        }

        return $itemsBySeller;
    }

    public function assertCheckoutCanProceed(array $itemsBySeller, ?string $paymentMethod = null): void
    {
        if ($itemsBySeller === []) {
            throw new \RuntimeException('Your cart is empty.');
        }

        if (array_key_exists(0, $itemsBySeller)) {
            throw new \RuntimeException('One or more products are not assigned to a seller and cannot be checked out.');
        }

        foreach ($itemsBySeller as $sellerId => $items) {
            $seller = SellerProfile::find($sellerId);
            if (! $seller || ! $seller->isStoreVisibleToCustomers()) {
                throw new \RuntimeException('A seller is currently unavailable. Please review your cart.');
            }
            if (strtoupper((string) $paymentMethod) === 'UPI'
                && (! $seller->isOnlinePaymentEnabled() || ! $seller->hasValidPaymentConfiguration())) {
                throw new \RuntimeException('A seller has not completed UPI payment setup. Choose Cash on Delivery or remove those products.');
            }
            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                if (! $product || ($product->status !== null && $product->status !== 'active') || (int) $product->seller_id !== (int) $sellerId || ($product->stock !== null && (int) $product->stock < (int) $item['quantity'])) {
                    throw new \RuntimeException('A product is no longer available. Please review your cart.');
                }
            }
        }

    }

    public function totalForItems(array $itemsBySeller): string
    {
        return $this->formatMinorUnits($this->totalForItemsInPaise($itemsBySeller));
    }

    public function totalForItemsInPaise(array $itemsBySeller): int
    {
        $total = 0;

        foreach ($itemsBySeller as $sellerId => $sellerItems) {
            foreach ($sellerItems as $item) {
                $total += $this->toMinorUnits($item['price']) * (int) $item['quantity'];
            }

            $seller = SellerProfile::find((int) $sellerId);
            if ($seller) {
                $total += $this->shippingAmountInPaise($seller, $sellerItems);
            }
        }

        return $total;
    }

    public function shippingAmountForSubtotal(SellerProfile $seller, float $subtotal): float
    {
        if (! $seller->preference('shipping_enabled', true)) {
            return 0.0;
        }

        $threshold = (float) $seller->preference('free_shipping_threshold', 0);
        if ($threshold > 0 && $subtotal >= $threshold) {
            return 0.0;
        }

        return (float) $seller->preference('delivery_charge', 0);
    }

    public function createConfirmedOrders(array $itemsBySeller, array $customerDetails, ?int $userId, string $paymentMethod, string $paymentStatus): array
    {
        return DB::transaction(function () use ($itemsBySeller, $customerDetails, $userId, $paymentMethod, $paymentStatus) {
            $orderIds = [];

            foreach ($itemsBySeller as $sellerId => $sellerItems) {
                $seller = SellerProfile::whereKey($sellerId)->lockForUpdate()->first();
                if (! $seller || ! $seller->isStoreVisibleToCustomers()) {
                    throw new \RuntimeException('A seller is currently unavailable. Please review your cart.');
                }
                $sellerTotalPaise = $this->totalForItemsInPaise([$sellerId => $sellerItems]);
                $sellerTotal = $this->formatMinorUnits($sellerTotalPaise);
                $shippingAmount = $this->formatMinorUnits($this->shippingAmountInPaise($seller, $sellerItems));

                foreach ($sellerItems as $item) {
                    $product = Product::lockForUpdate()->find($item['product_id']);
                    if (! $product || ($product->status !== null && $product->status !== 'active') || (int) $product->seller_id !== (int) $sellerId || ($product->stock !== null && (int) $product->stock < (int) $item['quantity'])) {
                        throw new \RuntimeException('A product is no longer available. Please review your cart.');
                    }
                }

                $order = Order::create([
                    'user_id' => $userId,
                    'seller_id' => $sellerId,
                    'name' => $customerDetails['name'],
                    'mobile' => $customerDetails['mobile'],
                    'address' => $customerDetails['address'],
                    'city' => $customerDetails['city'] ?? 'N/A',
                    'total' => $sellerTotal,
                    'amount' => $sellerTotal,
                    'status' => str_contains(strtolower($paymentMethod), 'upi') && strtolower($paymentStatus) !== 'paid'
                        ? 'Placed'
                        : 'Confirmed',
                    'payment_status' => $paymentStatus,
                    'payment_method' => $paymentMethod,
                    'order_status' => str_contains(strtolower($paymentMethod), 'upi') && strtolower($paymentStatus) !== 'paid'
                        ? 'Placed'
                        : ($seller->preference('auto_accept_orders', false) ? 'Confirmed' : 'Placed'),
                    'delivery_status' => 'Pending',
                    'shipping_amount' => $shippingAmount,
                    'estimated_delivery_days' => (int) $seller->preference('estimated_delivery_days', 3),
                    'items' => $sellerItems,

                ]);

                foreach ($sellerItems as $item) {
                    Product::whereKey($item['product_id'])->lockForUpdate()->decrement('stock', (int) $item['quantity']);
                }

                $orderIds[] = $order->id;


                // Funds are represented by an internal ledger; no money is sent to a
                // seller until an administrator explicitly records a payout.
                if (in_array(strtolower($paymentStatus), ['paid', 'successful', 'verified'], true)) {
                    \App\Models\SellerEarning::firstOrCreate(
                        ['seller_id' => $sellerId, 'order_id' => $order->id],
                        ['gross_amount' => $sellerTotal, 'platform_fee' => 0, 'net_amount' => $sellerTotal, 'status' => 'pending']
                    );
                }

                $orderIsCustomerConfirmed = strtoupper($paymentMethod) === 'COD'
                    || in_array(strtolower($paymentStatus), ['paid', 'successful', 'verified'], true);
                if ($userId && $orderIsCustomerConfirmed && $seller->preference('order_confirmation_notification', true)) {
                    $message = trim((string) $seller->preference('order_message', ''));
                    Notification::create([
                        'user_id' => $userId,
                        'role' => 'user',
                        'type' => 'order',
                        'title' => 'Order confirmed',
                        'message' => 'Your order #' . $order->id . ' has been confirmed.' . ($message !== '' ? ' ' . $message : ''),
                        'data' => ['order_id' => $order->id],
                    ]);
                }

                if ($orderIsCustomerConfirmed && $seller->notifications_enabled && $seller->preference('new_order_notification', true)) {
                    Notification::create([
                        'seller_id' => $sellerId,
                        'role' => 'seller',
                        'type' => 'order',
                        'title' => 'New order received',
                        'message' => 'Order #' . $order->id . ' is ready for processing.',
                        'data' => ['order_id' => $order->id],
                    ]);
                }
            }

            return $orderIds;
        });
    }

    public function clearCurrentCheckout(?int $userId): void
    {
        if ($userId) {
            Cart::where('user_id', $userId)->delete();
        }

        session()->forget('cart');
        session()->forget('buy_product');
        session()->forget('checkout_payment_nonce');
    }

    private function appendProduct(array &$itemsBySeller, Product $product, int $quantity): void
    {
        $itemsBySeller[(int) $product->seller_id][] = [
            'product_id' => $product->id,
            'seller_id' => $product->seller_id,
            'name' => $product->name,
            'quantity' => $quantity,
            'price' => $this->effectivePriceAsDecimal($product),
        ];
    }

    private function shippingAmountInPaise(SellerProfile $seller, array $items): int
    {
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $this->toMinorUnits((string) $item['price']) * (int) $item['quantity'];
        }

        $shipping = $this->shippingAmountForSubtotal($seller, $subtotal / 100);

        return $this->toMinorUnits(number_format($shipping, 2, '.', ''));
    }

    private function effectivePriceAsDecimal(Product $product): string
    {
        return number_format((float) $product->effective_price, 2, '.', '');
    }

    private function toMinorUnits(string|int|float $amount): int
    {
        $decimal = is_float($amount) ? number_format($amount, 2, '.', '') : (string) $amount;

        if (! preg_match('/^(\d+)(?:\.(\d{1,2}))?$/', $decimal, $matches)) {
            throw new \InvalidArgumentException('Payment amounts must be non-negative values with at most two decimal places.');
        }

        return ((int) $matches[1] * 100) + (int) str_pad($matches[2] ?? '', 2, '0');
    }

    private function formatMinorUnits(int $amount): string
    {
        return intdiv($amount, 100) . '.' . str_pad((string) ($amount % 100), 2, '0', STR_PAD_LEFT);
    }
}
