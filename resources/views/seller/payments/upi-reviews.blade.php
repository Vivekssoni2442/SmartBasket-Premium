@extends('seller.partials.premium-layout')

@section('title', 'UPI Payment Reviews')

@section('content')
<main class="seller-upi-review-page">
    <style>
        .seller-upi-review-page{width:100%;max-width:none;margin:0;padding:24px clamp(14px,2.5vw,32px) 44px;color:#17243a}
        .seller-upi-review-hero{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;margin-bottom:22px;padding:26px;border-radius:24px;background:linear-gradient(120deg,#18265a,#3159bd);color:#fff;box-shadow:0 18px 40px rgba(37,74,167,.2)}
        .seller-upi-review-hero h1{margin:0;font-size:clamp(1.45rem,3vw,2rem);font-weight:900}.seller-upi-review-hero p{margin:7px 0 0;color:rgba(255,255,255,.78)}
        .seller-upi-review-count{display:grid;place-items:center;min-width:54px;height:54px;padding:0 12px;border:1px solid rgba(255,255,255,.25);border-radius:18px;background:rgba(255,255,255,.13);font-size:1.2rem;font-weight:900}
        .seller-upi-review-alert{margin:0 0 16px;padding:14px 17px;border:1px solid #bbf7d0;border-radius:14px;background:#f0fdf4;color:#166534;font-weight:700}
        .seller-upi-review-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,370px),1fr));gap:16px}
        .seller-upi-review-card{padding:21px;border:1px solid #dce6f3;border-radius:20px;background:#fff;box-shadow:0 10px 30px rgba(15,35,70,.07)}
        .seller-upi-review-top{display:flex;align-items:flex-start;justify-content:space-between;gap:12px}.seller-upi-review-top h2{margin:0;color:#17243a;font-size:1.08rem;font-weight:850}.seller-upi-review-top small{color:#64748b}
        .seller-upi-review-amount{margin:18px 0;padding:15px 17px;border:1px solid #d8e3ff;border-radius:15px;background:linear-gradient(120deg,#f1f5ff,#f8f4ff)}.seller-upi-review-amount span{display:block;color:#64748b;font-size:.72rem;font-weight:850;letter-spacing:.08em;text-transform:uppercase}.seller-upi-review-amount strong{display:block;margin-top:3px;color:#15233c;font-size:1.55rem;font-weight:900}
        .seller-upi-review-details{display:grid;gap:10px;margin:0}.seller-upi-review-details div{display:flex;justify-content:space-between;gap:15px}.seller-upi-review-details dt{color:#64748b;font-size:.84rem;font-weight:600}.seller-upi-review-details dd{margin:0;color:#17243a;font-size:.88rem;font-weight:750;text-align:right;overflow-wrap:anywhere}
        .seller-upi-review-orders{margin:16px 0 0;padding:13px;border-radius:13px;background:#f8fafc;color:#475569;font-size:.85rem}.seller-upi-review-orders strong{color:#17243a}
        .seller-upi-review-action{width:100%;margin-top:17px;padding:13px 16px;border:0;border-radius:13px;background:linear-gradient(135deg,#2563eb,#4f46e5);color:#fff;font-weight:850;box-shadow:0 9px 20px rgba(37,99,235,.2)}.seller-upi-review-action:hover{filter:brightness(1.06)}
        .seller-upi-review-empty{padding:44px 20px;border:1px dashed #cbd5e1;border-radius:20px;background:#fff;text-align:center}.seller-upi-review-empty i{color:#16a34a;font-size:2rem}.seller-upi-review-empty h2{margin:12px 0 5px;font-size:1.15rem;font-weight:850}.seller-upi-review-empty p{margin:0;color:#64748b}
        @media(max-width:600px){.seller-upi-review-page{padding:16px 12px 32px}.seller-upi-review-hero{padding:19px;border-radius:19px}.seller-upi-review-card{padding:16px}.seller-upi-review-details div{display:block}.seller-upi-review-details dd{text-align:left;margin-top:3px}}
    </style>

    <header class="seller-upi-review-hero">
        <div><h1><i class="fa-solid fa-money-bill-transfer me-2" aria-hidden="true"></i>UPI  Payment Reviews</h1><p>Confirm credit received in your account to confirm your order.</p></div>
        <span class="seller-upi-review-count" aria-label="{{ $transactions->count() }} waiting">{{ $transactions->count() }}</span>
    </header>

    @if(session('success'))<div class="seller-upi-review-alert" role="status"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>@endif
    @if(session('info'))<div class="seller-upi-review-alert" role="status">{{ session('info') }}</div>@endif

    @if($transactions->isNotEmpty())
        <section class="seller-upi-review-grid">
        @foreach($transactions as $review)
            @php($transaction = $review['transaction'])
            <article class="seller-upi-review-card">
                <div class="seller-upi-review-top"><div><h2>Payment #{{ $transaction->id }}</h2><small>{{ $transaction->created_at?->format('d M Y, h:i A') }}</small></div><span class="badge text-bg-warning">Needs your review</span></div>
                <div class="seller-upi-review-amount"><span>Your seller payment</span><strong>&#8377;{{ number_format((float) ($review['target']['amount'] ?? 0), 2) }}</strong></div>
                <dl class="seller-upi-review-details">
                    <div><dt>Customer</dt><dd>{{ $transaction->user?->name ?? ($transaction->customer_details['name'] ?? 'Customer') }}</dd></div>
                    <div><dt>UPI reference / UTR</dt><dd>{{ $review['reference'] }}</dd></div>
                    <div><dt>Seller account</dt><dd>{{ $review['target']['upi_id'] ?? $seller->getPaymentUpiId() }}</dd></div>
                </dl>
                <div class="seller-upi-review-orders"><strong>Linked orders:</strong> @forelse($review['orders'] as $order) #{{ $order->id }}@if(!$loop->last), @endif @empty No linked order @endforelse</div>
                <form method="POST" action="{{ route('seller.payments.upi-accept', $transaction) }}" onsubmit="return confirm('Confirm that this UPI credit is visible in your seller account? This will confirm your linked customer order.')">
                    @csrf
                    <button class="seller-upi-review-action" type="submit"><i class="fa-solid fa-check me-2"></i>Accept payment &amp; confirm order</button>
                </form>
            </article>
        @endforeach
        </section>
    @else
        <section class="seller-upi-review-empty"><i class="fa-solid fa-circle-check" aria-hidden="true"></i><h2>All caught up</h2><p>No UPI payments are waiting for your review right now.</p></section>
    @endif
</main>
@endsection
