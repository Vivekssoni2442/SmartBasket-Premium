<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerAddressController extends Controller
{
    public function index() { return view('addresses.index', ['addresses' => Auth::user()->addresses()->latest('is_default')->latest()->get()]); }

    public function store(Request $request) { $address = Auth::user()->addresses()->create($this->validated($request)); $this->makeDefaultIfFirst($address); return back()->with('success', 'Address saved.'); }
    public function update(Request $request, CustomerAddress $address) { $this->authorizeAddress($address); $address->update($this->validated($request)); if ($address->is_default) $this->setDefault($address); return back()->with('success', 'Address updated.'); }
    public function destroy(CustomerAddress $address) { $this->authorizeAddress($address); $wasDefault = $address->is_default; $address->delete(); if ($wasDefault && ($fallback = Auth::user()->addresses()->oldest()->first())) $this->setDefault($fallback); return back()->with('success', 'Address removed.'); }
    public function makeDefault(CustomerAddress $address) { $this->authorizeAddress($address); $this->setDefault($address); return back()->with('success', 'Default address updated.'); }

    private function validated(Request $request): array { return $request->validate(['label' => ['required','string','max:50'], 'recipient_name' => ['required','string','max:255'], 'phone' => ['required','string','max:20'], 'address_line' => ['required','string','max:1000'], 'city' => ['required','string','max:255'], 'state' => ['required','string','max:255'], 'pincode' => ['required','string','max:20'], 'country' => ['required','string','max:100'], 'is_default' => ['nullable','boolean']]); }
    private function authorizeAddress(CustomerAddress $address): void { abort_unless($address->user_id === Auth::id(), 403); }
    private function makeDefaultIfFirst(CustomerAddress $address): void { if ($address->is_default || Auth::user()->addresses()->count() === 1) $this->setDefault($address); }
    private function setDefault(CustomerAddress $address): void { DB::transaction(function () use ($address) { CustomerAddress::where('user_id', Auth::id())->update(['is_default' => false]); $address->update(['is_default' => true]); }); }
}
