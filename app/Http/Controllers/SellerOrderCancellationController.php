<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\OrderCancellationRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerOrderCancellationController extends Controller
{
    public function index()
    {
        abort_unless(session('seller_login') && session('seller_id'), 403);
        return redirect()->route('seller.returns.index');
    }

    public function markRefundSent(Request $request, OrderCancellationRequest $cancellation)
    {
        abort_unless(session('seller_login') && session('seller_id'), 403);
        $sellerId = (int) session('seller_id');
        $cancellation->load('order');
        abort_unless($cancellation->order && $cancellation->order->belongsToSeller($sellerId), 404);

        $validated = $request->validate([
            'seller_transfer_reference' => ['nullable', 'string', 'max:120'],
        ]);

        DB::transaction(function () use ($cancellation, $validated, $sellerId) {
            $locked = OrderCancellationRequest::whereKey($cancellation->id)->lockForUpdate()->firstOrFail();
            $order = $locked->order;
            abort_unless($order && $order->belongsToSeller($sellerId), 404);
            abort_unless($locked->status === OrderCancellationRequest::STATUS_REFUND_PENDING, 422, 'This refund is no longer pending.');

            $locked->update([
                'status' => OrderCancellationRequest::STATUS_REFUNDED,
                'seller_transfer_reference' => trim((string) ($validated['seller_transfer_reference'] ?? '')) ?: null,
                'refund_sent_at' => now(),
            ]);

            if ($locked->user_id) {
                Notification::create([
                    'user_id' => $locked->user_id,
                    'role' => 'user',
                    'type' => 'order_refund',
                    'title' => 'Refund sent for order #' . $order->id,
                    'message' => 'The seller marked your INR ' . number_format((float) $locked->refund_amount, 2) . ' refund as sent. Please check your bank or UPI account.',
                    'data' => ['order_id' => $order->id, 'cancellation_id' => $locked->id],
                ]);
            }
        });

        return redirect()->route('seller.returns.index')->with('success', 'Refund marked as sent.');
    }
}
