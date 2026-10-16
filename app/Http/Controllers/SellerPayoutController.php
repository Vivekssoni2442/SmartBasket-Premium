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
            $earnings = SellerEarning::where('seller_id', $sellerId)
                ->where('status', 'available')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();
            $availablePaise = $earnings->sum(fn ($earning) => $this->toPaise((string) $earning->net_amount));
            $requestedPaise = $this->toPaise((string) $validated['amount']);
            if ($requestedPaise !== $availablePaise || $availablePaise === 0) {
                abort(422, 'For audit-safe ledger settlement, request your full available balance.');
            }

            $payout = SellerPayout::create([
                'seller_id' => $sellerId,
                'amount' => $this->formatPaise($requestedPaise),
                'seller_note' => $validated['seller_note'] ?? null,
            ]);
            $payout->earnings()->attach($earnings->mapWithKeys(
                fn ($earning) => [$earning->id => ['amount' => $earning->net_amount]]
            )->all());
            SellerEarning::whereKey($earnings->modelKeys())->update(['status' => 'payout_requested']);
        });

        return back()->with('success', 'Payout request submitted for admin review.');
    }

    private function toPaise(string $amount): int
    {
        if (! preg_match('/^(\d+)(?:\.(\d{1,2}))?$/', $amount, $matches)) {
            abort(422, 'Payout amounts must use INR with no more than two decimal places.');
        }

        return ((int) $matches[1] * 100) + (int) str_pad($matches[2] ?? '', 2, '0');
    }

    private function formatPaise(int $amount): string
    {
        return intdiv($amount, 100) . '.' . str_pad((string) ($amount % 100), 2, '0', STR_PAD_LEFT);
    }
}
