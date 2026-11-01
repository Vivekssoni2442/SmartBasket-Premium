@extends('layouts.admin')
@section('title','Transactions')
@section('content')
<div class="admin-page-header">
	<div>
		<h1 class="admin-page-title"><i class="fas fa-money-check-dollar"></i>Transactions</h1>
		<p class="admin-page-description">Gateway transactions, seller-verified UPI payments, and refunds.</p>
	</div>
</div>
<form class="admin-toolbar" method="GET">
	<input class="admin-input" name="search" value="{{ request('search') }}" placeholder="Order or payment ID">
	<select class="admin-select" name="status">
		<option value="">All statuses</option>
		@foreach(['pending','processing','paid','failed','cancelled','expired','manual_review','amount_mismatch'] as $status)
			<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
		@endforeach
	</select>
	<button class="admin-btn admin-btn-primary" type="submit">Filter</button>
</form>
<div class="admin-card">
	<div class="admin-table-wrap">
		<table class="admin-table">
			<thead><tr><th>Transaction</th><th>Customer</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th><th>Review / Refund</th></tr></thead>
			<tbody>
			@forelse($transactions as $transaction)
				@php
					$refunds = $transaction->payment?->refunds ?? collect();
					$reservedRefundPaise = $refunds->where('status', '!=', 'failed')->sum(fn ($refund) => (int) round((float) $refund->amount * 100));
					$remainingRefundPaise = max(0, (int) $transaction->amount_paise - $reservedRefundPaise);
				@endphp
				<tr>
					<td>#{{ $transaction->id }}<br><small>{{ $transaction->gateway_payment_id ?: $transaction->gateway_order_id ?: 'Gateway reference pending' }}</small></td>
					<td>{{ $transaction->user?->name ?? 'Guest / removed user' }}</td>
					<td>₹{{ number_format((float) ($transaction->amount ?? (($transaction->amount_paise ?? 0) / 100)), 2) }}</td>
					<td>{{ ucfirst($transaction->payment_method) }}</td>
					<td><span class="admin-badge admin-badge-{{ in_array($transaction->status, ['paid', 'verified']) ? 'success' : ($transaction->status === 'failed' ? 'danger' : 'warning') }}">{{ ucfirst(str_replace('_', ' ', $transaction->status)) }}</span></td>
					<td>{{ $transaction->created_at?->format('d M Y, h:i A') }}</td>
					<td>
						@if($transaction->gateway === 'seller_upi')
							<small>UTR: {{ $transaction->gateway_transaction_id ?: 'Not submitted' }}</small><br>
							@foreach(($transaction->request_metadata['seller_payments'] ?? []) as $sellerPayment)
								@php($sellerReviewStatus = $transaction->request_metadata['seller_upi_reviews'][(string) $sellerPayment['seller_id']]['status'] ?? 'pending')
								<small>Seller review: {{ ucfirst($sellerReviewStatus) }}</small><br>
								<small>{{ $sellerPayment['seller_name'] }} · ₹{{ number_format((float)$sellerPayment['amount'], 2) }} · UTR {{ $transaction->request_metadata['upi_references'][$sellerPayment['seller_id']] ?? '—' }}</small><br>
							@endforeach
						@endif
						@if($refunds->isNotEmpty())
							<small>Latest: {{ ucfirst(str_replace('_', ' ', $refunds->sortByDesc('created_at')->first()->status)) }}</small><br>
						@endif
						@if($transaction->gateway === 'seller_upi')
							<small class="text-warning">Refund offline through the seller; provider refunds are unavailable for direct UPI transfers.</small>
						@elseif($transaction->status === 'paid' && $transaction->payment_id && $remainingRefundPaise > 0)
							@php($refundKey = (string) \Illuminate\Support\Str::uuid())
							<form method="POST" action="{{ route('admin.transactions.refund', $transaction) }}">
								@csrf
								<input type="hidden" name="idempotency_key" value="{{ $refundKey }}">
								<input type="number" name="amount" min="0.01" max="{{ number_format($remainingRefundPaise / 100, 2, '.', '') }}" step="0.01" value="{{ number_format($remainingRefundPaise / 100, 2, '.', '') }}" required aria-label="Refund amount">
								<input type="text" name="reason" maxlength="255" placeholder="Reason" aria-label="Refund reason">
								<button class="admin-btn admin-btn-secondary" type="submit">Request refund</button>
							</form>
						@else
							—
						@endif
					</td>
				</tr>
			@empty
				<tr><td colspan="7"><div class="admin-empty"><i class="fas fa-credit-card"></i>No payment transactions match this view.</div></td></tr>
			@endforelse
			</tbody>
		</table>
	</div>
	<div class="admin-pagination">{{ $transactions->links() }}</div>
</div>
@endsection
