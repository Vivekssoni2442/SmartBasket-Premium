@extends('layouts.admin')
@section('title', 'Returns & Refunds')
@section('content')
<div class="admin-page-header"><div><h1 class="admin-page-title"><i class="fas fa-arrow-rotate-left"></i>Returns &amp; Refunds</h1><p class="admin-page-description">Review customer return requests and submit provider-backed refunds.</p></div></div>
@if(session('success'))<div class="admin-alert admin-alert-success" role="status">{{ session('success') }}</div>@endif
@if(session('error'))<div class="admin-alert admin-alert-error" role="alert">{{ session('error') }}</div>@endif
@if($errors->any())<div class="admin-alert admin-alert-error" role="alert">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
<div class="admin-card">
    <form method="GET" class="d-flex flex-wrap gap-2 mb-3">
        <label class="sr-only" for="returns-search">Search by request, order, or customer</label><input id="returns-search" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Request, order, or customer">
        <label class="sr-only" for="returns-status">Filter by status</label><select id="returns-status" name="status" class="admin-input"><option value="">All statuses</option>@foreach(['requested','approved','rejected','refund_pending','refunded','cancelled'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst(str_replace('_',' ',$status)) }}</option>@endforeach</select><button class="admin-btn admin-btn-primary">Filter</button>
        <label for="returns-from">From</label><input id="returns-from" type="date" name="from" value="{{ request('from') }}" class="admin-input">
        <label for="returns-to">To</label><input id="returns-to" type="date" name="to" value="{{ request('to') }}" class="admin-input">
    </form>
    <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Request / Order</th><th>Customer</th><th>Products &amp; quantity</th><th>Reason</th><th>Status / refund</th><th>Review</th></tr></thead><tbody>
    @forelse($returns as $return)
        <tr><td><a href="{{ route('admin.returns.show', $return) }}">Return #{{ $return->id }}</a><br><a href="{{ route('admin.orders.show', $return->order) }}">Order #{{ $return->order_id }}</a></td><td>{{ $return->customer?->name ?? 'Customer account unavailable' }}<br><small>{{ $return->customer?->email }}</small></td>
            <td>@foreach($return->items as $item)<div>{{ $item['name'] ?? 'Product' }} × {{ $item['quantity'] ?? 0 }}</div>@endforeach</td>
            <td>{{ ucfirst(str_replace('_',' ',$return->reason)) }}@if($return->description)<br><small>{{ $return->description }}</small>@endif</td>
            <td>{{ ucfirst(str_replace('_',' ',$return->status)) }}@if($return->refund_amount)<br>₹{{ number_format((float)$return->refund_amount,2) }}@endif</td>
            <td>
                @if($return->status === 'requested')
                    <form method="POST" action="{{ route('admin.returns.review',$return) }}" class="d-grid gap-2 mb-2">@csrf @method('PATCH')<textarea name="note" class="admin-input" rows="2" maxlength="2000" required placeholder="Decision note for customer"></textarea><button class="admin-btn admin-btn-primary" name="decision" value="approved">Approve return</button><button class="admin-btn admin-btn-danger" name="decision" value="rejected">Reject return</button></form>
                @elseif($return->status === 'approved')
                    @if($return->order?->isCashOnDelivery())<small class="text-secondary">COD return: provider refund unavailable; follow offline cash refund process.</small>@else<form method="POST" action="{{ route('admin.returns.refund',$return) }}" onsubmit="return confirm('Submit the calculated refund to the payment provider?')">@csrf<button class="admin-btn admin-btn-primary">Process provider refund</button></form>@endif
                @else
                    <small>{{ $return->decision_note }}</small>
                @endif
            </td>
        </tr>
    @empty<tr><td colspan="6"><div class="admin-empty">No customer return requests found.</div></td></tr>@endforelse
    </tbody></table></div><div class="admin-pagination">{{ $returns->links() }}</div>
</div>
@endsection
