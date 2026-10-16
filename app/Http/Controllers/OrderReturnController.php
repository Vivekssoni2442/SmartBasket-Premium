<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderReturnRequest;
use App\Models\Product;
use App\Services\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderReturnController extends Controller
{
    private const ACTIVE_STATUSES = ['requested', 'approved', 'refund_pending', 'refunded'];
    private const REASONS = ['damaged', 'defective', 'wrong_item', 'not_as_described', 'changed_mind', 'other'];

    public function index()
    {
        $returns = OrderReturnRequest::with('order')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('returns.customer-index', compact('returns'));
    }

    public function store(Request $request, Order $order)
    {
        abort_unless(app(SiteSettings::class)->enabled('return_requests_enabled'), 404);
        abort_unless((int) $order->user_id === (int) auth()->id(), 404);

        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'distinct'],
            'items.*.quantity' => ['required', 'integer', 'min:0'],
            'reason' => ['required', 'in:' . implode(',', self::REASONS)],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $return = DB::transaction(function () use ($order, $validated) {
            $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            $this->assertEligible($lockedOrder);

            $purchased = collect($lockedOrder->items ?? [])->keyBy(fn ($item) => (int) ($item['product_id'] ?? 0));
            $reserved = [];
            foreach ($lockedOrder->returnRequests()->whereIn('status', self::ACTIVE_STATUSES)->lockForUpdate()->get() as $existing) {
                foreach ($existing->items ?? [] as $line) {
                    $id = (int) ($line['product_id'] ?? 0);
                    $reserved[$id] = ($reserved[$id] ?? 0) + (int) ($line['quantity'] ?? 0);
                }
            }

            $requestedLines = [];
            foreach ($validated['items'] as $line) {
                if ((int) $line['quantity'] === 0) {
                    continue;
                }
                $id = (int) $line['product_id'];
                $purchase = $purchased->get($id);
                if (! $purchase) {
                    throw ValidationException::withMessages(['items' => 'A selected product was not part of this order.']);
                }
                $remaining = (int) ($purchase['quantity'] ?? 1) - ($reserved[$id] ?? 0);
                if ((int) $line['quantity'] > $remaining) {
                    throw ValidationException::withMessages(["items.$id" => 'The requested quantity exceeds the quantity still eligible for return.']);
                }
                $requestedLines[] = [
                    'product_id' => $id,
                    'name' => (string) ($purchase['name'] ?? Product::find($id)?->name ?? 'Product'),
                    'quantity' => (int) $line['quantity'],
                    'unit_price' => (float) ($purchase['price'] ?? 0),
                    'seller_id' => (int) ($purchase['seller_id'] ?? Product::whereKey($id)->value('seller_id') ?? 0),
                ];
            }
            if ($requestedLines === []) {
                throw ValidationException::withMessages(['items' => 'Select at least one product and quantity to return.']);
            }

            $return = OrderReturnRequest::create([
                'order_id' => $lockedOrder->id,
                'user_id' => auth()->id(),
                'items' => $requestedLines,
                'reason' => $validated['reason'],
                'description' => $validated['description'] ?? null,
                'status' => OrderReturnRequest::STATUS_REQUESTED,
                'history' => [[
                    'status' => OrderReturnRequest::STATUS_REQUESTED,
                    'note' => 'Return request submitted.',
                    'actor' => 'customer:' . auth()->id(),
                    'at' => now()->toIso8601String(),
                ]],
            ]);

            return $return;
        });

        return redirect()->route('returns.show', $return)->with('success', 'Return request submitted for administrator review.');
    }

    public function show(OrderReturnRequest $returnRequest)
    {
        abort_unless((int) $returnRequest->user_id === (int) auth()->id(), 404);
        $returnRequest->load('order');

        return view('returns.show', compact('returnRequest'));
    }

    public function cancel(OrderReturnRequest $returnRequest)
    {
        abort_unless((int) $returnRequest->user_id === (int) auth()->id(), 404);
        abort_unless($returnRequest->status === OrderReturnRequest::STATUS_REQUESTED, 422, 'This request can no longer be cancelled.');

        DB::transaction(function () use ($returnRequest) {
            $locked = OrderReturnRequest::whereKey($returnRequest->id)->lockForUpdate()->firstOrFail();
            abort_unless($locked->status === OrderReturnRequest::STATUS_REQUESTED, 422, 'This request can no longer be cancelled.');
            $locked->status = OrderReturnRequest::STATUS_CANCELLED;
            $locked->cancelled_at = now();
            $locked->appendHistory(OrderReturnRequest::STATUS_CANCELLED, 'Cancelled by customer.', 'customer:' . auth()->id());
            $locked->save();
        });

        return back()->with('success', 'Return request cancelled.');
    }

    public function sellerIndex()
    {
        $sellerId = (int) session('seller_id');
        $productIds = Product::where('seller_id', $sellerId)->pluck('id')->map(fn ($id) => (int) $id)->all();
        $query = OrderReturnRequest::with(['order.user'])->latest();
        $query->whereHas('order', function ($orders) use ($sellerId, $productIds) {
            $orders->where('seller_id', $sellerId)->orWhereJsonContains('items', ['seller_id' => $sellerId]);
            if ($productIds) {
                $orders->orWhere(function ($legacy) use ($productIds) {
                    foreach ($productIds as $productId) {
                        $legacy->orWhereJsonContains('items', ['product_id' => $productId]);
                    }
                });
            }
        });
        $returns = $query->paginate(15);
        $returns->getCollection()->transform(function ($return) use ($sellerId, $productIds) {
            $return->seller_items = collect($return->items)->filter(fn ($line) => (int) ($line['seller_id'] ?? 0) === $sellerId
                || (! ($line['seller_id'] ?? null) && in_array((int) ($line['product_id'] ?? 0), $productIds, true)))->values();
            return $return;
        });

        return view('seller.returns.index', compact('returns'));
    }

    public function sellerNote(Request $request, OrderReturnRequest $returnRequest)
    {
        $validated = $request->validate(['note' => ['required', 'string', 'max:2000']]);
        $sellerId = (int) session('seller_id');
        abort_unless($returnRequest->order->belongsToSeller($sellerId), 404);

        DB::transaction(function () use ($returnRequest, $validated, $sellerId) {
            $locked = OrderReturnRequest::whereKey($returnRequest->id)->lockForUpdate()->firstOrFail();
            if (! in_array($locked->status, [OrderReturnRequest::STATUS_REQUESTED, OrderReturnRequest::STATUS_APPROVED], true)) {
                throw ValidationException::withMessages(['note' => 'A note cannot be added at this stage.']);
            }
            $locked->seller_note = trim($validated['note']);
            $locked->appendHistory($locked->status, 'Seller note: ' . trim($validated['note']), 'seller:' . $sellerId);
            $locked->save();
        });

        return back()->with('success', 'Your note was added to the return request.');
    }

    private function assertEligible(Order $order): void
    {
        $statuses = collect([$order->deliveryDetail?->status, $order->delivery_status, $order->order_status, $order->status])
            ->filter()->map(fn ($status) => strtolower((string) $status));
        if (! $statuses->contains(fn ($status) => in_array($status, ['delivered', 'complete', 'completed'], true))) {
            throw ValidationException::withMessages(['order' => 'Only delivered orders can be returned.']);
        }
        if (! $order->isPaymentEligibleForReturn()) {
            throw ValidationException::withMessages(['order' => 'Only paid orders are eligible for a return request.']);
        }
        $windowDays = (int) config('returns.window_days', 30);
        if (! $order->created_at || $order->created_at->lt(now()->subDays($windowDays))) {
            throw ValidationException::withMessages(['order' => "Return requests must be submitted within {$windowDays} days of purchase."]);
        }
    }
}
