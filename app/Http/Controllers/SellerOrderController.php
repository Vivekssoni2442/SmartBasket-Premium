<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPartner;
use App\Models\Order;
use App\Models\OrderDeliveryDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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

        return view('seller.orders.index', compact('orders', 'products'));
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
        $deliveryPartners = DeliveryPartner::latest()->get();

        return view('seller.orders.show', compact('order', 'products', 'deliveryPartners'));
    }

    /**
     * Store (create or update) the delivery boy details for an order.
     */
    public function storeDelivery(Request $request, Order $order)
    {
        if (! session('seller_login')) {
            return redirect('/seller-login');
        }

        $this->ensureSellerOwnsOrder($order);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'phone'            => 'required|string|max:30',
            'email'            => 'nullable|email|max:255',
            'vehicle_type'     => 'nullable|string|max:100',
            'vehicle_number'   => 'nullable|string|max:100',
            'delivery_date'    => 'nullable|date',
            'expected_time'    => 'nullable|string|max:100',
            'notes'            => 'nullable|string|max:1000',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'           => 'nullable|in:Order Placed,Seller Confirmed,Packed,Picked By Delivery Partner,Out For Delivery,Near Customer,Delivered',
        ]);

        $partner = $order->deliveryDetail?->deliveryPartner ?? new DeliveryPartner();

        $partner->fill([
            'name'           => $validated['name'],
            'phone'          => $validated['phone'],
            'email'          => $validated['email'] ?? null,
            'vehicle_type'   => $validated['vehicle_type'] ?? null,
            'vehicle_number' => $validated['vehicle_number'] ?? null,
            'delivery_date'  => $validated['delivery_date'] ?? null,
            'expected_time'  => $validated['expected_time'] ?? null,
            'notes'          => $validated['notes'] ?? null,
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            File::ensureDirectoryExists(public_path('delivery-partners'));
            $request->file('image')->move(public_path('delivery-partners'), $imageName);
            $partner->image = $imageName;
        }

        $partner->save();

        OrderDeliveryDetail::updateOrCreate(
            ['order_id' => $order->id],
            [
                'delivery_partner_id' => $partner->id,
                'status'              => $validated['status'] ?? ($order->deliveryDetail?->status ?? 'Order Placed'),
                'assigned_at'         => $order->deliveryDetail?->assigned_at ?? now(),
            ]
        );

        return redirect()->route('seller.orders.index')->with('success', 'Delivery boy details saved successfully.');
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

        $partner = $detail->deliveryPartner;
        $detail->delete();

        // Remove the orphaned delivery partner if it is not linked to any other order.
        if ($partner && $partner->deliveryDetails()->count() === 0) {
            $partner->delete();
        }

        return redirect()->route('seller.orders.index')->with('success', 'Delivery details deleted successfully.');
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
