@extends('layouts.customer')
@section('title', 'Payment Details | Smart Basket')
@section('page_title', 'Payment Details')
@push('styles')
<style>
.payment-detail{max-width:1050px;margin:auto;padding:28px}.detail-card{background:var(--sb-surface,#fff);border:1px solid var(--sb-border,rgba(15,23,42,.1));border-radius:22px;padding:25px;box-shadow:0 16px 45px rgba(15,23,42,.08)}.detail-head{display:flex;justify-content:space-between;gap:16px;align-items:start;margin-bottom:20px}.detail-head h1{color:var(--sb-text,#172033);margin:0;font-size:clamp(1.4rem,3vw,2rem);font-weight:800}.detail-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1px;background:var(--sb-border,rgba(15,23,42,.1));border:1px solid var(--sb-border,rgba(15,23,42,.1));border-radius:15px;overflow:hidden}.detail-grid div{background:var(--sb-surface,#fff);padding:15px}.detail-grid span{display:block;color:var(--sb-muted,#64748b);font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px}.detail-grid strong{color:var(--sb-text,#172033);overflow-wrap:anywhere}.status{padding:7px 11px;border-radius:99px;font-weight:800;background:rgba(245,158,11,.14);color:#b45309}.status.paid{background:rgba(22,163,74,.14);color:#15803d}.status.failed,.status.cancelled{background:rgba(220,38,38,.14);color:#b91c1c}.notice{margin:18px 0;padding:14px;border-radius:12px;background:rgba(220,38,38,.1);color:#b91c1c}.actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:20px}.button{border:0;border-radius:11px;padding:12px 16px;background:#2563eb;color:white;font-weight:750;text-decoration:none}.button.secondary{background:transparent;border:1px solid var(--sb-border,rgba(15,23,42,.18));color:var(--sb-text,#172033)}@media(max-width:650px){.payment-detail{padding:16px}.detail-head{display:block}.detail-head .status{display:inline-block;margin-top:10px}.detail-grid{grid-template-columns:1fr}.actions>*{width:100%;text-align:center}}
</style>
@endpush
@section('content')
@php($refund = $payment->refunds()->latest()->first())
<main class="payment-detail"><x-customer-page-hero subtitle="Secure transaction details for your Smart Basket order.">
<h1 class="sb-customer-page-title"><i class="fa-solid fa-receipt me-2"></i>Payment #{{ $payment->id }}</h1>
<span class="status {{ $payment->status }}">{{ ucfirst($payment->status) }}</span></x-customer-page-hero><section class="detail-card">
@if(session('error'))<div class="notice">{{ session('error') }}</div>@endif
<div class="detail-grid"><div><span>Order ID</span><strong>{{ collect($payment->order_ids ?? [])->map(fn($id) => 'SB-'.$id)->implode(', ') ?: 'Order pending confirmation' }}</strong></div><div><span>Payment ID</span><strong>#{{ $payment->id }}</strong></div><div><span>Amount</span><strong>{{ $payment->currency }} {{ number_format((float) $payment->amount, 2) }}</strong></div><div><span>Payment method</span><strong>{{ $payment->payment_method }}</strong></div><div><span>Gateway</span><strong>{{ ucfirst($payment->gateway) }}</strong></div><div><span>Payment status</span><strong>{{ ucfirst($payment->status) }}</strong></div><div><span>Transaction ID</span><strong>{{ $payment->gateway_transaction_id ?: $payment->gateway_payment_id ?: 'Not available' }}</strong></div><div><span>Payment date</span><strong>{{ ($payment->completed_at ?? $payment->verified_at ?? $payment->created_at)?->format('d M Y, h:i A') }}</strong></div><div><span>Refund status</span><strong>{{ $refund ? ucfirst($refund->status) : 'Not requested' }}</strong></div><div><span>Gateway order reference</span><strong>{{ $payment->gateway_order_id ?: 'Not available' }}</strong></div></div>
@if($payment->failure_reason)<div class="notice"><strong>Failure reason:</strong> {{ $payment->failure_reason }}</div>@endif
<div class="actions"><a class="button secondary" href="{{ route('payments.index') }}">Back to history</a><a class="button secondary" href="{{ route('payments.receipt', $payment) }}">View receipt</a></div></section></main>
@if($gatewayReady)
<div class="payment-message" id="paymentMessage" role="status" aria-live="polite">Continue in Razorpay's secure checkout. Your order is created only after the server verifies the payment.</div>
<div class="payment-actions"><button class="button" id="payNowBtn" type="button"><i class="fa-solid fa-lock me-1"></i>Pay securely</button><form method="POST" action="{{ route('payments.cancel', $payment) }}">@csrf<button class="button secondary" type="submit">Cancel payment</button></form></div>
@elseif(in_array($payment->status, ['failed','cancelled','expired'], true) && empty($payment->order_ids))
<div class="payment-actions"><form method="POST" action="{{ route('payments.retry', $payment) }}">@csrf<button class="button" type="submit"><i class="fa-solid fa-rotate-right me-1"></i>Retry Payment</button></form></div>
@endif
<div class="actions"><a class="button secondary" href="{{ route('payments.index') }}">Back to history</a><a class="button secondary" href="{{ route('payments.receipt', $payment) }}">View receipt</a></div></section></main>
@if($gatewayReady)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
(() => {
	const button = document.getElementById('payNowBtn');
	const message = document.getElementById('paymentMessage');
	let processing = false;

	const verifyPayment = async (response) => {
		const result = await fetch(@json(route('payments.verify', $payment)), {
			method: 'POST',
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/json',
				'Accept': 'application/json',
				'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
				'X-Requested-With': 'XMLHttpRequest'
			},
			body: JSON.stringify(response)
		});
		const data = await result.json();
		if (!result.ok || !data.success) {
			throw new Error(data.message || 'Payment verification failed.');
		}
		return data;
	};

	button.addEventListener('click', () => {
		if (processing) return;
		processing = true;
		button.disabled = true;
		button.textContent = 'Waiting for payment...';
		message.classList.remove('error');
		message.textContent = 'Complete the payment in Razorpay. Smart Basket is waiting for server-side verification.';

		const checkout = new Razorpay({
			key: @json($razorpayKey),
			amount: @json((int) $payment->amount_paise),
			currency: @json($payment->currency),
			name: 'Smart Basket',
			description: 'Order payment',
			order_id: @json($payment->gateway_order_id),
			prefill: {
				name: @json($payment->customer_details['name'] ?? ''),
				contact: @json($payment->customer_details['mobile'] ?? '')
			},
			handler: async (response) => {
				message.textContent = 'Payment received. Verifying with the payment provider...';
				try {
					const data = await verifyPayment(response);
					message.textContent = 'Payment verified. Redirecting to your confirmed order...';
					window.location.assign(data.redirect);
				} catch (error) {
					processing = false;
					button.disabled = false;
					button.innerHTML = '<i class="fa-solid fa-rotate-right me-1"></i>Try payment again';
					message.classList.add('error');
					message.textContent = error.message;
				}
			},
			modal: {
				ondismiss: () => {
					processing = false;
					button.disabled = false;
					button.innerHTML = '<i class="fa-solid fa-lock me-1"></i>Pay securely';
					message.textContent = 'Payment was not confirmed. You can retry securely.';
				}
			}
		});

		checkout.on('payment.failed', (event) => {
			processing = false;
			button.disabled = false;
			button.innerHTML = '<i class="fa-solid fa-rotate-right me-1"></i>Try payment again';
			message.classList.add('error');
			message.textContent = event.error?.description || 'The payment did not complete.';
		});

		checkout.open();
	});
})();
</script>
@endif
@endsection
