<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPartner;
use App\Models\Order;
use App\Models\OrderDeliveryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
            'current_location' => 'nullable|string|max:255',
            'status' => 'required|in:Order Placed,Seller Confirmed,Packed,Picked By Delivery Partner,Out For Delivery,Near Customer,Delivered',
        ]);

        $partner = ! empty($validated['delivery_partner_id'])
            ? DeliveryPartner::findOrFail($validated['delivery_partner_id'])
            : new DeliveryPartner();

        if (! $partner->exists) {
            $partner->fill([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'vehicle_number' => $validated['vehicle_number'],
            ]);
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

        OrderDeliveryDetail::updateOrCreate(
            ['order_id' => $order->id],
            [
                'delivery_partner_id' => $partner->id,
                'status' => $validated['status'],
                'current_location' => $validated['current_location'] ?? $partner->current_location,
                'assigned_at' => now(),
            ]
        );

        return redirect()->route('seller.orders.show', $order)->with('success', 'Delivery partner assigned successfully.');
    }
}
