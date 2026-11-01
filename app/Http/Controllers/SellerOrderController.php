<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPartner;
use App\Models\Order;
use App\Models\OrderDeliveryDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SellerOrderController extends Controller
{
    public function index()
    {
        if (! session('seller_login')) {
            return redirect('/seller-login');
        }

        $sellerId = (int) session('seller_id');
        $sellerProductIds = Product::where('seller_id', $sellerId)->pluck('id');
        $orders = Order::forSeller($sellerId)
            ->with('deliveryDetail.deliveryPartner')
            ->latest()
            ->get();
        $this->attachSellerItems($orders, $sellerProductIds);
        $products = Product::whereIn('id', $sellerProductIds)->get()->keyBy('id');
        $deliveryPartners = DeliveryPartner::where('seller_id', $sellerId)->orderBy('name')->get();

        return view('seller.orders.index', compact('orders', 'products', 'deliveryPartners'));
    }

    public function show(Order $order)
    {
        if (! session('seller_login')) {
            return redirect('/seller-login');
        }

        $sellerId = (int) session('seller_id');
        $sellerProductIds = Product::where('seller_id', $sellerId)->pluck('id');
        $order = Order::forSeller($sellerId)->whereKey($order->id)->firstOrFail();
        $order->load('deliveryDetail.deliveryPartner');
        $this->attachSellerItems(collect([$order]), $sellerProductIds);
        $products = Product::whereIn('id', $sellerProductIds)->get()->keyBy('id');
        if ($order->deliveryDetail?->deliveryPartner && ! $order->deliveryDetail->deliveryPartner->seller_id) {
            $order->deliveryDetail->deliveryPartner->update(['seller_id' => $sellerId]);
        }
        $deliveryPartners = DeliveryPartner::where('seller_id', $sellerId)->orderBy('name')->get();
        $lastHandoff = $order->deliveryDetail
            ? DB::table('delivery_partner_order_notifications')->where('delivery_detail_id', $order->deliveryDetail->id)->latest('id')->first()
            : null;

        return view('seller.orders.show', compact('order', 'products', 'deliveryPartners', 'lastHandoff'));
    }

    /** Assign an existing seller-owned delivery profile to an order. */
    public function storeDelivery(Request $request, Order $order)
    {
        if (! session('seller_login')) {
            return redirect('/seller-login');
        }

        $this->ensureSellerOwnsOrder($order);

        $validated = $request->validate([
            'delivery_partner_id' => ['required', 'integer', 'exists:delivery_partners,id'],
        ]);
        $partner = DeliveryPartner::where('seller_id', (int) session('seller_id'))->findOrFail($validated['delivery_partner_id']);
        $previousDetail = $order->deliveryDetail;
        $samePartner = $previousDetail && (int) $previousDetail->delivery_partner_id === (int) $partner->id;
        if ($previousDetail && ! $samePartner) {
            DB::table('delivery_partner_order_notifications')->where('delivery_detail_id', $previousDetail->id)->delete();
        }
        OrderDeliveryDetail::updateOrCreate(
            ['order_id' => $order->id],
            [
                'delivery_partner_id' => $partner->id,
                'status'              => $samePartner ? $previousDetail->status : 'Order Placed',
                'assigned_at'         => $samePartner ? ($previousDetail->assigned_at ?? now()) : now(),
                'tracking_token'      => $samePartner ? ($previousDetail->tracking_token ?: Str::random(48)) : Str::random(48),
                'latitude'            => $samePartner ? $previousDetail->latitude : null,
                'longitude'           => $samePartner ? $previousDetail->longitude : null,
                'location_updated_at' => $samePartner ? $previousDetail->location_updated_at : null,
                'delivery_scan_code'  => $samePartner ? $previousDetail->delivery_scan_code : null,
                'delivered_at'         => $samePartner ? $previousDetail->delivered_at : null,
            ]
        );
        $order->update(['delivery_status' => $samePartner ? $previousDetail->status : 'Order Placed']);

        return redirect()->route('seller.orders.show', $order)->with('success', 'Delivery information saved. Review the order details below, then send the order to the delivery partner.');
    }

    /** Send a saved order assignment to the delivery partner app. */
    public function notifyDeliveryPartner(Order $order)
    {
        if (! session('seller_login')) {
            return redirect('/seller-login');
        }

        $this->ensureSellerOwnsOrder($order);
        $detail = $order->deliveryDetail()->with('deliveryPartner')->firstOrFail();
        abort_unless((int) $detail->deliveryPartner?->seller_id === (int) session('seller_id'), 404);
        abort_if(in_array(strtolower((string) $detail->status), ['delivered', 'cancelled'], true), 422, 'A completed order cannot be sent to a delivery partner.');

        DB::table('delivery_partner_order_notifications')->insert([
            'delivery_detail_id' => $detail->id,
            'delivery_partner_id' => $detail->delivery_partner_id,
            'order_id' => $order->id,
            'created_at' => now(),
        ]);

        return redirect()->route('seller.orders.show', $order)->with('success', 'Order #' . $order->id . ' sent to ' . $detail->deliveryPartner->name . '. Their delivery app will show the new order alert.');
    }

    /**
     * Update the delivery boy details for an order.
     */
    public function updateDelivery(Request $request, Order $order)
    {
        return $this->storeDelivery($request, $order);
    }

    /**
     * Delete the delivery details associated with an order.
     */
    public function destroyDelivery(Order $order)
    {
        if (! session('seller_login')) {
            return redirect('/seller-login');
        }

        $this->ensureSellerOwnsOrder($order);

        $detail = $order->deliveryDetail;

        if (! $detail) {
            return redirect()->route('seller.orders.index')->with('error', 'No delivery details found for this order.');
        }

        $detail->delete();

        return redirect()->route('seller.orders.index')->with('success', 'Order assignment removed. The saved delivery boy profile was kept.');
    }

    /** Supply only the seller-owned portion of each mixed-seller order to Blade. */
    private function attachSellerItems($orders, $sellerProductIds): void
    {
        $ownedProductIds = $sellerProductIds->map(fn ($id) => (int) $id)->all();

        foreach ($orders as $order) {
            $order->setAttribute('seller_items', collect($order->items ?? [])
                ->filter(fn ($item) => (int) ($item['seller_id'] ?? 0) === (int) session('seller_id') || in_array((int) ($item['product_id'] ?? 0), $ownedProductIds, true))
                ->values()
                ->all());
        }
    }

    /** Block direct order and delivery URLs that belong to another seller. */
    private function ensureSellerOwnsOrder(Order $order): void
    {
        $sellerId = (int) session('seller_id');
        abort_unless(Order::forSeller($sellerId)->whereKey($order->id)->exists(), 404);
    }
}
