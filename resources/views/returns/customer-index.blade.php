@extends('layouts.app')
@section('title', 'Return requests')
@section('content')
<style>
    .customer-returns-page { --returns-ink:#17243a; --returns-muted:#718096; --returns-line:#e8edf3; --returns-green:#178267; width:100%; padding:clamp(18px,3vw,38px) clamp(14px,3vw,44px) 52px; color:var(--returns-ink); }
    .customer-returns-page .sb-customer-page-hero { margin-bottom:24px; }
    .returns-toolbar { display:flex; align-items:center; justify-content:space-between; gap:20px; margin:0 0 22px; padding:20px 22px; border:1px solid var(--returns-line); border-radius:22px; background:linear-gradient(120deg,#fff,#f8fbff); box-shadow:0 10px 28px rgba(20,38,65,.055); }
    .returns-toolbar__copy { display:flex; align-items:center; gap:14px; min-width:0; }
    .returns-toolbar__icon { display:grid; flex:0 0 46px; width:46px; height:46px; place-items:center; border:1px solid #d8eee7; border-radius:15px; background:#ecf8f4; color:var(--returns-green); font-size:18px; }
    .returns-toolbar__copy strong { display:block; color:var(--returns-ink); font-size:14px; font-weight:850; }
    .returns-toolbar__copy p { margin:4px 0 0; color:var(--returns-muted); font-size:12px; line-height:1.55; }
    .returns-request-btn { display:inline-flex; min-height:46px; flex:0 0 auto; align-items:center; justify-content:center; gap:9px; padding:0 17px; border:1px solid #176b59; border-radius:13px; background:linear-gradient(135deg,#25866d,#176b59); box-shadow:0 9px 20px rgba(23,107,89,.18); color:#fff!important; font-size:12px; font-weight:850; text-decoration:none!important; transition:transform .18s ease,box-shadow .18s ease; }
    .returns-request-btn:hover { transform:translateY(-2px); box-shadow:0 13px 24px rgba(23,107,89,.24); }
    .returns-list { display:grid; gap:12px; }
    .return-request-row { display:grid; grid-template-columns:minmax(150px,.8fr) minmax(180px,1.1fr) minmax(0,1.5fr) auto 34px; align-items:center; gap:18px; min-height:92px; padding:17px 20px; border:1px solid var(--returns-line); border-radius:18px; background:#fff; box-shadow:0 5px 18px rgba(20,38,65,.035); color:inherit; text-decoration:none!important; transition:border-color .18s ease,transform .18s ease,box-shadow .18s ease; }
    .return-request-row:hover { transform:translateY(-2px); border-color:#bfddd5; box-shadow:0 12px 28px rgba(20,38,65,.08); }
    .return-request-row__label { display:block; margin-bottom:5px; color:#8a96a8; font-size:9px; font-weight:850; letter-spacing:.1em; text-transform:uppercase; }
    .return-request-row__value { display:block; overflow:hidden; color:#1c2b41; font-size:12px; font-weight:800; text-overflow:ellipsis; }
    .return-request-row__meta { display:block; margin-top:5px; color:var(--returns-muted); font-size:10px; }
    .return-request-status { display:inline-flex; align-items:center; gap:7px; width:fit-content; padding:7px 10px; border:1px solid #e3e9f0; border-radius:999px; background:#f7f9fc; color:#526176; font-size:10px; font-weight:850; white-space:nowrap; }
    .return-request-status::before { width:6px; height:6px; border-radius:50%; background:currentColor; content:""; }
    .return-request-status.is-success { border-color:#d1eee4; background:#effaf6; color:#168267; }
    .return-request-status.is-danger { border-color:#f4d8dc; background:#fff4f5; color:#c74657; }
    .return-request-status.is-pending { border-color:#f2e6c7; background:#fffaf0; color:#a87819; }
    .return-request-row__arrow { display:grid; width:32px; height:32px; place-items:center; border:1px solid var(--returns-line); border-radius:11px; color:#718096; transition:all .18s ease; }
    .return-request-row:hover .return-request-row__arrow { border-color:#c5e3da; background:#effaf6; color:var(--returns-green); }
    .returns-empty { padding:clamp(30px,6vw,64px) 20px; border:1px dashed #d8e1eb; border-radius:24px; background:linear-gradient(145deg,#fff,#f8fafc); text-align:center; }
    .returns-empty__icon { display:grid; width:62px; height:62px; place-items:center; margin:0 auto 17px; border:1px solid #dce9e5; border-radius:20px; background:#eff8f5; color:var(--returns-green); font-size:23px; }
    .returns-empty h2 { margin:0; color:var(--returns-ink); font-size:19px; font-weight:900; }
    .returns-empty p { max-width:450px; margin:8px auto 19px; color:var(--returns-muted); font-size:12px; line-height:1.7; }
    .returns-pagination { margin-top:20px; }
    @media(max-width:760px) {
        .customer-returns-page { padding:16px 13px 36px; }
        .returns-toolbar { align-items:flex-start; flex-direction:column; padding:17px; }
        .returns-request-btn { width:100%; }
        .return-request-row { grid-template-columns:minmax(0,1fr) auto; gap:12px; padding:16px; }
        .return-request-row__order,.return-request-row__products { grid-column:1/-1; }
        .return-request-row__status { grid-column:1; }
        .return-request-row__arrow { grid-column:2; grid-row:4; }
    }
</style>

<main class="customer-returns-page">
    <x-customer-page-hero
        title="Returns & Cancellations"
        subtitle="Track every return, replacement and order cancellation in one place."
        :stat="$returns->total() + $cancellations->total()"
        stat-label="Total requests"
    />

    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4" role="status">{{ session('success') }}</div>
    @endif

    <section class="returns-toolbar" aria-label="Start a return request">
        <div class="returns-toolbar__copy">
            <span class="returns-toolbar__icon" aria-hidden="true"><i class="fa-solid fa-box-open"></i></span>
            <div>
                <strong>Need to return an order?</strong>
                <p>Choose an order first, then select the products and quantities you want to return.</p>
            </div>
        </div>
        <a href="{{ route('orders.index') }}" class="returns-request-btn"><i class="fa-solid fa-arrow-rotate-left" aria-hidden="true"></i> Request a return</a>
    </section>

    @if($returns->isNotEmpty())
        <section class="returns-list" aria-label="Your return requests">
            @foreach($returns as $return)
                @php
                    $returnStatus = strtolower((string) $return->status);
                    $statusClass = in_array($returnStatus, ['approved', 'refunded'], true) ? 'is-success' : (in_array($returnStatus, ['rejected', 'cancelled'], true) ? 'is-danger' : 'is-pending');
                    $returnProducts = collect($return->items ?? [])->pluck('name')->filter()->take(2)->implode(', ');
                    $remainingProducts = max(0, collect($return->items ?? [])->count() - 2);
                @endphp
                <a href="{{ route('returns.show', $return) }}" class="return-request-row">
                    <div>
                        <span class="return-request-row__label">Request</span>
                        <strong class="return-request-row__value">Return #{{ $return->id }}</strong>
                        <small class="return-request-row__meta">{{ $return->created_at?->format('d M Y') }}</small>
                    </div>
                    <div class="return-request-row__order">
                        <span class="return-request-row__label">Order</span>
                        <strong class="return-request-row__value">Order #{{ $return->order_id }}</strong>
                    </div>
                    <div class="return-request-row__products">
                        <span class="return-request-row__label">Products</span>
                        <strong class="return-request-row__value">{{ $returnProducts ?: 'Product details unavailable' }}{{ $remainingProducts ? ' +' . $remainingProducts . ' more' : '' }}</strong>
                        <small class="return-request-row__meta">{{ collect($return->items ?? [])->sum(fn ($item) => (int) ($item['quantity'] ?? 0)) }} item(s)</small>
                    </div>
                    <span class="return-request-status {{ $statusClass }} return-request-row__status">{{ ucfirst(str_replace('_', ' ', $return->status)) }}</span>
                    <span class="return-request-row__arrow" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                </a>
            @endforeach
        </section>
        <div class="returns-pagination">{{ $returns->links() }}</div>
    @else
        <section class="returns-empty">
            <span class="returns-empty__icon" aria-hidden="true"><i class="fa-solid fa-box-open"></i></span>
            <h2>No return requests yet</h2>
            <p>When you submit a return request from an eligible order, its review and refund progress will appear here.</p>
            <a href="{{ route('orders.index') }}" class="returns-request-btn"><i class="fa-solid fa-arrow-rotate-left" aria-hidden="true"></i> Go to my orders</a>
        </section>
    @endif

    <section class="mt-4" aria-label="Order cancellation history">
        <h2 class="h5 fw-bold mb-3">Order cancellations</h2>
        @forelse($cancellations as $cancellation)
            @php($cancellationStatus = strtolower((string) $cancellation->status))
            @php($cancellationClass = $cancellationStatus === 'refunded' ? 'is-success' : (in_array($cancellationStatus, ['no_refund'], true) ? 'is-danger' : 'is-pending'))
            <article class="return-request-row mb-3">
                <div><span class="return-request-row__label">Cancellation</span><strong class="return-request-row__value">Order #{{ $cancellation->order_id }}</strong><small class="return-request-row__meta">{{ $cancellation->created_at?->format('d M Y') }}</small></div>
                <div class="return-request-row__order"><span class="return-request-row__label">Refund method</span><strong class="return-request-row__value">{{ $cancellation->refund_method ? strtoupper($cancellation->refund_method) : 'Not required' }}</strong></div>
                <div class="return-request-row__products"><span class="return-request-row__label">Reason</span><strong class="return-request-row__value">{{ $cancellation->reason ?: 'Not provided' }}</strong></div>
                <span class="return-request-status {{ $cancellationClass }}">{{ $cancellationStatus === 'refund_pending' ? 'Refund pending' : ($cancellationStatus === 'refunded' ? 'Refund sent' : 'Cancelled') }}</span>
            </article>
        @empty
            <p class="text-muted">No order cancellations yet.</p>
        @endforelse
        @if($cancellations->hasPages())<div class="returns-pagination">{{ $cancellations->links() }}</div>@endif
    </section>
</main>
@endsection
