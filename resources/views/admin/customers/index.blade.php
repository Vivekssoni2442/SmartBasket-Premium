@extends('layouts.admin')
@section('title', 'Customers')
@section('content')
<div class="admin-page-header">
    <div><h1 class="admin-page-title"><i class="fas fa-users"></i> Customer accounts</h1><p class="admin-page-description">Manage customer access while retaining their orders and payment history.</p></div>
</div>
@if(session('success'))<div class="admin-card" role="status">{{ session('success') }}</div>@endif
@if(session('error'))<div class="admin-card" role="alert">{{ session('error') }}</div>@endif
<nav class="admin-toolbar" aria-label="Customer account filters">
    <a class="admin-btn admin-btn-secondary" href="{{ route('admin.customers.index') }}">All customers</a>
    <a class="admin-btn admin-btn-secondary" href="{{ route('admin.customers.index', ['status' => 'blocked']) }}">Blocked customers</a>
    <a class="admin-btn admin-btn-secondary" href="{{ route('admin.customers.index', ['deleted' => 1]) }}">Deactivated customers</a>
</nav>
<form class="admin-toolbar" method="GET" action="{{ route('admin.customers.index') }}">
    @if(request('deleted'))<input type="hidden" name="deleted" value="1">@endif
    <input class="admin-input" name="search" value="{{ request('search') }}" placeholder="Search name or email" aria-label="Search customers">
    <select class="admin-select" name="status" aria-label="Account status"><option value="">All account states</option><option value="active" @selected(request('status') === 'active')>Active</option><option value="blocked" @selected(request('status') === 'blocked')>Blocked</option></select>
    <select class="admin-select" name="sort" aria-label="Sort customers"><option value="created_at">Recently joined</option><option value="name" @selected(request('sort') === 'name')>Name</option><option value="email" @selected(request('sort') === 'email')>Email</option></select>
    <select class="admin-select" name="direction" aria-label="Sort direction"><option value="desc" @selected(request('direction', 'desc') === 'desc')>Descending</option><option value="asc" @selected(request('direction') === 'asc')>Ascending</option></select>
    <button class="admin-btn admin-btn-primary" type="submit">Search and filter</button>
</form>
<div class="admin-card"><div class="admin-table-wrap"><table class="admin-table">
<thead><tr><th>Customer</th><th>Contact</th><th>Joined</th><th>Orders</th><th>Account status</th><th>Actions</th></tr></thead><tbody>
@forelse($customers as $customer)
<tr>
    <td>{{ $customer->name }}<br><small>{{ $customer->customer_uid ?: 'CUS-'.$customer->id }}</small></td>
    <td>{{ $customer->email }}<br><small>{{ $customer->phone ?: 'No phone' }}</small></td>
    <td>{{ $customer->created_at?->format('d M Y') }}</td>
    <td>{{ $customer->orders_count }}</td>
    <td>
        @if($customer->trashed())<span class="admin-badge admin-badge-danger">Deactivated</span>
        @elseif($customer->isBlocked())<span class="admin-badge admin-badge-danger">Blocked</span><br><small>{{ $customer->blocked_at?->format('d M Y') }} · {{ $customer->block_reason }}</small>
        @else<span class="admin-badge admin-badge-success">Active</span>@endif
    </td>
    <td style="min-width:245px;display:flex;gap:6px;flex-wrap:wrap">
        @if(!$customer->trashed())
            <a class="admin-btn admin-btn-secondary" href="{{ route('admin.customers.show', $customer) }}">View</a>
            @if($customer->isBlocked())
                <form method="POST" action="{{ route('admin.customers.unblock', $customer) }}">@csrf<button class="admin-btn admin-btn-primary" type="submit">Unblock</button></form>
            @else
                <form method="POST" action="{{ route('admin.customers.block', $customer) }}" onsubmit="return confirm('Block this customer account?');">@csrf<label class="sr-only" for="reason-customer-{{ $customer->id }}">Reason for blocking</label><input id="reason-customer-{{ $customer->id }}" name="reason" required minlength="3" maxlength="500" placeholder="Block reason" class="admin-input" style="width:130px"><button class="admin-btn admin-btn-secondary" type="submit">Block</button></form>
            @endif
            <form method="POST" action="{{ route('admin.customers.delete', $customer) }}" onsubmit="return confirm('Deactivate this customer? Order and payment history will be retained.');">@csrf @method('DELETE')<label class="sr-only" for="confirm-customer-{{ $customer->id }}">Type DELETE to confirm deactivation</label><input id="confirm-customer-{{ $customer->id }}" name="confirmation" required pattern="DELETE" placeholder="Type DELETE" class="admin-input" style="width:110px"><button class="admin-btn admin-btn-danger" type="submit" title="Super administrator only">Deactivate</button></form>
        @else
            <form method="POST" action="{{ route('admin.customers.restore', $customer->id) }}" onsubmit="return confirm('Restore this customer account?');">@csrf<button class="admin-btn admin-btn-primary" type="submit" title="Super administrator only">Restore</button></form>
        @endif
    </td>
</tr>
@empty<tr><td colspan="6"><div class="admin-empty"><i class="fas fa-users"></i>No customers match these filters.</div></td></tr>@endforelse
</tbody></table></div><div class="admin-pagination">{{ $customers->links() }}</div></div>
@endsection
