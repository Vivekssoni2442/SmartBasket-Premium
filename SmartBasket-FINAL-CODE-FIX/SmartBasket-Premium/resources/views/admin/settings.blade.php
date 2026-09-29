@extends('layouts.admin')

@section('title', 'Settings - SmartBasket Admin')

@section('breadcrumbs')
    <span>/</span>
    <span style="color:var(--text-primary);">Settings</span>
@endsection

@section('extra-css')

<style>
    /* =========================================================
       SMARTBASKET ADMIN SETTINGS
       ========================================================= */

    .sb-settings-page {
        width: 100%;
        max-width: 1500px;
        margin: 0 auto;
    }

    /* HEADER */

    .sb-settings-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 24px;
        margin-bottom: 22px;
        border: 1px solid var(--border-color);
        border-radius: 18px;
        background:
            radial-gradient(
                circle at 90% 20%,
                rgba(255,215,0,.10),
                transparent 30%
            ),
            radial-gradient(
                circle at 10% 100%,
                rgba(124,58,237,.10),
                transparent 35%
            ),
            var(--card-bg);
    }

    .sb-settings-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .sb-settings-main-icon {
        width: 55px;
        height: 55px;
        flex: 0 0 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: rgba(255,215,0,.10);
        border: 1px solid rgba(255,215,0,.18);
        color: var(--primary-gold);
        font-size: 23px;
    }

    .sb-settings-header h1 {
        margin: 0 0 5px;
        color: var(--text-primary);
        font-size: 26px;
        font-weight: 850;
    }

    .sb-settings-header p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 12px;
        line-height: 1.6;
    }

    .sb-settings-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 13px;
        border-radius: 999px;
        background: rgba(34,197,94,.08);
        border: 1px solid rgba(34,197,94,.18);
        color: #22c55e;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .sb-settings-status i {
        font-size: 7px;
    }


    /* LAYOUT */

    .sb-settings-layout {
        display: grid;
        grid-template-columns: 255px minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }


    /* SIDEBAR */

    .sb-settings-nav {
        position: sticky;
        top: 20px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        background: var(--card-bg);
    }

    .sb-settings-nav-title {
        padding: 17px 17px 12px;
        color: var(--text-secondary);
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .sb-settings-nav-button {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 12px 15px;
        border: 0;
        border-left: 3px solid transparent;
        background: transparent;
        color: var(--text-secondary);
        text-align: left;
        font-family: inherit;
        font-size: 11px;
        font-weight: 650;
        cursor: pointer;
        transition: .2s ease;
    }

    .sb-settings-nav-button i {
        width: 18px;
        text-align: center;
        font-size: 13px;
    }

    .sb-settings-nav-button:hover {
        background: rgba(255,215,0,.045);
        color: var(--text-primary);
    }

    .sb-settings-nav-button.active {
        border-left-color: var(--primary-gold);
        background: rgba(255,215,0,.07);
        color: var(--primary-gold);
    }

    .sb-settings-nav-divider {
        height: 1px;
        margin: 7px 15px;
        background: var(--border-color);
    }


    /* CONTENT */

    .sb-settings-section {
        display: none;
        animation: sbSettingsFade .2s ease;
    }

    .sb-settings-section.active {
        display: block;
    }

    @keyframes sbSettingsFade {
        from {
            opacity: 0;
            transform: translateY(4px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    /* SECTION HEADER */

    .sb-section-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 17px;
    }

    .sb-section-top h2 {
        margin: 0 0 5px;
        color: var(--text-primary);
        font-size: 19px;
        font-weight: 850;
    }

    .sb-section-top p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 11px;
        line-height: 1.6;
    }


    /* CARDS */

    .sb-settings-card {
        overflow: hidden;
        margin-bottom: 17px;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        background: var(--card-bg);
    }

    .sb-settings-card:last-child {
        margin-bottom: 0;
    }

    .sb-settings-card-header {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 16px 18px;
        border-bottom: 1px solid var(--border-color);
    }

    .sb-settings-card-icon {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(255,215,0,.08);
        color: var(--primary-gold);
    }

    .sb-settings-card-header h3 {
        margin: 0 0 2px;
        color: var(--text-primary);
        font-size: 13px;
        font-weight: 800;
    }

    .sb-settings-card-header p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 9px;
    }

    .sb-settings-card-body {
        padding: 18px;
    }


    /* FORM */

    .sb-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .sb-form-group.full {
        grid-column: 1 / -1;
    }

    .sb-form-label {
        display: block;
        margin-bottom: 7px;
        color: var(--text-primary);
        font-size: 10px;
        font-weight: 700;
    }

    .sb-form-help {
        margin-top: 5px;
        color: var(--text-secondary);
        font-size: 9px;
        line-height: 1.5;
    }

    .sb-form-control {
        width: 100%;
        min-height: 40px;
        padding: 9px 11px;
        border: 1px solid var(--border-color);
        border-radius: 9px;
        outline: none;
        background: rgba(255,255,255,.025);
        color: var(--text-primary);
        font-family: inherit;
        font-size: 11px;
        transition: .2s ease;
    }

    .sb-form-control:focus {
        border-color: rgba(255,215,0,.5);
        box-shadow: 0 0 0 3px rgba(255,215,0,.05);
    }

    .sb-form-control::placeholder {
        color: var(--text-secondary);
    }


    /* INFORMATION ROW */

    .sb-setting-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 15px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .sb-setting-row:first-child {
        padding-top: 0;
    }

    .sb-setting-row:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .sb-setting-info {
        min-width: 0;
    }

    .sb-setting-name {
        color: var(--text-primary);
        font-size: 11px;
        font-weight: 750;
    }

    .sb-setting-description {
        margin-top: 4px;
        color: var(--text-secondary);
        font-size: 9px;
        line-height: 1.55;
    }


    /* BADGES */

    .sb-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 999px;
        font-size: 8px;
        font-weight: 800;
        white-space: nowrap;
    }

    .sb-badge-success {
        background: rgba(34,197,94,.08);
        border: 1px solid rgba(34,197,94,.15);
        color: #22c55e;
    }

    .sb-badge-warning {
        background: rgba(245,158,11,.08);
        border: 1px solid rgba(245,158,11,.15);
        color: #f59e0b;
    }

    .sb-badge-gold {
        background: rgba(255,215,0,.08);
        border: 1px solid rgba(255,215,0,.15);
        color: var(--primary-gold);
    }


    /* TOGGLE */

    .sb-toggle {
        position: relative;
        width: 43px;
        height: 23px;
        flex: 0 0 43px;
    }

    .sb-toggle input {
        display: none;
    }

    .sb-toggle-slider {
        position: absolute;
        inset: 0;
        border-radius: 999px;
        background: rgba(255,255,255,.10);
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: .2s ease;
    }

    .sb-toggle-slider::after {
        content: "";
        position: absolute;
        width: 17px;
        height: 17px;
        left: 2px;
        top: 2px;
        border-radius: 50%;
        background: var(--text-secondary);
        transition: .2s ease;
    }

    .sb-toggle input:checked + .sb-toggle-slider {
        background: rgba(255,215,0,.18);
        border-color: rgba(255,215,0,.4);
    }

    .sb-toggle input:checked + .sb-toggle-slider::after {
        transform: translateX(19px);
        background: var(--primary-gold);
    }


    /* BUTTONS */

    .sb-settings-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 18px;
    }

    .sb-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 38px;
        padding: 8px 13px;
        border-radius: 9px;
        font-family: inherit;
        font-size: 10px;
        font-weight: 750;
        text-decoration: none;
        cursor: pointer;
        transition: .2s ease;
    }

    .sb-btn-primary {
        border: 1px solid rgba(255,215,0,.3);
        background: rgba(255,215,0,.10);
        color: var(--primary-gold);
    }

    .sb-btn-primary:hover {
        background: rgba(255,215,0,.17);
        transform: translateY(-1px);
    }

    .sb-btn-secondary {
        border: 1px solid var(--border-color);
        background: rgba(255,255,255,.025);
        color: var(--text-primary);
    }

    .sb-btn-secondary:hover {
        border-color: rgba(255,215,0,.25);
    }


    /* QUICK SETTINGS */

    .sb-quick-settings {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .sb-quick-setting {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 14px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background: rgba(255,255,255,.015);
    }

    .sb-quick-setting-icon {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(255,215,0,.08);
        color: var(--primary-gold);
    }

    .sb-quick-setting strong {
        display: block;
        margin-bottom: 3px;
        color: var(--text-primary);
        font-size: 10px;
    }

    .sb-quick-setting span {
        color: var(--text-secondary);
        font-size: 8px;
    }


    /* SECURITY BOX */

    .sb-security-box {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 15px;
        border-radius: 12px;
        background: rgba(34,197,94,.045);
        border: 1px solid rgba(34,197,94,.14);
    }

    .sb-security-icon {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: rgba(34,197,94,.10);
        color: #22c55e;
    }

    .sb-security-box strong {
        display: block;
        margin-bottom: 4px;
        color: var(--text-primary);
        font-size: 10px;
    }

    .sb-security-box p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 9px;
        line-height: 1.6;
    }


    /* ALERT */

    .sb-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px 15px;
        margin-bottom: 17px;
        border-radius: 12px;
        font-size: 10px;
        line-height: 1.6;
    }

    .sb-alert-success {
        border: 1px solid rgba(34,197,94,.18);
        background: rgba(34,197,94,.06);
        color: #22c55e;
    }

    .sb-alert-danger {
        border: 1px solid rgba(239,68,68,.18);
        background: rgba(239,68,68,.06);
        color: #ef4444;
    }


    /* RESPONSIVE */

    @media (max-width: 1100px) {
        .sb-settings-layout {
            grid-template-columns: 210px minmax(0, 1fr);
        }

        .sb-quick-settings {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 850px) {
        .sb-settings-layout {
            grid-template-columns: 1fr;
        }

        .sb-settings-nav {
            position: static;
            display: flex;
            flex-wrap: wrap;
            padding: 7px;
        }

        .sb-settings-nav-title,
        .sb-settings-nav-divider {
            display: none;
        }

        .sb-settings-nav-button {
            width: auto;
            flex: 1 1 auto;
            border-left: 0;
            border-bottom: 2px solid transparent;
            border-radius: 8px;
            justify-content: center;
            padding: 10px 8px;
        }

        .sb-settings-nav-button.active {
            border-left: 0;
            border-bottom-color: var(--primary-gold);
        }
    }

    @media (max-width: 650px) {
        .sb-settings-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px;
        }

        .sb-settings-header h1 {
            font-size: 22px;
        }

        .sb-form-grid {
            grid-template-columns: 1fr;
        }

        .sb-form-group.full {
            grid-column: auto;
        }

        .sb-quick-settings {
            grid-template-columns: 1fr;
        }

        .sb-setting-row {
            align-items: flex-start;
        }
    }
