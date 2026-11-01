<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SellerDeliveryPartnerController extends Controller
{
    public function index()
    {
        $sellerId = (int) session('seller_id');
        $partners = DeliveryPartner::where('seller_id', $sellerId)
            ->withCount(['deliveryDetails as active_deliveries_count' => fn ($query) => $query->whereNotIn('status', ['Delivered', 'Cancelled'])])
            ->withCount('deliveryDetails')
            ->latest()
            ->get();

        return view('seller.delivery-boys.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProfile($request);
        $partner = new DeliveryPartner();
        $partner->seller_id = (int) session('seller_id');
        $partner->fill(collect($validated)->except('image')->all());
        $this->savePhoto($request, $partner);
        $partner->save();

        return redirect()->route('seller.delivery-boys.index')->with('success', 'Delivery boy profile saved. It is now available in your order assignment list.');
    }

    public function update(Request $request, DeliveryPartner $partner)
    {
        abort_unless((int) $partner->seller_id === (int) session('seller_id'), 404);
        $validated = $this->validateProfile($request);
        $partner->fill(collect($validated)->except('image')->all());
        $this->savePhoto($request, $partner);
        $partner->save();

        return redirect()->route('seller.delivery-boys.index')->with('success', 'Delivery boy profile updated.');
    }

    private function validateProfile(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'vehicle_type' => ['nullable', 'in:Bike,Activa,Jeep'],
            'vehicle_number' => ['nullable', 'string', 'max:100'],
            'delivery_date' => ['nullable', 'date'],
            'expected_time' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);
    }

    private function savePhoto(Request $request, DeliveryPartner $partner): void
    {
        if (! $request->hasFile('image')) {
            return;
        }

        File::ensureDirectoryExists(public_path('delivery-partners'));
        $imageName = 'driver_' . uniqid() . '.' . $request->file('image')->extension();
        $request->file('image')->move(public_path('delivery-partners'), $imageName);
        $partner->image = $imageName;
    }
}
