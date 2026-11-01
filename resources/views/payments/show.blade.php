@extends('layouts.customer')

@section('title', 'Payment Details | Smart Basket')
@section('page_title', '')

@push('styles')
<style>
/* Payment Details page: keep the shared customer navigation and remove its
   secondary icon strip so the payment hero becomes the page header. */
body:has(main.payment-detail) .sb-topbar{display:none!important}
body .sb-main .payment-detail{box-sizing:border-box;width:calc(100% - 50px)!important;max-width:1180px!important;margin:25px auto 70px!important;padding:0!important}
.payment-detail .sb-customer-page-hero{position:relative;min-height:190px;margin-bottom:22px;padding:clamp(24px,4vw,42px);border:1px solid rgba(255,255,255,.17);border-radius:26px;background:linear-gradient(118deg,#151d3c 0%,#233c70 58%,#305c93 100%)!important;box-shadow:0 22px 54px rgba(25,43,82,.2),inset 0 1px 0 rgba(255,255,255,.12);color:#fff}
.payment-detail .sb-customer-page-hero::before{top:-110px;right:8%;width:300px;height:260px;background:rgba(129,177,255,.18);filter:blur(55px)}
.payment-detail .detail-head{position:relative;z-index:1;align-items:center;margin:0}
.payment-detail .payment-hero-copy{max-width:760px}
.payment-detail .eyebrow{color:#bfd5f7;font-size:.68rem;letter-spacing:.18em}
.payment-detail .detail-head h1{font-size:clamp(1.8rem,4vw,2.7rem);font-weight:850;letter-spacing:-.045em}
.payment-detail .payment-hero-reference{color:rgba(235,242,255,.8);font-size:.92rem}
.payment-detail .payment-hero-reference strong{border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.1);color:#fff}
.payment-detail .detail-head .status{align-self:flex-start;margin-top:2px;padding:9px 14px;border:1px solid rgba(255,255,255,.16);background:rgba(255,255,255,.13);color:#fff;backdrop-filter:blur(10px)}
.payment-detail .detail-card{padding:clamp(20px,3.5vw,34px);border:1px solid rgba(148,163,184,.2);border-radius:25px;background:var(--sb-surface,#fff);box-shadow:0 18px 46px rgba(15,23,42,.07)}
.payment-detail .payment-summary{grid-template-columns:1fr auto;align-items:center;gap:7px 20px;margin-bottom:30px;padding:clamp(20px,3vw,30px);border:1px solid rgba(148,163,184,.18);border-radius:20px;background:linear-gradient(135deg,rgba(148,163,184,.08),transparent 75%),var(--sb-card-2,var(--sb-surface,#fff))}
.payment-detail .payment-summary span{grid-column:1/-1;color:var(--sb-muted,#64748b);font-size:.68rem;letter-spacing:.16em}
.payment-detail .payment-summary strong{font-size:clamp(2rem,5vw,3rem);letter-spacing:-.055em}
.payment-detail .payment-summary small{justify-self:end;padding:8px 12px;border:1px solid rgba(148,163,184,.18);border-radius:999px;background:rgba(148,163,184,.08);font-size:.78rem;font-weight:750}
.payment-detail .section-heading{margin-bottom:16px;font-size:1.08rem;letter-spacing:-.02em}
.payment-detail .detail-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
.payment-detail .detail-grid>div{padding:17px 18px;border:1px solid rgba(148,163,184,.17);border-radius:15px;background:var(--sb-card-2,var(--sb-surface,#fff));transition:transform .18s,box-shadow .18s}
.payment-detail .detail-grid>div:hover{transform:translateY(-2px);border-color:rgba(148,163,184,.17);box-shadow:0 10px 24px rgba(15,23,42,.06)}
.payment-detail .detail-grid span{font-size:.66rem;letter-spacing:.12em}
.payment-detail .detail-grid strong{font-size:.94rem;line-height:1.5}
.payment-detail .legacy-upi-card{padding:clamp(17px,3vw,26px);border:1px solid rgba(148,163,184,.18);border-radius:20px;background:var(--sb-card-2,var(--sb-surface,#fff))}
.payment-detail .legacy-upi-seller{box-shadow:0 8px 24px rgba(15,23,42,.045)}
.payment-detail .verify-flow{padding:18px 20px;border-radius:17px}
@media(max-width:900px){body .sb-main .payment-detail{width:calc(100% - 24px)!important;margin:16px auto 60px!important;padding:0!important}}
@media(max-width:650px){.payment-detail .sb-customer-page-hero{min-height:0;margin-bottom:15px;padding:21px 18px;border-radius:20px}.payment-detail .detail-head{display:block}.payment-detail .detail-head .status{margin-top:16px}.payment-detail .payment-summary{grid-template-columns:1fr;gap:8px}.payment-detail .payment-summary span{grid-column:auto}.payment-detail .payment-summary small{justify-self:start}.payment-detail .detail-grid{grid-template-columns:1fr}.payment-detail .detail-card{border-radius:20px}}

.payment-detail{--pd-line:var(--sb-border,rgba(100,116,139,.18));width:100%;max-width:1180px;margin:auto;padding:clamp(15px,3vw,36px);color:var(--sb-text,#172033)}
.payment-detail *{box-sizing:border-box}
.detail-card{position:relative;overflow:hidden;padding:clamp(18px,3vw,32px);border:1px solid var(--pd-line);border-radius:25px;background:var(--sb-surface,#fff);box-shadow:0 20px 60px rgba(15,23,42,.08)}
.detail-card:before{content:none;display:none}
.detail-head{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:22px}
.detail-head h1{margin:0;font-size:clamp(1.65rem,3.6vw,2.5rem);font-weight:950;letter-spacing:-.045em;color:var(--sb-text,#172033)}
.payment-hero-copy{min-width:0}.payment-hero-reference{margin:10px 0 0;color:var(--sb-muted,#64748b);font-size:.92rem;line-height:1.6}.payment-hero-reference strong{display:inline-block;margin:0 3px;padding:3px 9px;border:1px solid var(--pd-line);border-radius:8px;color:var(--sb-text,#172033);background:var(--sb-surface,#fff);font-weight:900}
.eyebrow{display:block;margin-bottom:7px;color:var(--sb-muted,#64748b);font-size:.72rem;font-weight:850;letter-spacing:.13em;text-transform:uppercase}
.status{display:inline-flex;align-items:center;gap:7px;padding:9px 13px;border-radius:999px;background:rgba(245,158,11,.14);color:#a16207;font-size:.8rem;font-weight:850;white-space:nowrap}
.status:before{content:"";width:7px;height:7px;border-radius:50%;background:currentColor}
.status.paid{background:rgba(22,163,74,.13);color:#15803d}
.status.failed,.status.cancelled,.status.expired,.status.amount_mismatch{background:rgba(220,38,38,.12);color:#b91c1c}
.status.manual_review,.status.processing,.status.pending{background:rgba(245, 158, 11, 0.14);color:#a16207}
.payment-summary{display:grid;gap:5px;margin-bottom:27px;padding:clamp(20px,3vw,30px);border:1px solid var(--pd-line);border-radius:22px;background:var(--sb-card-2,var(--sb-surface,#fff))}
.payment-summary span{font-size:.72rem;font-weight:900;letter-spacing:.13em;text-transform:uppercase;color:var(--sb-muted,#64748b)}
.payment-summary strong{font-size:clamp(1.8rem,5vw,2.7rem);line-height:1.15;letter-spacing:-.05em;font-weight:950;color:var(--sb-text,#172033);overflow-wrap:anywhere}
.payment-summary small{font-size:.88rem;color:var(--sb-muted,#64748b)}
.section-heading{display:flex;align-items:center;gap:10px;margin:0 0 13px;font-size:1.03rem;font-weight:900}
.section-heading:before{content:none;display:none}
.detail-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}
.detail-grid>div{min-width:0;padding:16px;border:1px solid var(--pd-line);border-radius:15px;background:var(--sb-card-2,var(--sb-surface,#fff));transition:transform .2s,border-color .2s}
.detail-grid>div:hover{transform:translateY(-2px);border-color:var(--pd-line)}
.detail-grid span{display:block;margin-bottom:7px;color:var(--sb-muted,#64748b);font-size:.7rem;font-weight:850;letter-spacing:.08em;text-transform:uppercase}
.detail-grid strong{display:block;color:var(--sb-text,#172033);font-size:.94rem;font-weight:800;overflow-wrap:anywhere}
.notice{margin:17px 0;padding:15px 17px;border:1px solid rgba(220,38,38,.2);border-radius:15px;background:rgba(220,38,38,.08);color:#b91c1c;line-height:1.55}
.notice p{margin:7px 0 0;color:inherit}
.notice--setup{border-color:rgba(217,119,6,.25);background:linear-gradient(120deg,rgba(245,158,11,.13),rgba(249,115,22,.08));color:var(--sb-text,#172033)}
.notice--success{border-color:rgba(22,163,74,.2);background:rgba(22,163,74,.09);color:#15803d}
.verify-flow{display:flex;align-items:center;gap:15px;margin:20px 0;padding:17px;border:1px solid var(--pd-line);border-radius:18px;background:var(--sb-card-2,var(--sb-surface,#fff))}
.verify-flow__orb{display:grid;place-items:center;flex:0 0 50px;width:50px;height:50px;border-radius:16px;background:rgba(37,99,235,.12);color:#315be8;font-size:19px}
.verify-flow[data-state="waiting"] .verify-flow__orb,.verify-flow[data-state="verifying"] .verify-flow__orb{animation:verifyPulse 1.25s ease-in-out infinite}
.verify-flow[data-state="success"] .verify-flow__orb{background:rgba(22,163,74,.14);color:#15803d;animation:verifySuccess .45s ease both}
.verify-flow[data-state="error"] .verify-flow__orb{background:rgba(220,38,38,.12);color:#b91c1c}
.verify-flow__copy{min-width:0}.verify-flow__copy strong,.verify-flow__copy span{display:block}.verify-flow__copy strong{font-weight:900}.verify-flow__copy span{margin-top:4px;color:var(--sb-muted,#64748b);font-size:.84rem;line-height:1.5}
.verify-flow__steps{display:flex;gap:6px;margin-top:10px}.verify-flow__steps i{width:7px;height:7px;border-radius:50%;background:#cbd5e1}
.verify-flow[data-state="waiting"] .verify-flow__steps i:first-child,.verify-flow[data-state="verifying"] .verify-flow__steps i{background:#4169e1;animation:verifyDot .8s ease-in-out infinite alternate}
.verify-flow[data-state="verifying"] .verify-flow__steps i:nth-child(2){animation-delay:.15s}.verify-flow[data-state="verifying"] .verify-flow__steps i:nth-child(3){animation-delay:.3s}
.verify-flow[data-state="success"] .verify-flow__steps i{background:#16a34a}.verify-flow[data-state="error"] .verify-flow__steps i{background:#dc2626}
.legacy-upi-card{margin-top:23px;padding:clamp(15px,2.5vw,23px);border:1px solid var(--pd-line);border-radius:21px;background:var(--sb-card-2,#f8fafc)}
.legacy-upi-card h2{margin:0 0 7px;font-size:1.15rem;font-weight:900}.legacy-upi-card>p{margin:0 0 17px;color:var(--sb-muted,#64748b);line-height:1.55}
.legacy-upi-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,230px),1fr));gap:13px}
.legacy-upi-seller{display:grid;justify-items:center;align-content:start;gap:9px;min-width:0;padding:17px;border:1px solid var(--pd-line);border-radius:18px;background:var(--sb-surface,#fff);text-align:center}
.legacy-upi-seller>strong:first-child{font-size:1rem;font-weight:900}.legacy-upi-seller>span{color:var(--sb-muted,#64748b);overflow-wrap:anywhere}
.legacy-upi-seller img{width:min(100%,220px);height:auto;padding:7px;border:1px solid var(--pd-line);border-radius:13px;background:#fff}
.legacy-upi-amount{color:#2563eb;font-size:1.35rem;font-weight:900}
.upi-app-shortcuts{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:8px;width:100%;margin:8px 0}
.upi-app-shortcut{display:grid;justify-items:center;align-content:center;gap:5px;min-width:0;padding:11px 4px;border:1px solid var(--pd-line);border-radius:13px;background:var(--sb-surface,#fff);color:var(--sb-text,#172033);font-size:.72rem;font-weight:850;text-decoration:none;transition:transform .18s,box-shadow .18s}
.upi-app-shortcut:hover{color:var(--sb-text,#172033);transform:translateY(-2px);box-shadow:0 8px 20px rgba(37,99,235,.12)}
.upi-app-shortcut .upi-emoji{display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:rgba(255,255,255,.8);font-size:1.35rem;line-height:1;box-shadow:0 3px 10px rgba(15,23,42,.07)}
.upi-app-shortcut[data-upi-app="gpay"]{background:#f0fbf4;border-color:#ccebd7;color:#168447}.upi-app-shortcut[data-upi-app="phonepe"]{background:#f7f1ff;border-color:#e5d6fa;color:#5f259f}.upi-app-shortcut[data-upi-app="paytm"]{background:#eff8ff;border-color:#cfe9fb;color:#0874b9}.upi-app-shortcut[data-upi-app="bhim"]{background:#fff7ed;border-color:#fed7aa;color:#c45b19}
.upi-reference-form{display:grid;gap:10px;max-width:600px;margin-top:20px}.upi-reference-form>strong{margin-bottom:3px}.upi-reference-form .form-control{min-height:46px;border-radius:11px}
.payment-message{margin-top:14px;padding:14px 16px;border:1px solid var(--pd-line);border-radius:13px;background:var(--sb-card-2,#f8fafc);color:var(--sb-text,#172033);line-height:1.5}.payment-message.error{border-color:rgba(220,38,38,.24);background:rgba(220,38,38,.08);color:#b91c1c}
.payment-actions,.actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-top:20px}.payment-actions form{margin:0}
.payment-detail .button{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:46px;padding:12px 17px;border:1px solid transparent;border-radius:12px;background:linear-gradient(115deg,#2563eb,#5b4be8);color:#fff;font-weight:850;text-decoration:none;box-shadow:0 8px 20px rgba(37,99,235,.16);transition:transform .18s,box-shadow .18s,filter .18s;cursor:pointer}
.payment-detail .button:hover{color:#fff;filter:brightness(1.06);transform:translateY(-2px);box-shadow:0 12px 25px rgba(37,99,235,.22)}
.payment-detail .button.secondary{border-color:var(--pd-line);background:var(--sb-surface,#fff);color:var(--sb-text,#172033);box-shadow:none}.payment-detail .button.secondary:hover{color:var(--sb-text,#172033);border-color:rgba(99,102,241,.4);box-shadow:0 8px 20px rgba(15,23,42,.06)}
.button.is-processing{cursor:wait;opacity:.85}.button.is-processing:before{content:"";display:inline-block;width:13px;height:13px;border:2px solid rgba(255,255,255,.45);border-top-color:#fff;border-radius:50%;animation:verifySpin .7s linear infinite}
.payment-success-overlay{position:fixed;inset:0;z-index:9999;display:grid;place-items:center;padding:20px;background:rgba(15,23,42,.68);backdrop-filter:blur(7px)}.payment-success-overlay[hidden]{display:none}
.payment-success-popup{width:min(100%,440px);padding:30px;border-radius:25px;background:#fff;text-align:center;box-shadow:0 24px 80px rgba(15,23,42,.28);animation:verifySuccess .4s ease both}
.payment-success-popup__icon{display:grid;place-items:center;width:76px;height:76px;margin:0 auto 16px;border-radius:50%;background:#dcfce7;color:#15803d;font-size:32px}
.payment-success-popup h2{margin:0 0 8px;color:#172033;font-size:1.5rem;font-weight:900}.payment-success-popup p{margin:0 0 20px;color:#64748b;line-height:1.55}.payment-success-popup .button{width:100%}
@keyframes verifyPulse{50%{transform:scale(1.06);box-shadow:0 0 0 8px rgba(49,91,232,.08)}}@keyframes verifySuccess{from{transform:scale(.85);opacity:.45}to{transform:scale(1);opacity:1}}@keyframes verifyDot{to{opacity:.35;transform:translateY(-3px)}}@keyframes verifySpin{to{transform:rotate(360deg)}}
@media(max-width:650px){.payment-detail{padding:13px}.detail-card{border-radius:20px}.detail-head{display:block}.detail-head .status{margin-top:12px}.detail-grid{grid-template-columns:1fr}.payment-actions>*,.actions>*{width:100%;text-align:center}.payment-actions form,.payment-actions form button{width:100%}.legacy-upi-card{padding:14px}.verify-flow{align-items:flex-start}.verify-flow__orb{flex-basis:43px;width:43px;height:43px}.upi-app-shortcuts{gap:6px}}
@media(prefers-reduced-motion:reduce){.payment-detail *,.payment-detail *:before,.payment-detail *:after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}}
</style>
@endpush

@section('content')
@php($refund = $payment->refunds()->latest()->first())

<main class="payment-detail">
    <x-customer-page-hero subtitle="Secure transaction details and next steps for your Smart Basket order.">
        <div class="detail-head">
            <div class="payment-hero-copy"><span class="eyebrow">SMART BASKET · SECURE CHECKOUT</span><h1 class="sb-customer-page-title"><i class="fa-solid fa-receipt me-2" aria-hidden="true"></i>Payment Details</h1><p class="payment-hero-reference">Transaction reference <strong>#{{ $payment->id }}</strong> <span aria-hidden="true">·</span> Review your payment, status and order details in one place.</p></div>
            <span class="status {{ $payment->status }}" id="paymentStatusBadge">{{ ucfirst(str_replace('_', ' ', $payment->status)) }}</span>
        </div>
    </x-customer-page-hero>

    <section class="detail-card">
        @if(session('error'))<div class="notice" role="alert">{{ session('error') }}</div>@endif
        @if(session('success'))<div class="notice notice--success" role="status">{{ session('success') }}</div>@endif

        <div class="payment-summary"><span>Payment total</span><strong>{{ $payment->currency }} {{ number_format((float)$payment->amount, 2) }}</strong><small>{{ ucfirst($payment->payment_method) }} payment · {{ ucfirst($payment->gateway) }}</small></div>
        <h2 class="section-heading">Transaction details</h2>
        <div class="detail-grid">
            <div><span>Order ID</span><strong id="paymentOrderIds">{{ collect($payment->order_ids ?? [])->map(fn($id) => 'SB-'.$id)->implode(', ') ?: 'Order pending confirmation' }}</strong></div>
            <div><span>Payment ID</span><strong>#{{ $payment->id }}</strong></div>
            <div><span>Payment method</span><strong>{{ $payment->payment_method }}</strong></div>
            <div><span>Payment status</span><strong id="paymentStatusValue">{{ ucfirst(str_replace('_', ' ', $payment->status)) }}</strong></div>
            <div><span>Transaction ID</span><strong>{{ $payment->gateway_transaction_id ?: $payment->gateway_payment_id ?: 'Not available yet' }}</strong></div>
            <div><span>Payment date</span><strong>{{ ($payment->completed_at ?? $payment->verified_at ?? $payment->created_at)?->format('d M Y, h:i A') }}</strong></div>
            <div><span>Refund status</span><strong>{{ $refund ? ucfirst($refund->status) : 'Not requested' }}</strong></div>
            <div><span>Gateway order reference</span><strong>{{ $payment->gateway_order_id ?: 'Not available yet' }}</strong></div>
        </div>

        @if($payment->gateway !== 'seller_upi' && $payment->status === 'failed' && !$gatewayConfigured && empty($payment->gateway_order_id))
            <div class="notice notice--setup" role="alert"><strong>Online payment is not set up yet.</strong><p>Razorpay could not start this payment, so no gateway order was created. Go back to checkout and choose Cash on Delivery, or try UPI after the payment gateway is configured.</p></div>
        @elseif($payment->failure_reason)
            <div class="notice" role="alert"><strong>Payment update:</strong> {{ $payment->failure_reason }}</div>
        @endif

        @if($payment->status === 'paid')
            <div class="verify-flow" data-state="success" role="status" aria-live="polite"><div class="verify-flow__orb"><i class="fa-solid fa-check" aria-hidden="true"></i></div><div class="verify-flow__copy"><strong>Payment verified</strong><span>The payment provider confirmed this transaction and the order is recorded as paid.</span><div class="verify-flow__steps" aria-hidden="true"><i></i><i></i><i></i></div></div></div>
        @elseif($payment->status === 'manual_review' && $payment->gateway !== 'seller_upi')
            <div class="verify-flow" data-state="verifying" role="status" aria-live="polite"><div class="verify-flow__orb"><i class="fa-solid fa-clock" aria-hidden="true"></i></div><div class="verify-flow__copy"><strong>Payment needs review</strong><span>Your payment is recorded, but the order needs support review before it can be confirmed.</span></div></div>
        @endif

        @if($payment->gateway === 'seller_upi')
            <section class="legacy-upi-card">
                <h2>Pay each seller directly by UPI</h2><p>Choose your UPI app or scan the seller QR. Submit the UTR after paying; the order remains pending until the seller payment is verified.</p>
                <div class="legacy-upi-grid">
                    @foreach($sellerUpiPayments as $sellerPayment)
                        <article class="legacy-upi-seller">
                            <strong>{{ $sellerPayment['seller_name'] }}</strong><span>{{ $sellerPayment['upi_id'] }}</span><strong class="legacy-upi-amount">&#8377;{{ number_format((float)$sellerPayment['amount'], 2) }}</strong>
                            <div class="upi-app-shortcuts" aria-label="Choose a UPI app">
                                <a class="upi-app-shortcut" href="{{ $sellerPayment['upi_uri'] }}" data-upi-app="gpay" data-upi-uri="{{ $sellerPayment['upi_uri'] }}"><span class="upi-emoji" aria-hidden="true">🟢</span><span>Google Pay</span></a>
                                <a class="upi-app-shortcut" href="{{ $sellerPayment['upi_uri'] }}" data-upi-app="phonepe" data-upi-uri="{{ $sellerPayment['upi_uri'] }}"><span class="upi-emoji" aria-hidden="true">💜</span><span>PhonePe</span></a>
                                <a class="upi-app-shortcut" href="{{ $sellerPayment['upi_uri'] }}" data-upi-app="paytm" data-upi-uri="{{ $sellerPayment['upi_uri'] }}"><span class="upi-emoji" aria-hidden="true">🔵</span><span>Paytm</span></a>
                                <a class="upi-app-shortcut" href="{{ $sellerPayment['upi_uri'] }}" data-upi-app="bhim" data-upi-uri="{{ $sellerPayment['upi_uri'] }}"><span class="upi-emoji" aria-hidden="true">🇮🇳</span><span>BHIM UPI</span></a>
                            </div>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&amp;data={{ rawurlencode($sellerPayment['upi_uri']) }}" alt="UPI QR for {{ $sellerPayment['seller_name'] }}" width="220" height="220" loading="lazy">
                            <a class="button" href="{{ $sellerPayment['upi_uri'] }}">Open any UPI app</a>
                        </article>
                    @endforeach
                </div>
                @if($payment->status === 'pending')
                    <form method="POST" action="{{ route('payments.seller-upi-reference', $payment) }}" class="upi-reference-form">
                        @csrf<strong>After paying, enter the UPI reference (UTR) for each seller</strong>
                        @foreach($sellerUpiPayments as $sellerPayment)
                            <label for="upi-reference-{{ $sellerPayment['seller_id'] }}">{{ $sellerPayment['seller_name'] }} · &#8377;{{ number_format((float)$sellerPayment['amount'], 2) }}</label>
                            <input id="upi-reference-{{ $sellerPayment['seller_id'] }}" name="upi_references[{{ $sellerPayment['seller_id'] }}]" class="form-control" minlength="6" maxlength="50" pattern="[A-Za-z0-9-]+" required placeholder="UPI transaction reference / UTR" autocomplete="off">
                            @error('upi_references.' . $sellerPayment['seller_id'])<span class="text-danger">{{ $message }}</span>@enderror
                        @endforeach
                        <button class="button" type="submit">Submit payment reference</button>
                    </form>
                @elseif($payment->status === 'manual_review')
                    <div class="verify-flow" data-state="verifying" role="status" aria-live="polite"><div class="verify-flow__orb"><i class="fa-solid fa-clock" aria-hidden="true"></i></div><div class="verify-flow__copy"><strong>Payment reference submitted</strong><span>Your reference is saved and waiting for admin verification. This is a pending status, not payment confirmation.</span></div></div>
                @endif
            </section>
        @endif

        @if($gatewayReady)
            <div class="verify-flow" id="verifyFlow" data-state="ready" role="status" aria-live="polite"><div class="verify-flow__orb"><i class="fa-solid fa-shield-halved" id="verifyFlowIcon" aria-hidden="true"></i></div><div class="verify-flow__copy"><strong id="verifyFlowTitle">Secure payment verification</strong><span id="verifyFlowText">After you pay, Smart Basket checks the payment directly with the provider before confirming your order.</span><div class="verify-flow__steps" aria-hidden="true"><i></i><i></i><i></i></div></div></div>
            <div class="payment-message" id="paymentMessage" role="status" aria-live="polite">Continue in Razorpay's secure checkout. Your order is created only after the server verifies the payment.</div>
            <div class="payment-actions"><button class="button" id="payNowBtn" type="button"><i class="fa-solid fa-lock" aria-hidden="true"></i>Continue to secure payment</button><form method="POST" action="{{ route('payments.cancel', $payment) }}">@csrf<button class="button secondary" type="submit">Cancel payment</button></form></div>
        @elseif($payment->gateway === 'seller_upi' && in_array($payment->status, ['failed','cancelled','expired'], true) && empty($payment->order_ids))
            <div class="payment-actions"><a class="button" href="{{ route('checkout') }}">Start checkout again</a></div>
        @elseif($payment->gateway !== 'seller_upi' && in_array($payment->status, ['failed','cancelled','expired'], true) && empty($payment->order_ids))
            <div class="payment-actions">@if(!$gatewayConfigured)<a class="button" href="{{ route('checkout') }}">Back to checkout</a>@else<form method="POST" action="{{ route('payments.retry', $payment) }}">@csrf<button class="button" type="submit"><i class="fa-solid fa-rotate-right" aria-hidden="true"></i>Retry payment</button></form>@endif</div>
        @endif

        <div class="actions"><a class="button secondary" href="{{ route('payments.index') }}">Back to payment history</a><a class="button secondary" href="{{ route('payments.receipt', $payment) }}">View receipt</a>@if($payment->status === 'paid')<a class="button" href="{{ route('orders.index') }}">View my orders</a>@endif</div>
    </section>

    @if($payment->gateway === 'seller_upi')
        <div class="payment-success-overlay" id="paymentSuccessPopup" role="dialog" aria-modal="true" aria-labelledby="paymentSuccessTitle" hidden><section class="payment-success-popup"><div class="payment-success-popup__icon"><i class="fa-solid fa-check" aria-hidden="true"></i></div><h2 id="paymentSuccessTitle">Payment successful!</h2><p>Your payment was verified by the admin and your order is confirmed.</p><a class="button" id="paymentSuccessOrdersLink" href="{{ route('orders.index') }}">View confirmed order</a></section></div>
    @endif
</main>

@if($payment->gateway === 'seller_upi')
<script>
(() => {
    const packages = {gpay:'com.google.android.apps.nbu.paisa.user',phonepe:'com.phonepe.app',paytm:'net.one97.paytm',bhim:'in.org.npci.upiapp'};
    if (!/Android/i.test(navigator.userAgent)) return;
    document.querySelectorAll('[data-upi-app][data-upi-uri]').forEach((link) => {
        try { const uri = new URL(link.dataset.upiUri); link.href = `intent://pay${uri.search}#Intent;scheme=upi;package=${packages[link.dataset.upiApp]};end`; } catch (_) {}
    });
})();
</script>
@endif

@if($payment->gateway === 'seller_upi' && $payment->status === 'manual_review')
<script>
(() => {
    const statusUrl = @json(route('payments.seller-upi-status', $payment));
    const popup = document.getElementById('paymentSuccessPopup'), badge = document.getElementById('paymentStatusBadge');
    const statusValue = document.getElementById('paymentStatusValue'), orderIds = document.getElementById('paymentOrderIds');
    const ordersLink = document.getElementById('paymentSuccessOrdersLink');
    let finished = false;
    const poll = async () => {
        if (finished) return;
        try {
            const response = await fetch(statusUrl,{credentials:'same-origin',headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},cache:'no-store'});
            if (!response.ok) return;
            const result = await response.json();
            if (result.status === 'paid') {
                finished = true;
                [badge,statusValue].forEach((el)=>{if(el)el.textContent='Paid';});
                if (orderIds && result.order_ids?.length) orderIds.textContent = result.order_ids.map((id)=>String(id).startsWith('SB-')?id:`SB-${id}`).join(', ');
                if (badge) badge.className='status paid';
                const flow=document.querySelector('.verify-flow[data-state="verifying"]');
                if(flow){flow.dataset.state='success';const title=flow.querySelector('.verify-flow__copy strong'),copy=flow.querySelector('.verify-flow__copy span'),icon=flow.querySelector('.verify-flow__orb i');if(title)title.textContent='Payment verified';if(copy)copy.textContent='Admin verified your UPI transfer. Your order is confirmed.';if(icon)icon.className='fa-solid fa-check';}
                if(ordersLink && result.orders_url) ordersLink.href=result.orders_url;
                if(popup) popup.hidden=false;
            } else if (['failed','cancelled','expired'].includes(result.status)) {
                finished=true;
                if(badge){badge.className='status failed';badge.textContent=result.status.charAt(0).toUpperCase()+result.status.slice(1);}
                if(statusValue)statusValue.textContent='Failed';
                const notice=document.createElement('div');notice.className='notice';notice.setAttribute('role','alert');notice.textContent=result.message||'The payment could not be verified.';
                document.querySelector('.payment-detail .detail-card')?.prepend(notice);
            }
        } catch (_) { /* Temporary network errors should not interrupt this page. */ }
    };
    poll(); window.setInterval(poll,2500);
})();
</script>
@endif

@if($gatewayReady)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
(() => {
    const button=document.getElementById('payNowBtn'),message=document.getElementById('paymentMessage'),flow=document.getElementById('verifyFlow');
    const flowTitle=document.getElementById('verifyFlowTitle'),flowText=document.getElementById('verifyFlowText'),flowIcon=document.getElementById('verifyFlowIcon');
    let processing=false;
    const setFlow=(state,title,text,icon)=>{if(flow)flow.dataset.state=state;if(flowTitle)flowTitle.textContent=title;if(flowText)flowText.textContent=text;if(flowIcon)flowIcon.className=`fa-solid ${icon}`;};
    const verifyPayment=async(response)=>{
        const result=await fetch(@json(route('payments.verify',$payment)),{method:'POST',credentials:'same-origin',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'X-Requested-With':'XMLHttpRequest'},body:JSON.stringify(response)});
        const data=await result.json();
        if(!result.ok||!data.success){if(data.status==='pending')setFlow('verifying','Payment is still processing','The provider has not confirmed the final result yet. Please wait a moment before trying again.','fa-clock');throw new Error(data.message||'Payment verification failed.');}
        return data;
    };
    if(!button)return;
    button.addEventListener('click',()=>{
        if(processing)return;
        if(typeof window.Razorpay!=='function'){message.classList.add('error');message.textContent='Secure checkout could not load. Please refresh the page and try again.';return;}
        processing=true;button.disabled=true;button.classList.add('is-processing');button.textContent='Waiting for secure payment...';
        message.classList.remove('error');message.textContent='Complete the payment in Razorpay. Smart Basket is waiting for server-side verification.';
        setFlow('waiting','Waiting for your payment','Finish payment and any bank approval in the secure provider window.','fa-lock');
        const checkout=new Razorpay({
            key:@json($razorpayKey),amount:@json((int)$payment->amount_paise),currency:@json($payment->currency),
            name:'Smart Basket',description:'Order payment',order_id:@json($payment->gateway_order_id),
            @if(strtoupper((string)$payment->payment_method)==='UPI')
            config:{display:{blocks:{upi:{name:'Pay using UPI',instruments:[{method:'upi'}]}},sequence:['block.upi'],preferences:{show_default_blocks:false}}},
            @endif
            prefill:{name:@json($payment->customer_details['name']??''),contact:@json($payment->customer_details['mobile']??'')},
            handler:async(response)=>{
                message.textContent='Payment received. Verifying with the payment provider...';
                setFlow('verifying','Verifying payment','Checking the transaction, amount, and bank confirmation with the payment provider.','fa-spinner');
                try{const data=await verifyPayment(response);message.textContent='Payment verified. Redirecting to your confirmed order...';setFlow('success','Payment verified','The provider confirmed your payment. Your order is confirmed; opening the order page now.','fa-check');window.setTimeout(()=>window.location.assign(data.redirect),950);}
                catch(error){processing=false;button.disabled=false;button.classList.remove('is-processing');button.innerHTML='<i class="fa-solid fa-rotate-right" aria-hidden="true"></i> Try payment again';message.classList.add('error');message.textContent=error.message;if(!flow||flow.dataset.state!=='verifying')setFlow('error','Payment was not verified','The provider did not confirm this transaction. Check its status before retrying.','fa-xmark');}
            },
            modal:{ondismiss:()=>{processing=false;button.disabled=false;button.classList.remove('is-processing');button.innerHTML='<i class="fa-solid fa-lock" aria-hidden="true"></i> Continue to secure payment';message.textContent='Payment was not confirmed. You can retry securely.';setFlow('ready','Payment not completed','No successful payment was confirmed. You can securely try again.','fa-shield-halved');}}
        });
        checkout.on('payment.failed',(event)=>{processing=false;button.disabled=false;button.classList.remove('is-processing');button.innerHTML='<i class="fa-solid fa-rotate-right" aria-hidden="true"></i> Try payment again';message.classList.add('error');message.textContent=event.error?.description||'The payment did not complete.';setFlow('error','Payment failed','The payment provider reported that this attempt did not complete. You can retry securely.','fa-xmark');});
        checkout.open();
    });
})();
</script>
@endif
@endsection