</style>

@endsection


@section('content')

@php
    $adminName = $admin?->name ?? session('admin_name', 'Administrator');
    $adminEmail = $admin?->email ?? session('admin_email', 'Not available');

    $environment = app()->environment();
    $appName = config('app.name', 'SmartBasket');
    $debug = config('app.debug');
@endphp


<div class="sb-settings-page">


    {{-- HEADER --}}
    <div class="sb-settings-header">

        <div class="sb-settings-header-left">

            <div class="sb-settings-main-icon">
                <i class="fas fa-gear"></i>
            </div>

            <div>

                <h1>
                    Store Settings
                </h1>

                <p>
                    Configure and monitor your SmartBasket shopping platform,
                    store operations, customers, sellers, payments and security.
                </p>

            </div>

        </div>


        <div class="sb-settings-status">
            <i class="fas fa-circle"></i>
            Store Online
        </div>

    </div>


    {{-- ALERTS --}}
    @if(session('success'))

        <div class="sb-alert sb-alert-success">
            <i class="fas fa-circle-check"></i>

            <div>
                <strong>Success</strong><br>
                {{ session('success') }}
            </div>
        </div>

    @endif


    @if($errors->any())

        <div class="sb-alert sb-alert-danger">
            <i class="fas fa-circle-exclamation"></i>

            <div>
                <strong>Please check the following:</strong>

                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>

    @endif


    <div class="sb-settings-layout">


        {{-- SETTINGS NAVIGATION --}}
        <aside class="sb-settings-nav">

            <div class="sb-settings-nav-title">
                Store Configuration
            </div>


            <button
                type="button"
                class="sb-settings-nav-button active"
                data-settings-tab="general"
            >
                <i class="fas fa-store"></i>
                General
            </button>


            <button
                type="button"
                class="sb-settings-nav-button"
                data-settings-tab="shopping"
            >
                <i class="fas fa-cart-shopping"></i>
                Shopping
            </button>


            <button
                type="button"
                class="sb-settings-nav-button"
                data-settings-tab="orders"
            >
                <i class="fas fa-box"></i>
                Orders
            </button>


            <button
                type="button"
                class="sb-settings-nav-button"
                data-settings-tab="payments"
            >
                <i class="fas fa-credit-card"></i>
                Payments
            </button>


            <button
                type="button"
                class="sb-settings-nav-button"
                data-settings-tab="customers"
            >
                <i class="fas fa-users"></i>
                Customers
            </button>


            <button
                type="button"
                class="sb-settings-nav-button"
                data-settings-tab="sellers"
            >
                <i class="fas fa-store"></i>
                Sellers
            </button>


            <button
                type="button"
                class="sb-settings-nav-button"
                data-settings-tab="notifications"
            >
                <i class="fas fa-bell"></i>
                Notifications
            </button>


            <button
                type="button"
                class="sb-settings-nav-button"
                data-settings-tab="security"
            >
                <i class="fas fa-shield-halved"></i>
                Security
            </button>


            <div class="sb-settings-nav-divider"></div>


            <button
                type="button"
                class="sb-settings-nav-button"
                data-settings-tab="system"
            >
                <i class="fas fa-server"></i>
                System
            </button>

        </aside>


        {{-- CONTENT --}}
        <main>


            {{-- =====================================================
                 GENERAL
                 ===================================================== --}}

            <section
                class="sb-settings-section active"
                data-settings-section="general"
            >

                <div class="sb-section-top">

                    <div>

                        <h2>
                            General Settings
                        </h2>

                        <p>
                            Basic identity and storefront information.
                        </p>

                    </div>

                </div>


                <div class="sb-settings-card">

                    <div class="sb-settings-card-header">

                        <div class="sb-settings-card-icon">
                            <i class="fas fa-store"></i>
                        </div>

                        <div>

                            <h3>
                                Store Information
                            </h3>

                            <p>
                                Basic information about your shopping platform.
                            </p>

                        </div>

                    </div>


                    <div class="sb-settings-card-body">

                        <div class="sb-form-grid">

                            <div class="sb-form-group">

                                <label class="sb-form-label">
                                    Store Name
                                </label>

                                <input
                                    type="text"
                                    class="sb-form-control"
                                    value="{{ $appName }}"
                                    readonly
                                >

                                <div class="sb-form-help">
                                    Application name configured in Laravel.
                                </div>

                            </div>


                            <div class="sb-form-group">

                                <label class="sb-form-label">
                                    Environment
                                </label>

                                <input
                                    type="text"
                                    class="sb-form-control"
                                    value="{{ $environment }}"
                                    readonly
                                >

                            </div>


                            <div class="sb-form-group full">

                                <label class="sb-form-label">
                                    Store Description
                                </label>

                                <input
                                    type="text"
                                    class="sb-form-control"
                                    value="SmartBasket - Smart Shopping & E-Commerce Platform"
                                    readonly
                                >

                            </div>

                        </div>

                    </div>

                </div>


                <div class="sb-settings-card">

                    <div class="sb-settings-card-header">

                        <div class="sb-settings-card-icon">
                            <i class="fas fa-bolt"></i>
                        </div>

                        <div>

                            <h3>
                                Store Overview
                            </h3>

                            <p>
                                Quickly access the most important store areas.
                            </p>

                        </div>

                    </div>


                    <div class="sb-settings-card-body">

                        <div class="sb-quick-settings">

                            <a
                                href="{{ route('admin.products.index') }}"
                                class="sb-quick-setting"
                                style="text-decoration:none;"
                            >
                                <div class="sb-quick-setting-icon">
                                    <i class="fas fa-box"></i>
                                </div>

                                <div>
                                    <strong>Products</strong>
                                    <span>Manage catalog</span>
                                </div>
                            </a>


                            <a
                                href="{{ route('admin.orders.index') }}"
                                class="sb-quick-setting"
                                style="text-decoration:none;"
                            >
                                <div class="sb-quick-setting-icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>

                                <div>
                                    <strong>Orders</strong>
                                    <span>Manage orders</span>
                                </div>
                            </a>


                            <a
                                href="{{ route('admin.customers.index') }}"
                                class="sb-quick-setting"
                                style="text-decoration:none;"
                            >
                                <div class="sb-quick-setting-icon">
                                    <i class="fas fa-users"></i>
                                </div>

                                <div>
                                    <strong>Customers</strong>
                                    <span>Manage customers</span>
                                </div>
                            </a>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =====================================================
                 SHOPPING
                 ===================================================== --}}

            <section
                class="sb-settings-section"
                data-settings-section="shopping"
            >

                <div class="sb-section-top">

                    <div>

                        <h2>
                            Shopping Settings
                        </h2>

                        <p>
                            Shopping experience and storefront behaviour.
                        </p>

                    </div>

                </div>


                <div class="sb-settings-card">

                    <div class="sb-settings-card-header">

                        <div class="sb-settings-card-icon">
                            <i class="fas fa-cart-shopping"></i>
                        </div>

                        <div>

                            <h3>
                                Shopping Features
                            </h3>

                            <p>
                                Current shopping capabilities available in SmartBasket.
                            </p>

                        </div>

                    </div>


                    <div class="sb-settings-card-body">

                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Product Catalog
                                </div>

                                <div class="sb-setting-description">
                                    Customers can browse and view available products.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                <i class="fas fa-check"></i>
                                Active
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Shopping Cart
                                </div>

                                <div class="sb-setting-description">
                                    Customers can add, remove and update cart items.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                <i class="fas fa-check"></i>
                                Active
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Wishlist
                                </div>

                                <div class="sb-setting-description">
                                    Customer wishlist functionality.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                <i class="fas fa-check"></i>
                                Active
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    AI Shopping Features
                                </div>

                                <div class="sb-setting-description">
                                    SmartBasket AI shopping and product assistance.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-gold">
                                <i class="fas fa-sparkles"></i>
                                Available
                            </span>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =====================================================
                 ORDERS
                 ===================================================== --}}

            <section
                class="sb-settings-section"
                data-settings-section="orders"
            >

                <div class="sb-section-top">

                    <div>

                        <h2>
                            Order Settings
                        </h2>

                        <p>
                            Monitor the SmartBasket order processing workflow.
                        </p>

                    </div>

                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="sb-btn sb-btn-primary"
                    >
                        <i class="fas fa-box"></i>
                        Manage Orders
                    </a>

                </div>


                <div class="sb-settings-card">

                    <div class="sb-settings-card-header">

                        <div class="sb-settings-card-icon">
                            <i class="fas fa-box"></i>
                        </div>

                        <div>

                            <h3>
                                Order Workflow
                            </h3>

                            <p>
                                Current order-management capabilities.
                            </p>

                        </div>

                    </div>


                    <div class="sb-settings-card-body">

                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Order Management
                                </div>

                                <div class="sb-setting-description">
                                    View and manage customer orders from the admin panel.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                Active
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Returns Management
                                </div>

                                <div class="sb-setting-description">
                                    Review customer return requests.
                                </div>

                            </div>

                            <a
                                href="{{ route('admin.returns.index') }}"
                                class="sb-btn sb-btn-secondary"
                            >
                                Open
                            </a>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Transaction Management
                                </div>

                                <div class="sb-setting-description">
                                    Monitor payment and transaction records.
                                </div>

                            </div>

                            <a
                                href="{{ route('admin.transactions.index') }}"
                                class="sb-btn sb-btn-secondary"
                            >
                                Open
                            </a>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =====================================================
                 PAYMENTS
                 ===================================================== --}}

            <section
                class="sb-settings-section"
                data-settings-section="payments"
            >

                <div class="sb-section-top">

                    <div>

                        <h2>
                            Payment Settings
                        </h2>

                        <p>
                            Monitor payment methods and transaction operations.
                        </p>

                    </div>

                    <a
                        href="{{ route('admin.transactions.index') }}"
                        class="sb-btn sb-btn-primary"
                    >
                        <i class="fas fa-credit-card"></i>
                        Transactions
                    </a>

                </div>


                <div class="sb-settings-card">

                    <div class="sb-settings-card-header">

                        <div class="sb-settings-card-icon">
                            <i class="fas fa-wallet"></i>
                        </div>

                        <div>

                            <h3>
                                Payment Methods
                            </h3>

                            <p>
                                Payment functionality currently available in the platform.
                            </p>

                        </div>

                    </div>


                    <div class="sb-settings-card-body">

                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    UPI Payments
                                </div>

                                <div class="sb-setting-description">
                                    UPI-based customer payment workflow.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                <i class="fas fa-check"></i>
                                Available
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Payment Verification
                                </div>

                                <div class="sb-setting-description">
                                    Payment transactions are handled through the existing checkout workflow.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                Active
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Revenue Monitoring
                                </div>

                                <div class="sb-setting-description">
                                    View platform revenue and financial information.
                                </div>

                            </div>

                            <a
                                href="{{ route('admin.revenue') }}"
                                class="sb-btn sb-btn-secondary"
                            >
                                View Revenue
                            </a>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =====================================================
                 CUSTOMERS
                 ===================================================== --}}

            <section
                class="sb-settings-section"
                data-settings-section="customers"
            >

                <div class="sb-section-top">

                    <div>

                        <h2>
                            Customer Settings
                        </h2>

                        <p>
                            Manage customer accounts and activity.
                        </p>

                    </div>

                    <a
                        href="{{ route('admin.customers.index') }}"
                        class="sb-btn sb-btn-primary"
                    >
                        <i class="fas fa-users"></i>
                        Manage Customers
                    </a>

                </div>


                <div class="sb-settings-card">

                    <div class="sb-settings-card-header">

                        <div class="sb-settings-card-icon">
                            <i class="fas fa-users"></i>
                        </div>

                        <div>

                            <h3>
                                Customer Management
                            </h3>

                            <p>
                                Customer administration and activity monitoring.
                            </p>

                        </div>

                    </div>


                    <div class="sb-settings-card-body">

                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Customer Accounts
                                </div>

                                <div class="sb-setting-description">
                                    View customer accounts registered on SmartBasket.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                Active
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Customer Activity
                                </div>

                                <div class="sb-setting-description">
                                    Monitor recent customer activity.
                                </div>

                            </div>

                            <a
                                href="{{ route('admin.customers.activity') }}"
                                class="sb-btn sb-btn-secondary"
                            >
                                Activity
                            </a>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =====================================================
                 SELLERS
                 ===================================================== --}}

            <section
                class="sb-settings-section"
                data-settings-section="sellers"
            >

                <div class="sb-section-top">

                    <div>

                        <h2>
                            Seller Settings
                        </h2>

                        <p>
                            Manage sellers and seller verification.
                        </p>

                    </div>

                    <a
                        href="{{ route('admin.sellers.index') }}"
                        class="sb-btn sb-btn-primary"
                    >
                        <i class="fas fa-store"></i>
                        Sellers
                    </a>

                </div>


                <div class="sb-settings-card">

                    <div class="sb-settings-card-header">

                        <div class="sb-settings-card-icon">
                            <i class="fas fa-store"></i>
                        </div>

                        <div>

                            <h3>
                                Seller Management
                            </h3>

                            <p>
                                Seller onboarding, verification and management.
                            </p>

                        </div>

                    </div>


                    <div class="sb-settings-card-body">

                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Seller Accounts
                                </div>

                                <div class="sb-setting-description">
                                    Manage registered SmartBasket sellers.
                                </div>

                            </div>

                            <a
                                href="{{ route('admin.sellers.index') }}"
                                class="sb-btn sb-btn-secondary"
                            >
                                Manage
                            </a>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Seller Verification / KYC
                                </div>

                                <div class="sb-setting-description">
                                    Review seller applications and submitted verification documents.
                                </div>

                            </div>

                            <a
                                href="{{ route('admin.seller-verifications.index') }}"
                                class="sb-btn sb-btn-primary"
                            >
                                Review KYC
                            </a>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =====================================================
                 NOTIFICATIONS
                 ===================================================== --}}

            <section
                class="sb-settings-section"
                data-settings-section="notifications"
            >

                <div class="sb-section-top">

                    <div>

                        <h2>
                            Notification Settings
                        </h2>

                        <p>
                            Monitor administrative notifications and workflows.
                        </p>

                    </div>

                </div>


                <div class="sb-settings-card">

                    <div class="sb-settings-card-header">

                        <div class="sb-settings-card-icon">
                            <i class="fas fa-bell"></i>
                        </div>

                        <div>

                            <h3>
                                Admin Notifications
                            </h3>

                            <p>
                                Current notification services in SmartBasket.
                            </p>

                        </div>

                    </div>


                    <div class="sb-settings-card-body">

                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Seller Applications
                                </div>

                                <div class="sb-setting-description">
                                    Notifications related to new seller applications.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                <i class="fas fa-check"></i>
                                Active
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Verification Workflow
                                </div>

                                <div class="sb-setting-description">
                                    Seller verification workflow notifications.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                <i class="fas fa-check"></i>
                                Active
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Dashboard Notifications
                                </div>

                                <div class="sb-setting-description">
                                    Administrative alerts displayed inside the admin panel.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                Available
                            </span>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =====================================================
                 SECURITY
                 ===================================================== --}}

            <section
                class="sb-settings-section"
                data-settings-section="security"
            >

                <div class="sb-section-top">

                    <div>

                        <h2>
                            Security Settings
                        </h2>

                        <p>
                            Protect administrator accounts and sensitive configuration.
                        </p>

                    </div>

                </div>


                <div class="sb-settings-card">

                    <div class="sb-settings-card-header">

                        <div class="sb-settings-card-icon">
                            <i class="fas fa-shield-halved"></i>
                        </div>

                        <div>

                            <h3>
                                Administrator Security
                            </h3>

                            <p>
                                Current administrator account security status.
                            </p>

                        </div>

                    </div>


                    <div class="sb-settings-card-body">

                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Administrator
                                </div>

                                <div class="sb-setting-description">
                                    {{ $adminName }} · {{ $adminEmail }}
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                Authenticated
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Multi-Factor Authentication
                                </div>

                                <div class="sb-setting-description">
                                    Additional administrator authentication protection.
                                </div>

                            </div>

                            @if($admin?->mfa_enabled)

                                <span class="sb-badge sb-badge-success">
                                    <i class="fas fa-check"></i>
                                    Enabled
                                </span>

                            @else

                                <span class="sb-badge sb-badge-warning">
                                    <i class="fas fa-triangle-exclamation"></i>
                                    Not Enabled
                                </span>

                            @endif

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">

                                <div class="sb-setting-name">
                                    Sensitive Credentials
                                </div>

                                <div class="sb-setting-description">
                                    Passwords, API keys and secret configuration values are not displayed.
                                </div>

                            </div>

                            <span class="sb-badge sb-badge-success">
                                <i class="fas fa-lock"></i>
                                Protected
                            </span>

                        </div>


                        <div class="sb-settings-actions">

                            @if(Route::has('admin.profile'))

                                <a
                                    href="{{ route('admin.profile') }}"
                                    class="sb-btn sb-btn-primary"
                                >
                                    <i class="fas fa-user-pen"></i>
                                    Manage Administrator Profile
                                </a>

                            @endif

                        </div>

                    </div>

                </div>


                <div class="sb-security-box">

                    <div class="sb-security-icon">
                        <i class="fas fa-lock"></i>
                    </div>

                    <div>

                        <strong>
                            Security best practice
                        </strong>

                        <p>
                            Never place passwords, payment secrets, API keys or
                            private credentials directly inside Blade templates,
                            JavaScript files or public repositories.
                        </p>

                    </div>

                </div>

            </section>



            {{-- =====================================================
                 SYSTEM
                 ===================================================== --}}

            <section
                class="sb-settings-section"
                data-settings-section="system"
            >

                <div class="sb-section-top">

                    <div>

                        <h2>
                            System Settings
                        </h2>

                        <p>
                            Application runtime and technical information.
                        </p>

                    </div>

                </div>


                <div class="sb-settings-card">

                    <div class="sb-settings-card-header">

                        <div class="sb-settings-card-icon">
                            <i class="fas fa-server"></i>
                        </div>

                        <div>

                            <h3>
                                System Information
                            </h3>

                            <p>
                                Current SmartBasket application environment.
                            </p>

                        </div>

                    </div>


                    <div class="sb-settings-card-body">

                        <div class="sb-setting-row">

                            <div class="sb-setting-info">
                                <div class="sb-setting-name">
                                    Application
                                </div>

                                <div class="sb-setting-description">
                                    {{ $appName }}
                                </div>
                            </div>

                            <span class="sb-badge sb-badge-success">
                                Running
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">
                                <div class="sb-setting-name">
                                    Environment
                                </div>

                                <div class="sb-setting-description">
                                    Current Laravel application environment.
                                </div>
                            </div>

                            <span class="sb-badge sb-badge-gold">
                                {{ $environment }}
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">
                                <div class="sb-setting-name">
                                    Laravel Version
                                </div>

                                <div class="sb-setting-description">
                                    Current framework version.
                                </div>
                            </div>

                            <span class="sb-badge sb-badge-gold">
                                Laravel {{ app()->version() }}
                            </span>

                        </div>


                        <div class="sb-setting-row">

                            <div class="sb-setting-info">
                                <div class="sb-setting-name">
                                    Debug Mode
                                </div>

                                <div class="sb-setting-description">
                                    Application debugging configuration.
                                </div>
                            </div>

                            @if($debug)

                                <span class="sb-badge sb-badge-warning">
                                    Enabled
                                </span>

                            @else

                                <span class="sb-badge sb-badge-success">
                                    Disabled
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </section>


        </main>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('.sb-settings-nav-button');
    const sections = document.querySelectorAll('.sb-settings-section');

    function activateTab(tabName) {

        buttons.forEach(function (button) {
            button.classList.toggle(
                'active',
                button.dataset.settingsTab === tabName
            );
        });

        sections.forEach(function (section) {
            section.classList.toggle(
                'active',
                section.dataset.settingsSection === tabName
            );
        });

        try {
            localStorage.setItem(
                'smartbasket_admin_settings_tab',
                tabName
            );
        } catch (e) {}
    }


    buttons.forEach(function (button) {

        button.addEventListener('click', function () {

            activateTab(
                this.dataset.settingsTab
            );

        });

    });


    let savedTab = null;

    try {
        savedTab = localStorage.getItem(
            'smartbasket_admin_settings_tab'
        );
    } catch (e) {}

    if (
        savedTab &&
        document.querySelector(
            '[data-settings-section="' + savedTab + '"]'
        )
    ) {
        activateTab(savedTab);
    }

});
</script>

@endsection