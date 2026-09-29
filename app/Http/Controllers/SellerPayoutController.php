<?php

namespace App\Http\Controllers;

use App\Models\SellerEarning;
use App\Models\SellerPayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerPayoutController extends Controller
{
    public function index()
    {
        $sellerId = (int) session('seller_id');
        $earnings = SellerEarning::where('seller_id', $sellerId)->latest()->get();

        return view('seller.payouts.index', [
            'earnings' => $earnings,
            'payouts' => SellerPayout::where('seller_id', $sellerId)->latest()->get(),
            'availableBalance' => (float) $earnings->where('status', 'available')->sum('net_amount'),
            'pendingBalance' => (float) $earnings->where('status', 'pending')->sum('net_amount'),
        ]);
    }

    public function request(Request $request)
    {
        $sellerId = (int) session('seller_id');
        $validated = $request->validate(['amount' => ['required', 'numeric', 'min:1'], 'seller_note' => ['nullable', 'string', 'max:1000']]);

        DB::transaction(function () use ($sellerId, $validated) {
            $available = (float) SellerEarning::where('seller_id', $sellerId)->where('status', 'available')->lockForUpdate()->sum('net_amount');
            $requested = round((float) $validated['amount'], 2);
            if (abs($requested - $available) > 0.009) abort(422, 'For audit-safe ledger settlement, request your full available balance.');

            SellerPayout::create(['seller_id' => $sellerId, 'amount' => $requested, 'seller_note' => $validated['seller_note'] ?? null]);
        });

        return back()->with('success', 'Payout request submitted for admin review.');
    }
}
