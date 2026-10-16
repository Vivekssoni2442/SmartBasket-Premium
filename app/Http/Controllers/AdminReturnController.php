<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminAuditLog;
use App\Models\OrderReturnRequest;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminReturnController extends Controller
{
    public function show(OrderReturnRequest $returnRequest)
    {
        $returnRequest->load(['order.user', 'order.seller', 'customer']);
        $payments = $returnRequest->order->payments()->with(['transactions', 'refunds'])->get();

        return view('admin.returns.show', compact('returnRequest', 'payments'));
    }

    public function index(Request $request)
    {
        $query = OrderReturnRequest::with(['order.user'])->latest();
        if ($request->filled('status')) {
            $status = $request->validate(['status' => ['in:requested,approved,rejected,refund_pending,refunded,cancelled']])['status'];
            $query->where('status', $status);
        }
        if ($request->filled('from')) {
            $from = $request->validate(['from' => ['date']])['from'];
            $query->whereDate('created_at', '>=', $from);
        }
        if ($request->filled('to')) {
            $toRules = ['date'];
            if ($request->filled('from')) {
                $toRules[] = 'after_or_equal:from';
            }
            $to = $request->validate(['to' => $toRules])['to'];
            $query->whereDate('created_at', '<=', $to);
        }
        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());
            $query->where(function ($returns) use ($search) {
                if (ctype_digit($search)) {
                    $returns->where('id', (int) $search)->orWhere('order_id', (int) $search);
                }
                $returns->orWhereHas('customer', function ($customer) use ($search) {
                    $customer->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
                $sellerIds = SellerProfile::query()->where(function ($sellers) use ($search) {
                    $sellers->where('seller_name', 'like', '%' . $search . '%')->orWhere('shop_name', 'like', '%' . $search . '%');
                })->pluck('id');
                $productIds = Product::where('name', 'like', '%' . $search . '%')->pluck('id');
                foreach ($sellerIds as $sellerId) {
                    $returns->orWhereJsonContains('items', ['seller_id' => (int) $sellerId]);
                }
                foreach ($productIds as $productId) {
                    $returns->orWhereJsonContains('items', ['product_id' => (int) $productId]);
                }
            });
        }
        $returns = $query->paginate(20)->withQueryString();

        return view('admin.returns.index', compact('returns'));
    }

    public function review(Request $request, OrderReturnRequest $returnRequest)
    {
        $validated = $request->validate([
            'decision' => ['required', 'in:approved,rejected'],
            'note' => ['required', 'string', 'max:2000'],
        ]);
        $admin = Admin::findOrFail(session('admin_id'));

        DB::transaction(function () use ($returnRequest, $validated, $admin) {
            $locked = OrderReturnRequest::whereKey($returnRequest->id)->lockForUpdate()->firstOrFail();
            if ($locked->status !== OrderReturnRequest::STATUS_REQUESTED) {
                throw ValidationException::withMessages(['decision' => 'This return request has already been reviewed or cancelled.']);
            }
            $from = $locked->status;
            $locked->status = $validated['decision'];
            $locked->decision_note = trim($validated['note']);
            $locked->reviewed_by_admin = (string) $admin->id;
            $locked->reviewed_at = now();
            $locked->appendHistory($locked->status, $locked->decision_note, 'admin:' . $admin->id);
            $locked->save();
            AdminAuditLog::log($admin, 'return.' . $locked->status, 'order_return_request', (string) $locked->id, $locked->decision_note, ['status' => $from], ['status' => $locked->status]);
        });

        return back()->with('success', 'Return request ' . $validated['decision'] . '.');
    }

    public function refund(OrderReturnRequest $returnRequest, PaymentService $payments)
    {
        if ($returnRequest->status !== OrderReturnRequest::STATUS_APPROVED) {
            throw ValidationException::withMessages(['refund' => 'Only approved return requests can be refunded.']);
        }

        $order = $returnRequest->order;
        $amountMinor = (int) round(collect($returnRequest->items)->sum(
            fn ($item) => (float) ($item['unit_price'] ?? 0) * (int) ($item['quantity'] ?? 0)
        ) * 100);
        $orderCapMinor = (int) round((float) ($order->amount ?? $order->total ?? 0) * 100);
        $amountMinor = min($amountMinor, $orderCapMinor);
        if ($amountMinor <= 0) {
            throw ValidationException::withMessages(['refund' => 'No refundable amount can be calculated from this order snapshot.']);
        }

        $payment = $order->payments()->whereIn('status', ['paid', 'partially_refunded'])->latest('payments.id')->first();
        $attempt = $payment?->transactions()->where('status', 'paid')->whereNotNull('gateway_payment_id')->latest('id')->first();
        if (! $payment || ! $attempt) {
            throw ValidationException::withMessages(['refund' => 'There is no provider-confirmed captured payment linked to this order. This payment cannot be automatically refunded.']);
        }

        $admin = Admin::findOrFail(session('admin_id'));
        DB::transaction(function () use ($returnRequest, $amountMinor, $admin) {
            $locked = OrderReturnRequest::whereKey($returnRequest->id)->lockForUpdate()->firstOrFail();
            if ($locked->status !== OrderReturnRequest::STATUS_APPROVED) {
                throw ValidationException::withMessages(['refund' => 'This return has already entered refund processing.']);
            }
            $locked->status = OrderReturnRequest::STATUS_REFUND_PENDING;
            $locked->refund_amount = number_format($amountMinor / 100, 2, '.', '');
            $locked->appendHistory(OrderReturnRequest::STATUS_REFUND_PENDING, 'Refund processing started; awaiting payment provider response.', 'admin:' . $admin->id);
            $locked->save();
            AdminAuditLog::log($admin, 'return.refund_submitted', 'order_return_request', (string) $locked->id, 'Provider refund processing started.', null, ['amount' => number_format($amountMinor / 100, 2, '.', '')]);
        });

        try {
            $refund = $payments->refundPayment(
                $payment,
                $attempt,
                number_format($amountMinor / 100, 2, '.', ''),
                $order,
                'Customer return #' . $returnRequest->id,
                'return-' . $returnRequest->id . '-' . Str::uuid()
            );
            $refund->update([
                'metadata' => array_merge($refund->metadata ?? [], ['return_request_id' => $returnRequest->id]),
            ]);
        } catch (\InvalidArgumentException $exception) {
            DB::transaction(function () use ($returnRequest, $admin) {
                $locked = OrderReturnRequest::whereKey($returnRequest->id)->lockForUpdate()->firstOrFail();
                if ($locked->status === OrderReturnRequest::STATUS_REFUND_PENDING) {
                    $locked->status = OrderReturnRequest::STATUS_APPROVED;
                    $locked->appendHistory(OrderReturnRequest::STATUS_APPROVED, 'Refund could not be submitted. Administrator may review and retry.', 'admin:' . $admin->id);
                    $locked->save();
                }
            });

            report($exception);
            return back()->with('error', 'The refund could not be submitted. The return remains approved for review.');
        } catch (\Throwable $exception) {
            DB::transaction(function () use ($returnRequest, $admin) {
                $locked = OrderReturnRequest::whereKey($returnRequest->id)->lockForUpdate()->firstOrFail();
                $locked->appendHistory($locked->status, 'Refund submission outcome is uncertain. Reconcile the payment record before any retry.', 'admin:' . $admin->id);
                $locked->save();
            });
            Log::error('Return refund submission outcome is uncertain.', [
                'return_request_id' => $returnRequest->id,
                'exception' => $exception->getMessage(),
            ]);
            return back()->with('error', 'The refund outcome could not be confirmed. The request remains blocked from duplicate processing while the payment record is reconciled.');
        }

        if ($refund->status === 'failed') {
            DB::transaction(function () use ($returnRequest, $admin) {
                $locked = OrderReturnRequest::whereKey($returnRequest->id)->lockForUpdate()->firstOrFail();
                if ($locked->status === OrderReturnRequest::STATUS_REFUND_PENDING) {
                    $locked->status = OrderReturnRequest::STATUS_APPROVED;
                    $locked->appendHistory(OrderReturnRequest::STATUS_APPROVED, 'The payment provider rejected the refund. Administrator review is required.', 'admin:' . $admin->id);
                    $locked->save();
                }
            });
            return back()->with('error', 'The payment provider rejected this refund. The return remains approved; review the payment record before retrying.');
        }

        return back()->with('success', 'Refund submitted. Completion will be shown after a verified provider webhook.');
    }
}
