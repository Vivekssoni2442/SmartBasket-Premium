@extends('layouts.app')

@section('title', 'Return or cancel order #' . $order->id)

@section('content')
<style>
    .order-request-hub{width:100%;padding:clamp(18px,3vw,44px);color:#17243a}.order-request-hero{padding:clamp(24px,4vw,42px);border-radius:26px;background:linear-gradient(125deg,#14234a,#3159b9 65%,#6655d9);color:#fff;box-shadow:0 20px 48px #223d8125}.order-request-hero h1{margin:0 0 8px;font-size:clamp(1.65rem,3vw,2.4rem);font-weight:900}.order-request-hero p{margin:0;color:#dbe5ff}.order-request-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px;margin-top:20px}.order-request-card{display:flex;min-height:230px;flex-direction:column;align-items:flex-start;padding:clamp(20px,3vw,30px);border:1px solid #e1e8f2;border-radius:22px;background:#fff;box-shadow:0 14px 35px #1524490d}.order-request-card i{display:grid;width:52px;height:52px;place-items:center;margin-bottom:18px;border-radius:17px;background:#eef3ff;color:#3159d8;font-size:21px}.order-request-card h2{margin:0 0 8px;font-size:1.2rem;font-weight:900}.order-request-card p{flex:1;color:#68758c;line-height:1.65}.order-request-link{display:inline-flex;min-height:47px;align-items:center;gap:9px;padding:0 19px;border-radius:13px;background:linear-gradient(120deg,#2454d7,#6a4fd3);box-shadow:0 9px 20px #3159d82b;color:#fff;font-weight:850;text-decoration:none}.order-request-link:hover{color:#fff;transform:translateY(-1px)}.order-request-disabled{opacity:.62}.order-request-disabled .order-request-link{pointer-events:none;background:#8994a8;box-shadow:none}@media(max-width:700px){.order-request-hub{padding:15px 12px 35px}.order-request-grid{grid-template-columns:1fr}.order-request-card{min-height:0}}
</style>
<main class="order-request-hub">
    <header class="order-request-hero"><h1>Return or cancel order #{{ $order->id }}</h1><p>Choose what you need. Each request stays linked to this order.</p></header>
    <div class="order-request-grid">
        <section class="order-request-card {{ $canReturn ? '' : 'order-request-disabled' }}">
            <i class="fa-solid fa-box-open" aria-hidden="true"></i><h2>Return or replace items</h2>
            <p>Choose the product and quantity. Select “Replace” if you want a replacement instead of returning the item.</p>
            @if($canReturn)<a class="order-request-link" href="{{ route('returns.order-create', $order) }}">Start return / replacement <i class="fa-solid fa-arrow-right"></i></a>@else<span class="text-muted small">Returns are available after an eligible order is delivered.</span>@endif
        </section>
        <section class="order-request-card {{ $canCancel ? '' : 'order-request-disabled' }}">
            <i class="fa-solid fa-ban" aria-hidden="true"></i><h2>Cancel this order</h2>
            <p>Cancel the full order before it is delivered. Choose UPI or bank details for the seller. A COD cancellation has no refund due if the cash was not collected.</p>
            @if($canCancel)<a class="order-request-link" href="{{ route('orders.cancel.form', $order) }}">Continue to cancellation <i class="fa-solid fa-arrow-right"></i></a>@else<span class="text-muted small">This order can no longer be cancelled.</span>@endif
        </section>
    </div>
</main>
@endsection
