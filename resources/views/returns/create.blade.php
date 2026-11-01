@extends('layouts.app')

@section('title', 'Return Product | Smart Basket')

@section('content')
@php
    $productName = $purchase['name'] ?? $product->name ?? 'Product';
    $unitPrice = (float) ($purchase['price'] ?? 0);
@endphp

<style>
    .return-create{--rc-ink:#18243a;--rc-muted:#718096;--rc-line:#e5ebf3;max-width:920px;margin:0 auto;padding:clamp(16px,3vw,34px);color:var(--rc-ink)}
    .return-create__hero{padding:clamp(22px,4vw,36px);border:1px solid rgba(255,255,255,.2);border-radius:24px;background:linear-gradient(120deg,#173b9a,#2858d4 58%,#5848b8);color:#fff;box-shadow:0 20px 48px rgba(41,68,157,.2)}
    .return-create__hero h1{margin:0 0 8px;font-size:clamp(1.7rem,4vw,2.35rem);font-weight:900;letter-spacing:-.04em}.return-create__hero p{margin:0;color:rgba(239,244,255,.82)}
    .return-create__card{margin-top:18px;padding:clamp(18px,3vw,28px);border:1px solid var(--rc-line);border-radius:21px;background:#fff;box-shadow:0 14px 36px rgba(20,38,65,.07)}
    .return-create__product{display:flex;align-items:center;gap:16px;padding:16px;border:1px solid #e8edf5;border-radius:16px;background:linear-gradient(120deg,#fbfdff,#f6f8ff)}
    .return-create__product img{width:82px;height:82px;flex:0 0 82px;object-fit:cover;border-radius:14px;background:#eef2f8}.return-create__product-name{font-weight:850;font-size:1.05rem}.return-create__product-meta{margin-top:5px;color:var(--rc-muted);font-size:.9rem}
    .return-create__fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;margin-top:22px}.return-create__fields label{display:block;margin-bottom:7px;font-size:.88rem;font-weight:800}.return-create__fields .form-control,.return-create__fields .form-select{min-height:46px;border-radius:11px}.return-create__fields .full{grid-column:1/-1}
    .return-create__submit{display:inline-flex;align-items:center;justify-content:center;gap:9px;min-height:48px;margin-top:20px;padding:0 20px;border:0;border-radius:12px;background:linear-gradient(115deg,#2563eb,#5b4be8);color:#fff;font-weight:850;box-shadow:0 9px 22px rgba(37,99,235,.2)}
    @media(max-width:620px){.return-create__fields{grid-template-columns:1fr}.return-create__fields .full{grid-column:auto}.return-create__product{align-items:flex-start;padding:12px}.return-create__product img{width:66px;height:66px;flex-basis:66px}.return-create__submit{width:100%}}
</style>

<main class="return-create">
    <header class="return-create__hero">
        <h1>Return a product</h1>
        <p>Review the selected item and tell us why you are returning it.</p>
    </header>

    <section class="return-create__card" aria-label="Selected product and return form">
        <article class="return-create__product">
            <img src="{{ $product->image ? asset('products/' . $product->image) : 'https://placehold.co/160x160/eef2f8/64748b?text=Product' }}" alt="{{ $productName }}">
            <div>
                <div class="return-create__product-name">{{ $productName }}</div>
                <div class="return-create__product-meta">Order #{{ $order->id }} &middot; &#8377;{{ number_format($unitPrice, 2) }} each &middot; {{ $remaining }} eligible to return</div>
            </div>
        </article>

        <form action="{{ route('returns.store', $order) }}" method="POST">
            @csrf
            <input type="hidden" name="items[0][product_id]" value="{{ $product->id }}">
            <div class="return-create__fields">
                <div>
                    <label for="return-quantity">Quantity to return</label>
                    <input id="return-quantity" type="number" name="items[0][quantity]" min="1" max="{{ $remaining }}" value="1" required class="form-control">
                </div>
                <div>
                    <label for="return-reason">Reason</label>
                    <select id="return-reason" name="reason" required class="form-select">
                        <option value="">Choose a reason</option>
                        <option value="damaged">Damaged</option>
                        <option value="defective">Defective</option>
                        <option value="wrong_item">Wrong item</option>
                        <option value="not_as_described">Not as described</option>
                        <option value="changed_mind">Changed my mind</option>
                        <option value="replace">I want a replacement</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="full">@include('partials.refund-destination-fields')</div>
                <div class="full">
                    <label for="return-description">Additional details (optional)</label>
                    <textarea id="return-description" name="description" maxlength="2000" rows="4" class="form-control"></textarea>
                </div>
            </div>
            <button type="submit" class="return-create__submit"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Submit return request</button>
        </form>
    </section>
</main>
@endsection
