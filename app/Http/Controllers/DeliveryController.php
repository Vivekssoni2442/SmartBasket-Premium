<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPartner;
use App\Models\Order;
use App\Models\OrderDeliveryDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{
    public function assign(Request $request, Order $order)
    {
        if (! session('seller_login')) {
            return redirect('/seller-login');
        }

        abort_unless($order->belongsToSeller((int) session('seller_id')), 404);

        $validated = $request->validate([
            'delivery_partner_id' => 'nullable|exists:delivery_partners,id',
            'name' => 'required_without:delivery_partner_id|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'phone' => 'required_without:delivery_partner_id|string|max:30',
            'vehicle_number' => 'required_without:delivery_partner_id|string|max:100',
            'vehicle_type' => 'nullable|in:Bike,Activa,Jeep',
            'current_location' => 'nullable|string|max:255',
            'status' => 'required|in:Order Placed,Seller Confirmed,Packed,Picked By Delivery Partner,Out For Delivery,Near Customer,Delivered',
        ]);

        $partner = ! empty($validated['delivery_partner_id'])
            ? DeliveryPartner::findOrFail($validated['delivery_partner_id'])
            : new DeliveryPartner();

        abort_unless(! $partner->seller_id || (int) $partner->seller_id === (int) session('seller_id'), 404);
        $partner->seller_id = (int) session('seller_id');

        if (! $partner->exists) {
            $partner->fill([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'vehicle_number' => $validated['vehicle_number'],
            ]);
        }

        if (! empty($validated['vehicle_type'])) {
            $partner->vehicle_type = $validated['vehicle_type'];
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            File::ensureDirectoryExists(public_path('delivery-partners'));
            $request->file('image')->move(public_path('delivery-partners'), $imageName);
            $partner->image = $imageName;
        }

        if (! empty($validated['current_location'])) {
            $partner->current_location = $validated['current_location'];
        }
        $partner->save();

        $previousDelivery = $order->deliveryDetail;
        $trackingToken = $previousDelivery
            && (int) $previousDelivery->delivery_partner_id === (int) $partner->id
            ? ($previousDelivery->tracking_token ?: Str::random(48))
            : Str::random(48);

        OrderDeliveryDetail::updateOrCreate(
            ['order_id' => $order->id],
            [
                'delivery_partner_id' => $partner->id,
                'status' => $validated['status'],
                'current_location' => $validated['current_location'] ?? $partner->current_location,
                'assigned_at' => now(),
                'tracking_token' => $trackingToken,
            ]
        );

        return redirect()->route('seller.orders.show', $order)->with('success', 'Delivery partner assigned successfully.');
    }

    public function liveShare(string $token)
    {
        $detail = OrderDeliveryDetail::where('tracking_token', $token)->with('deliveryPartner')->firstOrFail();
        abort_if(in_array(strtolower((string) $detail->status), ['delivered', 'cancelled'], true), 410, 'This delivery tracking session has ended.');
        return view('delivery.live-share', compact('detail', 'token'));
    }

    public function updateLiveLocation(Request $request, string $token)
    {
        $detail = OrderDeliveryDetail::where('tracking_token', $token)->firstOrFail();
        abort_if(in_array(strtolower((string) $detail->status), ['delivered', 'cancelled'], true), 410);
        $validated = $request->validate(['latitude' => ['required', 'numeric', 'between:-90,90'], 'longitude' => ['required', 'numeric', 'between:-180,180'], 'accuracy' => ['nullable', 'numeric', 'min:0', 'max:10000']]);
        $detail->update(['latitude' => $validated['latitude'], 'longitude' => $validated['longitude'], 'location_updated_at' => now()]);
        return response()->json(['ok' => true, 'updated_at' => $detail->location_updated_at->toIso8601String()]);
    }

    public function customerLocation(Order $order)
    {
        abort_unless((int) $order->user_id === (int) auth()->id(), 404);
        $detail = $order->deliveryDetail()->with('deliveryPartner')->first();
        $ended = $detail && in_array(strtolower((string) $detail->status), ['delivered', 'cancelled'], true);
        return response()->json([
            'available' => $detail && ! $ended && $detail->latitude !== null && $detail->longitude !== null,
            'latitude' => $ended ? null : $detail?->latitude,
            'longitude' => $ended ? null : $detail?->longitude,
            'updated_at' => $ended ? null : $detail?->location_updated_at?->toIso8601String(),
            'status' => $detail?->status,
            'vehicle_type' => $detail?->deliveryPartner?->vehicle_type,
        ]);
    }

    public function driverPortal(string $token)
    {
        $partner = DeliveryPartner::where('portal_token', $token)->firstOrFail();
        $notificationCursor = DB::table('delivery_partner_order_notifications')->where('delivery_partner_id', $partner->id)->max('id') ?? 0;
        $allDeliveries = $partner->deliveryDetails()
            ->with('order.user')
            ->whereExists(function ($query) use ($partner) {
                $query->selectRaw('1')
                    ->from('delivery_partner_order_notifications')
                    ->whereColumn('delivery_partner_order_notifications.delivery_detail_id', 'order_delivery_details.id')
                    ->where('delivery_partner_order_notifications.delivery_partner_id', $partner->id);
            })
            ->latest('assigned_at')
            ->get();
        $activeDeliveries = $allDeliveries->filter(fn ($delivery) => ! in_array(strtolower((string) $delivery->status), ['delivered', 'cancelled'], true))->values();
        $completedDeliveries = $allDeliveries->filter(fn ($delivery) => in_array(strtolower((string) $delivery->status), ['delivered', 'cancelled'], true))->values();
        $productIds = $allDeliveries->flatMap(fn ($delivery) => collect($delivery->order?->items ?? [])->pluck('product_id'))->filter()->unique();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $allDeliveries->each(function ($delivery) use ($products) {
            $items = collect($delivery->order?->items ?? [])->map(function ($item) use ($products) {
                $product = $products->get($item['product_id'] ?? null);
                $item['image_url'] = $product?->image ? asset('products/' . $product->image) : null;
                return $item;
            });
            $delivery->setAttribute('driver_items', $items);
        });
        $completedCount = $completedDeliveries->where('status', 'Delivered')->count();

        return response()
            ->view('delivery.driver-app', compact('partner', 'activeDeliveries', 'completedDeliveries', 'completedCount', 'notificationCursor', 'token'))
            ->header('Cache-Control', 'private, no-store, no-cache, must-revalidate');
    }

    public function driverNotifications(Request $request, string $token)
    {
        $partner = DeliveryPartner::where('portal_token', $token)->firstOrFail();
        $validated = $request->validate(['after' => ['nullable', 'integer', 'min:0']]);
        $rows = DB::table('delivery_partner_order_notifications as notifications')
            ->join('order_delivery_details as details', 'details.id', '=', 'notifications.delivery_detail_id')
            ->join('orders', 'orders.id', '=', 'notifications.order_id')
            ->where('notifications.delivery_partner_id', $partner->id)
            ->where('notifications.id', '>', (int) ($validated['after'] ?? 0))
            ->where('details.delivery_partner_id', $partner->id)
            ->orderBy('notifications.id')
            ->limit(25)
            ->get([
                'notifications.id',
                'notifications.delivery_detail_id',
                'notifications.created_at',
                'orders.id as order_id',
                'orders.name as customer_name',
                'orders.mobile as customer_mobile',
                'orders.address as customer_address',
                'details.status',
            ]);

        $deliveries = OrderDeliveryDetail::with('order.user')
            ->where('delivery_partner_id', $partner->id)
            ->whereIn('id', $rows->pluck('delivery_detail_id'))
            ->get()
            ->keyBy('id');
        $productIds = $deliveries->flatMap(fn ($delivery) => collect($delivery->order?->items ?? [])->pluck('product_id'))->filter()->unique();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $deliveries->each(function ($delivery) use ($products) {
            $items = collect($delivery->order?->items ?? [])->map(function ($item) use ($products) {
                $product = $products->get($item['product_id'] ?? null);
                $item['image_url'] = $product?->image ? asset('products/' . $product->image) : null;

                return $item;
            });
            $delivery->setAttribute('driver_items', $items);
        });

        $notifications = $rows->map(function ($notification) use ($deliveries, $token) {
            $delivery = $deliveries->get($notification->delivery_detail_id);
            $notification->card_html = $delivery
                ? view('delivery.partials.driver-order-card', [
                    'delivery' => $delivery,
                    'token' => $token,
                    'completed' => false,
                ])->render()
                : null;

            return $notification;
        });

        return response()->json([
            'notifications' => $notifications,
            'cursor' => $notifications->max('id') ?? (int) ($validated['after'] ?? 0),
        ]);
    }

    public function driverManifest(string $token)
    {
        DeliveryPartner::where('portal_token', $token)->firstOrFail();
        $driverStartUrl = route('delivery.driver', $token, false);

        return response()->json([
            'id' => $driverStartUrl,
            'name' => 'Smart Basket Delivery Partner',
            'short_name' => 'SB Delivery',
            'description' => 'Assigned delivery orders, customer details, route navigation and live location sharing.',
            'start_url' => $driverStartUrl,
            'scope' => $driverStartUrl,
            'display' => 'standalone',
            'orientation' => 'portrait',
            'background_color' => '#f5f7fb',
            'theme_color' => '#112c66',
            'icons' => [
                [
                    'src' => asset('images/delivery-partner-icon-192.png'),
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'purpose' => 'any',
                ],
                [
                    'src' => asset('images/delivery-partner-icon-512.png'),
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'any maskable',
                ],
                [
                    'src' => asset('images/delivery-partner-icon.svg'),
                    'sizes' => 'any',
                    'type' => 'image/svg+xml',
                    'purpose' => 'any',
                ],
            ],
        ])->header('Content-Type', 'application/manifest+json')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    public function updatePartnerLocation(Request $request, string $token)
    {
        $partner = DeliveryPartner::where('portal_token', $token)->firstOrFail();
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'accuracy' => ['nullable', 'numeric', 'min:0', 'max:10000'],
        ]);

        $active = $partner->deliveryDetails()
            ->whereNotIn(DB::raw('LOWER(status)'), ['delivered', 'cancelled'])
            ->whereExists(function ($query) use ($partner) {
                $query->selectRaw('1')
                    ->from('delivery_partner_order_notifications')
                    ->whereColumn('delivery_partner_order_notifications.delivery_detail_id', 'order_delivery_details.id')
                    ->where('delivery_partner_order_notifications.delivery_partner_id', $partner->id);
            });
        abort_if(! $active->exists(), 410, 'There are no active deliveries assigned to this account.');
        $updatedAt = now();
        $active->update([
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'location_updated_at' => $updatedAt,
            'current_location' => number_format((float) $validated['latitude'], 5) . ', ' . number_format((float) $validated['longitude'], 5),
        ]);
        $partner->update(['current_location' => number_format((float) $validated['latitude'], 5) . ', ' . number_format((float) $validated['longitude'], 5)]);

        return response()->json(['ok' => true, 'updated_at' => $updatedAt->toIso8601String(), 'active_deliveries' => $active->count()]);
    }

    public function updatePartnerOrderStatus(Request $request, string $token, Order $order)
    {
        $partner = DeliveryPartner::where('portal_token', $token)->firstOrFail();
        $detail = OrderDeliveryDetail::where('order_id', $order->id)
            ->where('delivery_partner_id', $partner->id)
            ->whereExists(function ($query) use ($partner) {
                $query->selectRaw('1')
                    ->from('delivery_partner_order_notifications')
                    ->whereColumn('delivery_partner_order_notifications.delivery_detail_id', 'order_delivery_details.id')
                    ->where('delivery_partner_order_notifications.delivery_partner_id', $partner->id);
            })
            ->firstOrFail();
        $validated = $request->validate([
            'status' => ['required', 'in:Order Placed,Seller Confirmed,Packed,Picked By Delivery Partner,Out For Delivery,Near Customer,Delivered'],
            'delivery_scan_code' => ['required_if:status,Delivered', 'nullable', 'string', 'max:255'],
        ]);

        $current = strtolower(trim((string) $detail->status));
        $next = $validated['status'];
        $stages = ['order placed', 'seller confirmed', 'packed', 'picked by delivery partner', 'out for delivery', 'near customer', 'delivered'];
        $currentIndex = array_search($current, $stages, true);
        $nextIndex = array_search(strtolower($next), $stages, true);
        abort_unless($currentIndex !== false && $nextIndex !== false && $nextIndex > $currentIndex, 422, 'Choose a delivery stage after the current stage.');

        $detail->update([
            'status' => $next,
            'delivery_scan_code' => $next === 'Delivered' ? trim($validated['delivery_scan_code']) : $detail->delivery_scan_code,
            'delivered_at' => $next === 'Delivered' ? now() : $detail->delivered_at,
        ]);
        $order->update(['delivery_status' => $next]);

        return back()->with('status', 'Order #' . $order->id . ' updated to ' . $next . '.');
    }

    public function sellerLocation(Order $order)
    {
        abort_unless(session('seller_login'), 403);
        abort_unless($order->belongsToSeller((int) session('seller_id')), 404);

        return $this->locationResponse($order);
    }

    public function adminLocation(Order $order)
    {
        abort_unless(session('admin_id'), 403);

        return $this->locationResponse($order);
    }

    public function adminDeliveryIndex()
    {
        abort_unless(session('admin_id'), 403);
        $activeDeliveryCount = OrderDeliveryDetail::whereNotIn(DB::raw('LOWER(status)'), ['delivered', 'cancelled'])->count();
        $deliveries = OrderDeliveryDetail::with(['order.user', 'deliveryPartner'])
            ->where(function ($query) {
                $query->whereNotIn(DB::raw('LOWER(status)'), ['delivered', 'cancelled'])
                    ->orWhere(function ($completed) {
                        $completed->where('status', 'Delivered')->where('delivered_at', '>=', now()->subDay());
                    });
            })
            ->latest('updated_at')
            ->paginate(30);

        return view('admin.deliveries.index', compact('deliveries', 'activeDeliveryCount'));
    }

    private function locationResponse(Order $order)
    {
        $detail = $order->deliveryDetail()->with('deliveryPartner')->first();
        $ended = $detail && in_array(strtolower((string) $detail->status), ['delivered', 'cancelled'], true);

        return response()->json([
            'available' => $detail && ! $ended && $detail->latitude !== null && $detail->longitude !== null,
            'latitude' => $ended ? null : $detail?->latitude,
            'longitude' => $ended ? null : $detail?->longitude,
            'updated_at' => $ended ? null : $detail?->location_updated_at?->toIso8601String(),
            'status' => $detail?->status,
            'driver' => $detail?->deliveryPartner?->name,
            'vehicle_type' => $detail?->deliveryPartner?->vehicle_type,
            'delivery_scan_code' => $detail?->delivery_scan_code,
            'delivered_at' => $detail?->delivered_at?->toIso8601String(),
        ]);
    }
}
