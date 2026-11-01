<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderCancellationRequest;
use App\Models\OrderReturnRequest;
use App\Models\Product;
use App\Services\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderReturnController extends Controller
{
    private const ACTIVE_STATUSES = ['requested', 'approved', 'refund_pending', 'refunded'];
    private const REASONS = ['damaged', 'defective', 'wrong_item', 'not_as_described', 'changed_mind', 'replace', 'other'];

    public function index()
    {
        $returns = OrderReturnRequest::with('order')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        $cancellations = OrderCancellationRequest::with('order')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15, ['*'], 'cancellations_page');

        return view('returns.customer-index', compact('returns', 'cancellations'));
    }

    public function create(Order $order, Product $product)
    {
        abort_unless((int) $order->user_id === (int) auth()->id(), 404);
        abort_unless(app(SiteSettings::class)->enabled('return_requests_enabled'), 404);
        $this->assertEligible($order);

        $purchase = collect($order->items ?? [])->first(
            fn ($line) => (int) ($line['product_id'] ?? 0) === (int) $product->id
        );
        abort_unless($purchase, 404);

        $reserved = 0;
        foreach ($order->returnRequests()->whereIn('status', self::ACTIVE_STATUSES)->get() as $existing) {
            foreach ($existing->items ?? [] as $line) {
                if ((int) ($line['product_id'] ?? 0) === (int) $product->id) {
                    $reserved += (int) ($line['quantity'] ?? 0);
                }
            }
        }

        $remaining = max(0, (int) ($purchase['quantity'] ?? 1) - $reserved);
        abort_unless($remaining > 0, 404);

        return view('returns.create', compact('order', 'product', 'purchase', 'remaining'));
    }

    public function createForOrder(Order $order)
    {
        abort_unless((int) $order->user_id === (int) auth()->id(), 404);
        abort_unless(app(SiteSettings::class)->enabled('return_requests_enabled'), 404);
        $this->assertEligible($order);

        $products = Product::whereIn('id', collect($order->items ?? [])->pluck('product_id')->filter())->get()->keyBy('id');
        $activeReturnRequests = $order->returnRequests()
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->latest()
            ->get();
        $reserved = [];
        foreach ($activeReturnRequests as $existing) {
            foreach ($existing->items ?? [] as $line) {
                $productId = (int) ($line['product_id'] ?? 0);
                $reserved[$productId] = ($reserved[$productId] ?? 0) + (int) ($line['quantity'] ?? 0);
            }
        }

        $lines = collect($order->items ?? [])->values()->map(function ($purchase, $index) use ($products, $reserved) {
            $productId = (int) ($purchase['product_id'] ?? 0);
            $remaining = max(0, (int) ($purchase['quantity'] ?? 1) - ($reserved[$productId] ?? 0));

            return [
                'index' => $index,
                'product_id' => $productId,
                'product' => $products->get($productId),
                'name' => $purchase['name'] ?? $products->get($productId)?->name ?? 'Product',
                'unit_price' => (float) ($purchase['price'] ?? 0),
                'remaining' => $remaining,
            ];
        })->filter(fn ($line) => $line['remaining'] > 0)->values();

        return view('returns.create-order', compact('order', 'lines', 'activeReturnRequests'));
    }

    public function store(Request $request, Order $order)
    {
        abort_unless(app(SiteSettings::class)->enabled('return_requests_enabled'), 404);
        abort_unless((int) $order->user_id === (int) auth()->id(), 404);

        $customer = auth()->user();
        foreach ([
            'upi_id' => 'refund_upi_id',
            'bank_account_holder' => 'refund_account_holder',
            'bank_name' => 'refund_bank_name',
            'bank_account_number' => 'refund_account_number',
            'bank_ifsc' => 'refund_ifsc',
        ] as $input => $profileField) {
            if (! filled($request->input($input)) && filled($customer?->{$profileField})) {
                $request->merge([$input => $customer->{$profileField}]);
            }
        }
        if (! filled($request->input('refund_method'))) {
            $request->merge(['refund_method' => filled($customer?->refund_upi_id) ? 'upi' : (filled($customer?->refund_account_number) ? 'bank' : null)]);
        }

        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1', 'max:50'],
            'items.*.product_id' => ['required', 'integer', 'distinct'],
            'items.*.quantity' => ['required', 'integer', 'min:0'],
            'reason' => ['required', 'in:' . implode(',', self::REASONS)],
            'description' => ['nullable', 'string', 'max:2000'],
            'refund_method' => ['required', 'in:upi,bank'],
            'upi_id' => ['nullable', 'required_if:refund_method,upi', 'string', 'max:120', 'regex:/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+$/'],
            'bank_account_holder' => ['nullable', 'required_if:refund_method,bank', 'string', 'max:150'],
            'bank_name' => ['nullable', 'required_if:refund_method,bank', 'string', 'max:150'],
            'bank_account_number' => ['nullable', 'required_if:refund_method,bank', 'regex:/^[0-9]{6,20}$/'],
            'bank_ifsc' => ['nullable', 'required_if:refund_method,bank', 'regex:/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/'],
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

            $customer = auth()->user();
            $refundMethod = $validated['refund_method'];
            if ($refundMethod === 'upi') {
                $customer->forceFill(['refund_upi_id' => $validated['upi_id']])->save();
            } else {
                $customer->forceFill([
                    'refund_account_holder' => $validated['bank_account_holder'],
                    'refund_bank_name' => $validated['bank_name'],
                    'refund_account_number' => $validated['bank_account_number'],
                    'refund_ifsc' => strtoupper($validated['bank_ifsc']),
                ])->save();
            }

            $return = OrderReturnRequest::create([
                'order_id' => $lockedOrder->id,
                'user_id' => auth()->id(),
                'items' => $requestedLines,
                'reason' => $validated['reason'],
                'description' => $validated['description'] ?? null,
                'refund_method' => $refundMethod,
                'refund_upi_id' => $refundMethod === 'upi' ? $validated['upi_id'] : null,
                'refund_account_holder' => $refundMethod === 'bank' ? $validated['bank_account_holder'] : null,
                'refund_bank_name' => $refundMethod === 'bank' ? $validated['bank_name'] : null,
                'refund_account_number' => $refundMethod === 'bank' ? $validated['bank_account_number'] : null,
                'refund_ifsc' => $refundMethod === 'bank' ? strtoupper($validated['bank_ifsc']) : null,
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

        return redirect()->route('products.index')->with('return_request_success', [
            'order_id' => $return->order_id,
            'return_id' => $return->id,
        ]);
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
        $query->where(function ($returns) use ($sellerId, $productIds) {
            $returns->whereJsonContains('items', ['seller_id' => $sellerId]);
            foreach ($productIds as $productId) {
                $returns->orWhereJsonContains('items', ['product_id' => $productId]);
            }
        });
        $returns = $query->paginate(15);
        $returns->getCollection()->transform(function ($return) use ($sellerId, $productIds) {
            $return->seller_items = collect($return->items)->filter(fn ($line) => (int) ($line['seller_id'] ?? 0) === $sellerId
                || (! ($line['seller_id'] ?? null) && in_array((int) ($line['product_id'] ?? 0), $productIds, true)))->values();
            return $return;
        });

        $cancellations = OrderCancellationRequest::with(['order', 'customer'])
            ->whereHas('order', fn ($query) => $query->forSeller($sellerId))
            ->latest()
            ->paginate(20, ['*'], 'cancellations_page');
        $cancellationProductIds = $cancellations->getCollection()
            ->flatMap(fn ($cancellation) => collect($cancellation->order?->items ?? [])->pluck('product_id'))
            ->filter()->map(fn ($id) => (int) $id)->unique();
        $cancellationProducts = Product::whereIn('id', $cancellationProductIds)->get()->keyBy('id');
        $refundCount = OrderCancellationRequest::where('status', OrderCancellationRequest::STATUS_REFUND_PENDING)
            ->whereHas('order', fn ($query) => $query->forSeller($sellerId))->count();

        return view('seller.returns.index', compact('returns', 'cancellations', 'cancellationProducts', 'refundCount'));
    }

    public function sellerDecision(Request $request, OrderReturnRequest $returnRequest)
    {
        $validated = $request->validate([
            'decision' => ['required', 'in:approved,rejected'],
            'note' => ['nullable', 'string', 'max:2000'],
        ]);
        $sellerId = (int) session('seller_id');
        $productIds = Product::where('seller_id', $sellerId)->pluck('id')->map(fn ($id) => (int) $id)->all();

        abort_unless($this->hasSellerItems($returnRequest, $sellerId, $productIds), 404);

        DB::transaction(function () use ($returnRequest, $validated, $sellerId, $productIds) {
            $locked = OrderReturnRequest::whereKey($returnRequest->id)->lockForUpdate()->firstOrFail();
            if (! $this->hasSellerItems($locked, $sellerId, $productIds)) {
                abort(404);
            }
            if ($locked->status !== OrderReturnRequest::STATUS_REQUESTED) {
                throw ValidationException::withMessages(['decision' => 'This request has already been reviewed or cancelled.']);
            }

            $note = trim((string) ($validated['note'] ?? ''));
            $locked->status = $validated['decision'];
            $locked->seller_note = $note !== '' ? $note : null;
            $locked->reviewed_at = now();
            $historyNote = $note !== '' ? $note : 'Return request ' . $validated['decision'] . ' by seller.';
            $locked->appendHistory($locked->status, $historyNote, 'seller:' . $sellerId);
            $locked->save();
        });

        return back()->with('success', 'Return request ' . $validated['decision'] . ' successfully.');
    }

    public function sellerNote(Request $request, OrderReturnRequest $returnRequest)
    {
        $validated = $request->validate(['note' => ['required', 'string', 'max:2000']]);
        $sellerId = (int) session('seller_id');
        $productIds = Product::where('seller_id', $sellerId)->pluck('id')->map(fn ($id) => (int) $id)->all();
        abort_unless($this->hasSellerItems($returnRequest, $sellerId, $productIds), 404);

        DB::transaction(function () use ($returnRequest, $validated, $sellerId, $productIds) {
            $locked = OrderReturnRequest::whereKey($returnRequest->id)->lockForUpdate()->firstOrFail();
            if (! $this->hasSellerItems($locked, $sellerId, $productIds)) {
                abort(404);
            }
            if (! in_array($locked->status, [OrderReturnRequest::STATUS_REQUESTED, OrderReturnRequest::STATUS_APPROVED], true)) {
                throw ValidationException::withMessages(['note' => 'A note cannot be added at this stage.']);
            }
            $locked->seller_note = trim($validated['note']);
            $locked->appendHistory($locked->status, 'Seller note: ' . trim($validated['note']), 'seller:' . $sellerId);
            $locked->save();
        });

        return back()->with('success', 'Your note was added to the return request.');
    }

    private function hasSellerItems(OrderReturnRequest $returnRequest, int $sellerId, array $productIds): bool
    {
        return collect($returnRequest->items ?? [])->contains(fn ($line) =>
            (int) ($line['seller_id'] ?? 0) === $sellerId
            || (! ($line['seller_id'] ?? null) && in_array((int) ($line['product_id'] ?? 0), $productIds, true))
        );
    }

    private function assertEligible(Order $order): void
    {
        $statuses = collect([$order->deliveryDetail?->status, $order->delivery_status, $order->order_status, $order->status])
            ->filter()->map(fn ($status) => strtolower(trim((string) $status)));
        if ($statuses->contains(fn ($status) => in_array($status, ['cancelled', 'canceled'], true))) {
            throw ValidationException::withMessages(['order' => 'A cancelled order cannot be returned.']);
        }
        if (! $statuses->contains(fn ($status) => in_array($status, ['delivered', 'complete', 'completed'], true))) {
            throw ValidationException::withMessages(['order' => 'Only delivered orders can be returned.']);
        }
        if (! $order->isPaymentEligibleForReturn()) {
            throw ValidationException::withMessages(['order' => 'This order is not eligible for a return request.']);
        }
        $windowDays = (int) config('returns.window_days', 30);
        if (! $order->created_at || $order->created_at->lt(now()->subDays($windowDays))) {
            throw ValidationException::withMessages(['order' => "Return requests must be submitted within {$windowDays} days of purchase."]);
        }
    }
}
