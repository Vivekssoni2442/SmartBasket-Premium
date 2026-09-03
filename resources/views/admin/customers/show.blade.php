@extends('layouts.admin')

@section('title', $user->name . ' - Customer Details')

@section('breadcrumbs')
    <span>/</span>
    <a href="{{ route('admin.customers.index') }}" style="color: var(--text-primary); text-decoration: none;">Customers</a>
    <span>/</span>
    <span style="color: var(--text-primary);">{{ $user->name }}</span>
@endsection

@section('extra-css')
<style>
    .admin-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .admin-info-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        backdrop-filter: blur(10px);
    }

    .admin-info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .admin-info-row:last-child {
        border-bottom: none;
    }

    .admin-info-label {
        color: var(--text-secondary);
        font-size: 13px;
        font-weight: 600;
    }

    .admin-info-value {
        color: var(--text-primary);
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .admin-grid-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<div style="margin-bottom: 25px;">
    <h1 style="margin: 0 0 8px 0; font-size: 28px; font-weight: 700;">{{ $user->name }}</h1>
    <p style="margin: 0; color: var(--text-secondary); font-size: 14px;">
        <i class="fas fa-user-circle" style="margin-right: 8px;"></i>
        Customer ID: <strong>{{ $user->customer_uid ?? $user->id }}</strong>
    </p>
</div>

<div class="admin-grid-2">
    <div class="admin-info-card">
        <div style="display: flex; align-items: center; margin-bottom: 15px;">
            <i class="fas fa-user" style="font-size: 16px; color: var(--primary-gold); margin-right: 8px;"></i>
            <h3 style="margin: 0; font-size: 16px; font-weight: 700;">Personal Information</h3>
        </div>
        <div class="admin-info-row">
            <span class="admin-info-label">Full Name</span>
            <span class="admin-info-value">{{ $user->name }}</span>
        </div>
        <div class="admin-info-row">
            <span class="admin-info-label">Email</span>
            <span class="admin-info-value">{{ $user->email }}</span>
        </div>
        <div class="admin-info-row">
            <span class="admin-info-label">Phone</span>
            <span class="admin-info-value">{{ $user->phone ?? '—' }}</span>
        </div>
        <div class="admin-info-row">
            <span class="admin-info-label">Joined</span>
            <span class="admin-info-value">{{ $user->created_at->format('M d, Y h:i A') }}</span>
        </div>
        <div class="admin-info-row">
            <span class="admin-info-label">Last Updated</span>
            <span class="admin-info-value">{{ $user->updated_at->format('M d, Y h:i A') }}</span>
        </div>
    </div>

    <div class="admin-info-card">
        <div style="display: flex; align-items: center; margin-bottom: 15px;">
            <i class="fas fa-map-marker-alt" style="font-size: 16px; color: var(--primary-gold); margin-right: 8px;"></i>
            <h3 style="margin: 0; font-size: 16px; font-weight: 700;">Address</h3>
        </div>
        <div class="admin-info-row">
            <span class="admin-info-label">City</span>
            <span class="admin-info-value">{{ $user->city ?? '—' }}</span>
        </div>
        <div class="admin-info-row">
            <span class="admin-info-label">State</span>
            <span class="admin-info-value">{{ $user->state ?? '—' }}</span>
        </div>
        <div class="admin-info-row">
            <span class="admin-info-label">Country</span>
            <span class="admin-info-value">{{ $user->country ?? '—' }}</span>
        </div>
        <div class="admin-info-row">
            <span class="admin-info-label">Pin Code</span>
            <span class="admin-info-value">{{ $user->pin_code ?? '—' }}</span>
        </div>
        <div class="admin-info-row">
            <span class="admin-info-label">Full Address</span>
            <span class="admin-info-value" style="text-align: right; max-width: 200px;">{{ $user->address ?? '—' }}</span>
        </div>
    </div>
</div>

<div class="admin-info-card">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
        <div style="display: flex; align-items: center;">
            <i class="fas fa-shopping-bag" style="font-size: 16px; color: var(--primary-gold); margin-right: 8px;"></i>
            <h3 style="margin: 0; font-size: 16px; font-weight: 700;">Order History</h3>
        </div>
        <span style="background: rgba(0,153,255,0.1); padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; color: #0099ff;">
            {{ $user->orders()->count() }} Orders
        </span>
    </div>
    
    @if($user->orders()->count() > 0)
        <div style="max-height: 300px; overflow-y: auto;">
            @foreach($user->orders()->latest()->take(10)->get() as $order)
            <div style="padding: 12px 0; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="color: var(--text-primary); font-weight: 600; font-size: 13px;">
                        Order #{{ $order->id }}
                    </div>
                    <div style="color: var(--text-secondary); font-size: 12px;">
                        {{ $order->created_at->format('M d, Y') }}
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="color: var(--primary-gold); font-weight: 700;">
                        ₹{{ number_format($order->amount, 0) }}
                    </div>
                    <div style="font-size: 12px;">
                        <span style="background: {{ $order->order_status === 'completed' ? 'rgba(0,208,132,0.2)' : 'rgba(255,165,2,0.2)' }}; padding: 2px 6px; border-radius: 4px; color: {{ $order->order_status === 'completed' ? '#00d084' : '#ffa502' }};">
                            {{ ucfirst($order->order_status ?? 'pending') }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div style="text-align: center; padding-top: 12px;">
            <a href="{{ route('admin.orders.index', ['customer' => $user->id]) }}" style="color: var(--primary-gold); text-decoration: none; font-size: 13px; font-weight: 600;">
                View all orders →
            </a>
        </div>
    @else
        <div style="text-align: center; padding: 40px 20px; color: var(--text-secondary);">
            <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 12px; display: block;"></i>
            No orders yet
        </div>
    @endif
</div>

@endsection
