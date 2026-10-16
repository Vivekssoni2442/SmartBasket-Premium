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
        $validated = $request->validate([
            'amount' => ['required', 'regex:/^\d+(?:\.\d{1,2})?$/'],
            'reason' => ['nullable', 'string', 'max:255'],
            'idempotency_key' => ['nullable', 'string', 'max:100'],
        ]);

        abort_unless($transaction->payment, 422, 'This transaction is not linked to a canonical payment.');
        abort_unless($transaction->status === 'paid' && filled($transaction->gateway_payment_id), 422, 'A captured payment is required before a refund.');

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