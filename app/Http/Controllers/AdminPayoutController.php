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
            $payout->update(['status' => $data['status'], 'reference' => $data['reference'] ?? $payout->reference, 'admin_note' => $data['admin_note'] ?? null, 'reviewed_by' => session('admin_id'), 'reviewed_at' => now(), 'paid_at' => $data['status'] === 'paid' ? now() : null]);
            if ($data['status'] === 'paid') {
                $remaining = (float) $payout->amount;
                foreach (SellerEarning::where('seller_id', $payout->seller_id)->where('status', 'available')->orderBy('id')->lockForUpdate()->get() as $earning) {
                    if ($remaining <= 0) break;
                    // Requests are only allowed up to the available total. One payout may
                    // consume full ledger entries; partial allocation remains available.
                    if ((float) $earning->net_amount <= $remaining) { $earning->update(['status' => 'paid', 'paid_at' => now()]); $remaining -= (float) $earning->net_amount; }
                }
            }
        });
        return back()->with('success', 'Payout updated.');
    }
}
