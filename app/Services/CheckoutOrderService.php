<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
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
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string'],
            'city' => ['nullable', 'string', 'max:255'],
            'payment_method' => ['nullable', 'string', 'max:40'],
        ]);

        return [
            'name' => $validated['name'],
            'mobile' => $validated['mobile'],
            'address' => $validated['address'],
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

    public function assertCheckoutCanProceed(array $itemsBySeller, string $paymentMethod): void
    {
        if ($itemsBySeller === []) {
            throw new \RuntimeException('Your cart is empty.');
        }

        if (array_key_exists(0, $itemsBySeller)) {
            throw new \RuntimeException('One or more products are not assigned to a seller and cannot be checked out.');
        }

        foreach ($itemsBySeller as $sellerId => $items) {
            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                if (! $product || (int) $product->seller_id !== (int) $sellerId || ($product->stock !== null && (int) $product->stock < (int) $item['quantity'])) {
                    throw new \RuntimeException('A product is no longer available. Please review your cart.');
                }
            }
        }

        if ($this->isOnlineMethod($paymentMethod)
            && SellerProfile::whereIn('id', array_keys($itemsBySeller))->where('online_payments_enabled', true)->count() !== count($itemsBySeller)) {
            throw new \RuntimeException('Online payment is not enabled by every seller in this checkout.');
        }
    }

    public function isOnlineMethod(string $paymentMethod): bool
    {
        return in_array($paymentMethod, ['Card', 'UPI', 'Google Pay', 'PhonePe', 'Net Banking'], true);
    }

    public function totalForItems(array $itemsBySeller): float
    {
        return round(collect($itemsBySeller)->flatten(1)->sum(
            fn (array $item) => (float) $item['price'] * (int) $item['quantity']
        ), 2);
    }

    public function createConfirmedOrders(array $itemsBySeller, array $customerDetails, ?int $userId, string $paymentMethod, string $paymentStatus): array
    {
        return DB::transaction(function () use ($itemsBySeller, $customerDetails, $userId, $paymentMethod, $paymentStatus) {
            $orderIds = [];

            foreach ($itemsBySeller as $sellerId => $sellerItems) {
                $sellerTotal = round(collect($sellerItems)->sum(
                    fn (array $item) => (float) $item['price'] * (int) $item['quantity']
                ), 2);

                foreach ($sellerItems as $item) {
                    $product = Product::lockForUpdate()->find($item['product_id']);
                    if (! $product || (int) $product->seller_id !== (int) $sellerId || ($product->stock !== null && (int) $product->stock < (int) $item['quantity'])) {
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
                    'status' => 'Confirmed',
                    'payment_status' => $paymentStatus,
                    'payment_method' => $paymentMethod,
                    'order_status' => 'Placed',
                    'delivery_status' => 'Pending',
                    'items' => $sellerItems,
                ]);

                foreach ($sellerItems as $item) {
                    Product::whereKey($item['product_id'])->lockForUpdate()->decrement('stock', (int) $item['quantity']);
                }

                $orderIds[] = $order->id;
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
    }

    private function appendProduct(array &$itemsBySeller, Product $product, int $quantity): void
    {
        $itemsBySeller[(int) $product->seller_id][] = [
            'product_id' => $product->id,
            'seller_id' => $product->seller_id,
            'name' => $product->name,
            'quantity' => $quantity,
            'price' => (float) $product->price,
        ];
    }
}
