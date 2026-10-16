<?php

namespace App\Http\Controllers;

use App\Models\AdminAuditLog;
use App\Models\SellerEarning;
use App\Models\SellerPayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPayoutController extends Controller
{
    public function index(Request $request)
    {
        $payouts = SellerPayout::with('seller')->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))->latest()->paginate(25)->withQueryString();
        return view('admin.payouts.index', compact('payouts'));
    }

    public function update(Request $request, SellerPayout $payout)
    {
        $data = $request->validate(['status' => ['required', 'in:approved,rejected,paid'], 'reference' => ['nullable', 'string', 'max:255'], 'admin_note' => ['nullable', 'string', 'max:2000']]);
        DB::transaction(function () use ($payout, $data) {
            $payout = SellerPayout::lockForUpdate()->findOrFail($payout->id);
            if (! in_array($payout->status, ['requested', 'approved'], true)) abort(422, 'This payout has already been finalized.');
            if ($data['status'] === 'paid' && blank($data['reference'] ?? null)) abort(422, 'A payout reference is required when marking a payout paid.');

            if ($data['status'] === 'rejected') {
                $earningIds = $payout->earnings()->pluck('seller_earnings.id');
                SellerEarning::whereKey($earningIds)->where('status', 'payout_requested')
                    ->lockForUpdate()->update(['status' => 'available']);
            }

            if ($data['status'] === 'paid') {
                $earnings = $payout->earnings()->lockForUpdate()->get();

                if ($earnings->isEmpty()) {
                    $earnings = SellerEarning::where('seller_id', $payout->seller_id)
                        ->where('status', 'available')
                        ->orderBy('id')
                        ->lockForUpdate()
                        ->get();

                    $allocatedPaise = $earnings->sum(fn ($earning) => $this->toPaise((string) $earning->net_amount));
                    abort_unless($allocatedPaise === $this->toPaise((string) $payout->amount), 422, 'Available seller earnings no longer match this payout request.');

                    $payout->earnings()->attach($earnings->mapWithKeys(
                        fn ($earning) => [$earning->id => ['amount' => $earning->net_amount]]
                    )->all());
                }

                $allocatedPaise = $earnings->sum(fn ($earning) => $this->toPaise((string) $earning->pivot->amount));
                abort_unless($allocatedPaise === $this->toPaise((string) $payout->amount), 422, 'Payout allocations do not match the payout amount.');

                foreach ($earnings as $earning) {
                    abort_unless(in_array($earning->status, ['available', 'payout_requested'], true), 422, 'An earning in this payout is no longer available.');
                    $earning->update(['status' => 'paid', 'paid_at' => now()]);
                }
            }

            $payout->update(['status' => $data['status'], 'reference' => $data['reference'] ?? $payout->reference, 'admin_note' => $data['admin_note'] ?? null, 'reviewed_by' => session('admin_id'), 'reviewed_at' => now(), 'paid_at' => $data['status'] === 'paid' ? now() : null]);
        });
        return back()->with('success', 'Payout updated.');
    }

    private function toPaise(string $amount): int
    {
        if (! preg_match('/^(\d+)(?:\.(\d{1,2}))?$/', $amount, $matches)) {
            abort(422, 'Payout amounts must use INR with no more than two decimal places.');
        }

        return ((int) $matches[1] * 100) + (int) str_pad($matches[2] ?? '', 2, '0');
    }
}
