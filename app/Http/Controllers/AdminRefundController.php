<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminRefundController extends Controller
{
    public function store(Request $request, PaymentTransaction $transaction, PaymentService $payments)
    {
        if ($transaction->gateway === 'seller_upi') {
            return back()->with('error', 'This UPI payment was sent directly to the seller. Ask the seller to refund it offline; no provider refund can be issued from this page.');
        }

        $validated = $request->validate([
            'amount' => ['required', 'regex:/^\d+(?:\.\d{1,2})?$/'],
            'reason' => ['nullable', 'string', 'max:255'],
            'idempotency_key' => ['nullable', 'string', 'max:100'],
        ]);

        if (! $transaction->payment) {
            return back()->with('error', 'This transaction is not linked to a canonical payment, so a refund cannot be requested.');
        }

        if ($transaction->status !== 'paid' || blank($transaction->gateway_payment_id)) {
            return back()->with('error', 'A captured gateway payment is required before requesting a provider refund.');
        }

        $refund = $payments->refundPayment(
            $transaction->payment,
            $transaction,
            (string) $validated['amount'],
            null,
            $validated['reason'] ?? null,
            $validated['idempotency_key'] ?? (string) Str::uuid()
        );

        return back()->with(
            $refund->status === 'failed' ? 'error' : 'success',
            $refund->status === 'failed'
                ? 'The provider did not accept the refund request.'
                : 'Refund submitted to the provider. Final status will update from a verified webhook.'
        );
    }
}
