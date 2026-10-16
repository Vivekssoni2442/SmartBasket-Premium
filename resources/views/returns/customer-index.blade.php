@extends('layouts.app')
@section('title', 'Return requests')
@section('content')
<main class="container-fluid py-4">
    <x-customer-page-hero>
<h1 class="h3 mb-3 sb-customer-page-title">Return / Refund Requests</h1>
</x-customer-page-hero>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card border-0 shadow-sm"><div class="table-responsive"><table class="table align-middle mb-0">
        <thead><tr><th>Request</th><th>Order</th><th>Products</th><th>Status</th><th>Requested</th></tr></thead>
        <tbody>
        @forelse($returns as $return)
            <tr><td><a href="{{ route('returns.show', $return) }}">Return #{{ $return->id }}</a></td><td>#{{ $return->order_id }}</td><td>{{ collect($return->items)->pluck('name')->join(', ') }}</td><td><span class="badge text-bg-{{ $return->status === 'rejected' ? 'danger' : (in_array($return->status, ['refunded', 'approved']) ? 'success' : 'primary') }}">{{ ucfirst(str_replace('_', ' ', $return->status)) }}</span></td><td>{{ $return->created_at->format('d M Y') }}</td></tr>
        @empty<tr><td colspan="5" class="text-center py-5">You have no return requests.</td></tr>@endforelse
        </tbody>
    </table></div></div>
    <div class="mt-3">{{ $returns->links() }}</div>
</main>
@endsection
