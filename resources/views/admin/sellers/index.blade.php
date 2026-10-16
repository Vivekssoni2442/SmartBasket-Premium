@extends('layouts.admin')
@section('title', 'Sellers')
@section('content')
<div class="admin-page-header"><div><h1 class="admin-page-title"><i class="fas fa-store"></i> Seller accounts</h1><p class="admin-page-description">Manage seller access separately from verification and approval status. Products and transaction history are retained.</p></div><a class="admin-btn admin-btn-primary" href="{{ route('admin.seller-verifications.index') }}">Review KYC</a></div>
@if(session('success'))<div class="admin-card" role="status">{{ session('success') }}</div>@endif
@if(session('error'))<div class="admin-card" role="alert">{{ session('error') }}</div>@endif
<div class="admin-toolbar"><a class="admin-btn admin-btn-secondary" href="{{ route('admin.sellers.index') }}">All sellers</a><a class="admin-btn admin-btn-secondary" href="{{ route('admin.sellers.index', ['status'=>'blocked']) }}">Blocked sellers</a><a class="admin-btn admin-btn-secondary" href="{{ route('admin.sellers.index', ['deleted'=>1]) }}">Deactivated sellers</a></div>
<form class="admin-toolbar" method="GET" action="{{ route('admin.sellers.index') }}">
    @if(request('deleted'))<input type="hidden" name="deleted" value="1">@endif
    <input class="admin-input" name="search" value="{{ request('search') }}" placeholder="Seller, shop, email, or phone" aria-label="Search sellers">
    <select class="admin-select" name="status" aria-label="Account status"><option value="">All account states</option><option value="active" @selected(request('status')==='active')>Active</option><option value="blocked" @selected(request('status')==='blocked')>Blocked</option></select>
    <select class="admin-select" name="verification_status" aria-label="Verification status"><option value="">All verification states</option>@foreach(['draft','pending_email','documents_pending','pending_admin_review','under_review','approved','active','rejected','suspended'] as $status)<option value="{{ $status }}" @selected(request('verification_status')===$status)>{{ ucfirst(str_replace('_',' ',$status)) }}</option>@endforeach</select>
    <select class="admin-select" name="sort" aria-label="Sort sellers"><option value="created_at">Recently joined</option><option value="seller_name" @selected(request('sort')==='seller_name')>Name</option><option value="email" @selected(request('sort')==='email')>Email</option><option value="verification_status" @selected(request('sort')==='verification_status')>Verification</option></select>
    <select class="admin-select" name="direction" aria-label="Sort direction"><option value="desc" @selected(request('direction','desc')==='desc')>Descending</option><option value="asc" @selected(request('direction')==='asc')>Ascending</option></select>
    <button class="admin-btn admin-btn-primary" type="submit">Search and filter</button>
</form>
<div class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Seller</th><th>Shop</th><th>Account status</th><th>Verification</th><th>Joined</th><th>Actions</th></tr></thead><tbody>
@forelse($sellers as $seller)
<tr>
    <td>{{ $seller->seller_name }}<br><small>{{ $seller->email }}</small></td><td>{{ $seller->shop_name ?: 'Not provided' }}</td>
    <td>@if($seller->trashed())<span class="admin-badge admin-badge-danger">Deactivated</span>@elseif($seller->isBlocked())<span class="admin-badge admin-badge-danger">Blocked</span><br><small>{{ $seller->blocked_at?->format('d M Y') }} · {{ $seller->block_reason }}</small>@else<span class="admin-badge admin-badge-success">Active</span>@endif</td>
    <td><span class="admin-badge admin-badge-{{ $seller->getApplicationStatusClass()==='success'?'success':($seller->getApplicationStatusClass()==='danger'?'danger':'warning') }}">{{ $seller->getApplicationStatusLabel() }}</span></td>
    <td>{{ $seller->created_at?->format('d M Y') }}</td>
    <td style="min-width:245px;display:flex;gap:6px;flex-wrap:wrap">
        @if(!$seller->trashed())
            <a class="admin-btn admin-btn-secondary" href="{{ route('admin.sellers.show',$seller) }}">View</a>
            @if($seller->isBlocked())<form method="POST" action="{{ route('admin.sellers.unblock',$seller) }}">@csrf<button class="admin-btn admin-btn-primary" type="submit">Unblock</button></form>
            @else<form method="POST" action="{{ route('admin.sellers.block',$seller) }}" onsubmit="return confirm('Block this seller account?');">@csrf<label class="sr-only" for="reason-seller-{{ $seller->id }}">Reason for blocking</label><input id="reason-seller-{{ $seller->id }}" name="reason" required minlength="3" maxlength="500" placeholder="Block reason" class="admin-input" style="width:130px"><button class="admin-btn admin-btn-secondary" type="submit">Block</button></form>@endif
            <form method="POST" action="{{ route('admin.sellers.delete',$seller) }}" onsubmit="return confirm('Deactivate this seller account? Products, orders and financial history will be retained.');">@csrf @method('DELETE')<label class="sr-only" for="confirm-seller-{{ $seller->id }}">Type DELETE to confirm deactivation</label><input id="confirm-seller-{{ $seller->id }}" name="confirmation" required pattern="DELETE" placeholder="Type DELETE" class="admin-input" style="width:110px"><button class="admin-btn admin-btn-danger" type="submit" title="Super administrator only">Deactivate</button></form>
        @else<form method="POST" action="{{ route('admin.sellers.restore',$seller->id) }}" onsubmit="return confirm('Restore this seller account?');">@csrf<button class="admin-btn admin-btn-primary" type="submit" title="Super administrator only">Restore</button></form>@endif
    </td>
</tr>
@empty<tr><td colspan="6"><div class="admin-empty"><i class="fas fa-store"></i>No sellers match these filters.</div></td></tr>@endforelse
</tbody></table></div><div class="admin-pagination">{{ $sellers->links() }}</div></div>
@endsection
