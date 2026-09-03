@extends('layouts.admin')

@section('title', 'Admin Dashboard - SmartBasket')

@section('breadcrumbs')
    <span>/</span>
    <span style="color: var(--text-primary);">Dashboard</span>
@endsection

@section('extra-css')
<style>
    .sb-dashboard {
        width: 100%;
    }

    .sb-dashboard-hero {
        position: relative;
        overflow: hidden;
        padding: 30px;
        margin-bottom: 24px;
        border: 1px solid rgba(255,215,0,.18);
        border-radius: 20px;
        background:
            radial-gradient(circle at 85% 20%, rgba(255,215,0,.13), transparent 30%),
            radial-gradient(circle at 10% 100%, rgba(147,51,234,.13), transparent 35%),
            var(--card-bg);
    }

    .sb-dashboard-hero::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: -70px;
        top: -80px;
        border: 1px solid rgba(255,215,0,.14);
        border-radius: 50%;
        pointer-events: none;
    }

    .sb-hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 25px;
    }

    .sb-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        color: var(--primary-gold);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .sb-eyebrow i {
        font-size: 8px;
    }

    .sb-hero-title {
        margin: 0 0 8px;
        font-size: clamp(25px, 3vw, 34px);
        line-height: 1.2;
        font-weight: 800;
        color: var(--text-primary);
    }

    .sb-hero-description {
        max-width: 720px;
        margin: 0;
        color: var(--text-secondary);
        font-size: 13px;
        line-height: 1.7;
    }

    .sb-admin-chip {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        border: 1px solid rgba(255,215,0,.18);
        border-radius: 14px;
        background: rgba(255,255,255,.025);
    }

    .sb-admin-avatar {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary-gold), #ffb300);
        color: #111;
        font-weight: 900;
    }

    .sb-admin-chip small {
        display: block;
        margin-bottom: 3px;
        color: var(--text-secondary);
        font-size: 10px;
    }

    .sb-admin-chip strong {
        display: block;
        color: var(--text-primary);
        font-size: 13px;
    }

    .sb-section-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin: 0 0 15px;
    }

    .sb-section-heading h2 {
        margin: 0;
        color: var(--text-primary);
        font-size: 17px;
        font-weight: 800;
    }

    .sb-section-heading h2 i {
        margin-right: 7px;
        color: var(--primary-gold);
    }

    .sb-section-heading span {
        color: var(--text-secondary);
        font-size: 11px;
    }

    .sb-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .sb-stat-card {
        position: relative;
        min-width: 0;
        overflow: hidden;
        display: block;
        padding: 19px;
        border: 1px solid var(--border-color);
        border-radius: 17px;
        background: var(--card-bg);
        color: var(--text-primary);
        text-decoration: none;
        transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
    }

    .sb-stat-card:hover {
        transform: translateY(-4px);
        border-color: rgba(255,215,0,.5);
        box-shadow: 0 14px 35px rgba(0,0,0,.18);
    }

    .sb-stat-card::after {
        content: "";
        position: absolute;
        right: -35px;
        bottom: -55px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--stat-glow);
        opacity: .08;
    }

    .sb-stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .sb-stat-label {
        margin-bottom: 8px;
        color: var(--text-secondary);
        font-size: 11px;
        font-weight: 600;
    }

    .sb-stat-number {
        color: var(--stat-color);
        font-size: 27px;
        font-weight: 900;
        line-height: 1.1;
        word-break: break-word;
    }

    .sb-stat-icon {
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: var(--stat-bg);
        color: var(--stat-color);
        font-size: 18px;
    }

    .sb-stat-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-top: 17px;
        color: var(--stat-color);
        font-size: 11px;
        font-weight: 700;
    }

    .sb-stat-bottom i {
        transition: transform .2s ease;
    }

    .sb-stat-card:hover .sb-stat-bottom i {
        transform: translateX(4px);
    }

    .sb-blue {
        --stat-color: #38a8ff;
        --stat-bg: rgba(56,168,255,.13);
        --stat-glow: #38a8ff;
    }

    .sb-green {
        --stat-color: #22c55e;
        --stat-bg: rgba(34,197,94,.13);
        --stat-glow: #22c55e;
    }

    .sb-orange {
        --stat-color: #f59e0b;
        --stat-bg: rgba(245,158,11,.13);
        --stat-glow: #f59e0b;
    }

    .sb-purple {
        --stat-color: #a855f7;
        --stat-bg: rgba(168,85,247,.13);
        --stat-glow: #a855f7;
    }

    .sb-red {
        --stat-color: #ef4444;
        --stat-bg: rgba(239,68,68,.13);
        --stat-glow: #ef4444;
    }

    .sb-gold {
        --stat-color: var(--primary-gold);
        --stat-bg: rgba(255,215,0,.13);
        --stat-glow: #ffd700;
    }

    .sb-card {
        border: 1px solid var(--border-color);
        border-radius: 17px;
        background: var(--card-bg);
    }

    .sb-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 19px 20px;
        border-bottom: 1px solid var(--border-color);
    }

    .sb-card-title {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--text-primary);
        font-size: 14px;
        font-weight: 800;
    }

    .sb-card-title i {
        color: var(--primary-gold);
    }

    .sb-card-link {
        color: var(--primary-gold);
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
    }

    .sb-card-link:hover {
        text-decoration: underline;
    }

    .sb-quick-card {
        margin-bottom: 25px;
    }

    .sb-quick-grid {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 10px;
        padding: 18px;
    }

    .sb-quick-action {
        min-width: 0;
        min-height: 94px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 12px 8px;
        border: 1px solid var(--border-color);
        border-radius: 13px;
        background: rgba(255,255,255,.018);
        color: var(--text-primary);
        text-align: center;
        text-decoration: none;
        transition: .22s ease;
    }

    .sb-quick-action i {
        color: var(--primary-gold);
        font-size: 20px;
    }

    .sb-quick-action span {
        font-size: 10px;
        font-weight: 700;
        line-height: 1.35;
    }

    .sb-quick-action:hover {
        transform: translateY(-3px);
        border-color: rgba(255,215,0,.45);
        background: rgba(255,215,0,.07);
    }

    .sb-lower-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 17px;
    }

    .sb-list {
        padding: 5px 18px 8px;
    }

    .sb-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 13px 2px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
        transition: .2s ease;
    }

    .sb-list-item:last-child {
        border-bottom: 0;
    }

    .sb-list-item:hover {
        padding-left: 5px;
    }

    .sb-list-main {
        min-width: 0;
    }

    .sb-list-title {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 12px;
        font-weight: 700;
    }

    .sb-list-sub {
        margin-top: 4px;
        color: var(--text-secondary);
        font-size: 10px;
    }

    .sb-list-value {
        flex: 0 0 auto;
        font-size: 11px;
        font-weight: 800;
    }

    .sb-status {
        padding: 5px 8px;
        border-radius: 999px;
        background: rgba(255,215,0,.08);
        color: var(--primary-gold);
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .sb-empty {
        padding: 30px 10px;
        color: var(--text-secondary);
        text-align: center;
        font-size: 11px;
    }

    .sb-empty i {
        display: block;
        margin-bottom: 8px;
        color: var(--primary-gold);
        font-size: 22px;
    }

    @media (max-width: 1200px) {
        .sb-stats-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .sb-quick-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 900px) {
        .sb-lower-grid {
            grid-template-columns: 1fr;
        }

        .sb-hero-content {
            align-items: flex-start;
            flex-direction: column;
        }

        .sb-admin-chip {
            width: 100%;
        }
    }

    @media (max-width: 700px) {
        .sb-dashboard-hero {
            padding: 21px;
        }

        .sb-stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
        }

        .sb-stat-card {
            padding: 15px;
        }

        .sb-stat-number {
            font-size: 22px;
        }

        .sb-stat-icon {
            width: 38px;
            height: 38px;
            flex-basis: 38px;
        }

        .sb-quick-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>
@endsection

@section('content')

@php
    $adminName = session('admin_name', 'Administrator');

    $totalCustomers = $stats['total_customers'] ?? 0;
    $totalSellers = $stats['total_sellers'] ?? 0;
    $pendingSellers = $stats['pending_sellers'] ?? 0;
    $totalRevenue = $stats['total_revenue'] ?? 0;
    $totalProducts = $stats['total_products'] ?? 0;
    $totalOrders = $stats['total_orders'] ?? 0;
    $approvedSellers = $stats['approved_sellers'] ?? 0;
    $pendingPayments = $stats['pending_payments'] ?? 0;

    $initials = collect(
        preg_split('/\s+/', trim((string) $adminName), -1, PREG_SPLIT_NO_EMPTY)
    )
    ->take(2)
    ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
    ->implode('');

    $initials = $initials ?: 'A';
@endphp

<div class="sb-dashboard">

    {{-- HERO --}}
    <section class="sb-dashboard-hero">

        <div class="sb-hero-content">

            <div>
                <div class="sb-eyebrow">
                    <i class="fas fa-circle"></i>
                    SmartBasket Control Center
                </div>

                <h1 class="sb-hero-title">
                    Welcome back, {{ $adminName }} 👑
                </h1>

                <p class="sb-hero-description">
                    Monitor your complete e-commerce platform from one place.
                    Manage customers, sellers, products, orders, payments,
                    analytics and security.
                </p>
            </div>

            <div class="sb-admin-chip">
                <div class="sb-admin-avatar">
                    {{ $initials }}
                </div>

                <div>
                    <small>Administrator</small>
                    <strong>{{ $adminName }}</strong>
                </div>
            </div>

        </div>

    </section>


    {{-- STATS --}}
    <div class="sb-section-heading">
        <h2>
            <i class="fas fa-chart-pie"></i>
            Platform Overview
        </h2>

        <span>Live dashboard metrics</span>
    </div>

    <div class="sb-stats-grid">

        <a href="{{ route('admin.customers.index') }}" class="sb-stat-card sb-blue">
            <div class="sb-stat-top">
                <div>
                    <div class="sb-stat-label">Total Customers</div>
                    <div class="sb-stat-number">{{ number_format($totalCustomers) }}</div>
                </div>
                <div class="sb-stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <div class="sb-stat-bottom">
                <span>View customers</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>


        <a href="{{ route('admin.sellers.index') }}" class="sb-stat-card sb-green">
            <div class="sb-stat-top">
                <div>
                    <div class="sb-stat-label">Total Sellers</div>
                    <div class="sb-stat-number">{{ number_format($totalSellers) }}</div>
                </div>
                <div class="sb-stat-icon">
                    <i class="fas fa-store"></i>
                </div>
            </div>

            <div class="sb-stat-bottom">
                <span>Manage sellers</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>


        <a href="{{ route('admin.seller-verifications.index') }}" class="sb-stat-card sb-orange">
            <div class="sb-stat-top">
                <div>
                    <div class="sb-stat-label">Pending KYC</div>
                    <div class="sb-stat-number">{{ number_format($pendingSellers) }}</div>
                </div>
                <div class="sb-stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>

            <div class="sb-stat-bottom">
                <span>Review applications</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>


        <a href="{{ route('admin.revenue') }}" class="sb-stat-card sb-gold">
            <div class="sb-stat-top">
                <div>
                    <div class="sb-stat-label">Total Revenue</div>
                    <div class="sb-stat-number">
                        ₹{{ number_format((float) $totalRevenue, 0) }}
                    </div>
                </div>
                <div class="sb-stat-icon">
                    <i class="fas fa-indian-rupee-sign"></i>
                </div>
            </div>

            <div class="sb-stat-bottom">
                <span>View revenue</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>


        <a href="{{ route('admin.products.index') }}" class="sb-stat-card sb-purple">
            <div class="sb-stat-top">
                <div>
                    <div class="sb-stat-label">Total Products</div>
                    <div class="sb-stat-number">{{ number_format($totalProducts) }}</div>
                </div>
                <div class="sb-stat-icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>

            <div class="sb-stat-bottom">
                <span>Manage products</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>


        <a href="{{ route('admin.orders.index') }}" class="sb-stat-card sb-blue">
            <div class="sb-stat-top">
                <div>
                    <div class="sb-stat-label">Total Orders</div>
                    <div class="sb-stat-number">{{ number_format($totalOrders) }}</div>
                </div>
                <div class="sb-stat-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <div class="sb-stat-bottom">
                <span>View orders</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>


        <a href="{{ route('admin.sellers.index') }}" class="sb-stat-card sb-green">
            <div class="sb-stat-top">
                <div>
                    <div class="sb-stat-label">Approved Sellers</div>
                    <div class="sb-stat-number">{{ number_format($approvedSellers) }}</div>
                </div>
                <div class="sb-stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>

            <div class="sb-stat-bottom">
                <span>View approved sellers</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>


        <a href="{{ route('admin.transactions.index') }}" class="sb-stat-card sb-red">
            <div class="sb-stat-top">
                <div>
                    <div class="sb-stat-label">Pending Payments</div>
                    <div class="sb-stat-number">{{ number_format($pendingPayments) }}</div>
                </div>
                <div class="sb-stat-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
            </div>

            <div class="sb-stat-bottom">
                <span>Review transactions</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>

    </div>


    {{-- QUICK ACTIONS --}}
    <div class="sb-card sb-quick-card">

        <div class="sb-card-header">
            <div class="sb-card-title">
                <i class="fas fa-bolt"></i>
                Quick Actions
            </div>

            <span style="color:var(--text-secondary);font-size:10px;">
                Frequently used
            </span>
        </div>

        <div class="sb-quick-grid">

            <a href="{{ route('admin.customers.index') }}" class="sb-quick-action">
                <i class="fas fa-users"></i>
                <span>Customers</span>
            </a>

            <a href="{{ route('admin.seller-verifications.index') }}" class="sb-quick-action">
                <i class="fas fa-clipboard-check"></i>
                <span>Seller KYC</span>
            </a>

            <a href="{{ route('admin.products.index') }}" class="sb-quick-action">
                <i class="fas fa-box"></i>
                <span>Products</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="sb-quick-action">
                <i class="fas fa-shopping-bag"></i>
                <span>Orders</span>
            </a>

            <a href="{{ route('admin.transactions.index') }}" class="sb-quick-action">
                <i class="fas fa-credit-card"></i>
                <span>Transactions</span>
            </a>

            <a href="{{ route('admin.analytics.sales') }}" class="sb-quick-action">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </a>

            <a href="{{ route('admin.settings') }}" class="sb-quick-action">
                <i class="fas fa-sliders"></i>
                <span>Settings</span>
            </a>

        </div>

    </div>


    {{-- LOWER INFORMATION --}}
    <div class="sb-lower-grid">

        {{-- RECENT ORDERS --}}
        <div class="sb-card">

            <div class="sb-card-header">
                <div class="sb-card-title">
                    <i class="fas fa-clock"></i>
                    Recent Orders
                </div>

                <a href="{{ route('admin.orders.index') }}" class="sb-card-link">
                    View All
                </a>
            </div>

            <div class="sb-list">

                @forelse($recentOrders ?? [] as $order)

                    <a href="{{ route('admin.orders.show', $order) }}" class="sb-list-item">

                        <div class="sb-list-main">
                            <div class="sb-list-title">
                                #{{ $order->id }}
                                ·
                                {{ $order->user?->name ?? ($order->name ?? 'Customer') }}
                            </div>

                            <div class="sb-list-sub">
                                Order details
                            </div>
                        </div>

                        <div class="sb-list-value">
                            ₹{{ number_format((float) ($order->amount ?? $order->total ?? 0), 0) }}
                        </div>

                    </a>

                @empty

                    <div class="sb-empty">
                        <i class="fas fa-shopping-bag"></i>
                        No orders recorded yet.
                    </div>

                @endforelse

            </div>

        </div>


        {{-- RECENT CUSTOMERS --}}
        <div class="sb-card">

            <div class="sb-card-header">
                <div class="sb-card-title">
                    <i class="fas fa-user-plus"></i>
                    Recent Customers
                </div>

                <a href="{{ route('admin.customers.index') }}" class="sb-card-link">
                    View All
                </a>
            </div>

            <div class="sb-list">

                @forelse($recentCustomers ?? [] as $customer)

                    <a href="{{ route('admin.customers.show', $customer) }}" class="sb-list-item">

                        <div class="sb-list-main">
                            <div class="sb-list-title">
                                {{ $customer->name }}
                            </div>

                            <div class="sb-list-sub">
                                Customer account
                            </div>
                        </div>

                        <div class="sb-list-value" style="color:var(--text-secondary);font-size:10px;">
                            {{ $customer->created_at?->diffForHumans() ?? 'Recently' }}
                        </div>

                    </a>

                @empty

                    <div class="sb-empty">
                        <i class="fas fa-users"></i>
                        No customers recorded yet.
                    </div>

                @endforelse

            </div>

        </div>


        {{-- SELLER APPLICATIONS --}}
        <div class="sb-card">

            <div class="sb-card-header">
                <div class="sb-card-title">
                    <i class="fas fa-clipboard-check"></i>
                    Seller Applications
                </div>

                <a href="{{ route('admin.seller-verifications.index') }}" class="sb-card-link">
                    View All
                </a>
            </div>

            <div class="sb-list">

                @forelse($recentApplications ?? [] as $seller)

                    <a href="{{ route('admin.seller-verifications.show', $seller) }}" class="sb-list-item">

                        <div class="sb-list-main">
                            <div class="sb-list-title">
                                {{ $seller->business_name ?: ($seller->name ?? 'Seller') }}
                            </div>

                            <div class="sb-list-sub">
                                Seller verification
                            </div>
                        </div>

                        <span class="sb-status">
                            {{ method_exists($seller, 'getApplicationStatusLabel')
                                ? $seller->getApplicationStatusLabel()
                                : ($seller->verification_status ?? 'Pending') }}
                        </span>

                    </a>

                @empty

                    <div class="sb-empty">
                        <i class="fas fa-store"></i>
                        No seller applications recorded.
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection