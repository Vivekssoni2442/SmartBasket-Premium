@extends('seller.partials.premium-layout')

@section('title', 'Seller Settings')

@section('content')

@include('seller.partials.seller-menu')

<style>
:root {
    --set-primary: #2563eb;
    --set-primary-dark: #1d4ed8;
    --set-primary-deep: #1e40af;
    --set-blue: #3b82f6;
    --set-blue-soft: #eff6ff;
    --set-blue-soft-2: #dbeafe;
    --set-blue-border: #bfdbfe;

    --set-bg: #f5f8fc;
    --set-surface: #ffffff;
    --set-surface-soft: #f8fafc;
    --set-text: #0f172a;
    --set-text-2: #1e293b;
    --set-muted: #64748b;
    --set-border: #e2e8f0;

    --set-success: #059669;
    --set-success-bg: #ecfdf5;
    --set-danger: #dc2626;
    --set-danger-bg: #fef2f2;
    --set-warning: #d97706;

    --set-radius: 20px;
    --set-shadow: 0 12px 40px rgba(15, 23, 42, .07);
    --set-shadow-hover: 0 18px 50px rgba(37, 99, 235, .11);
}

.seller-settings-page,
.seller-settings-page * {
    box-sizing: border-box;
}

.seller-settings-page {
    width: 100%;
    min-height: calc(100vh - 70px);
    padding: 22px 26px 50px;
    position: relative;
    overflow: hidden;

    background:
        radial-gradient(circle at 0% 0%, rgba(37,99,235,.08), transparent 25%),
        radial-gradient(circle at 100% 10%, rgba(59,130,246,.06), transparent 23%),
        var(--set-bg);

    color: var(--set-text);
}

.seller-settings-page::before {
    content: "";
    position: absolute;
    width: 420px;
    height: 420px;
    right: -210px;
    bottom: 60px;
    border-radius: 50%;
    background: rgba(37,99,235,.045);
    filter: blur(70px);
    pointer-events: none;
}

.settings-wrapper {
    width: 100%;
    max-width: none;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

/* =====================================================
   HERO
===================================================== */

.settings-hero {
    width: 100%;
    margin-bottom: 20px;
    padding: 24px;
    border: 1px solid var(--set-blue-border);
    border-radius: var(--set-radius);
    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.98),
            rgba(239,246,255,.96)
        );
    box-shadow: var(--set-shadow);
}

.settings-hero-content {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

.settings-hero-left {
    display: flex;
    align-items: center;
    gap: 16px;
    min-width: 0;
}

.settings-hero-icon {
    width: 58px;
    height: 58px;
    flex: 0 0 58px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 17px;
    color: #fff;
    font-size: 23px;
    background: linear-gradient(
        135deg,
        var(--set-primary),
        var(--set-blue)
    );
    box-shadow: 0 12px 28px rgba(37,99,235,.24);
}

.settings-kicker {
    color: var(--set-primary);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.settings-title {
    margin: 0;
    color: var(--set-text);
    font-size: clamp(25px, 3vw, 36px);
    line-height: 1.1;
    font-weight: 800;
}

.settings-title span {
    color: var(--set-primary);
}

.settings-subtitle {
    max-width: 850px;
    margin: 8px 0 0;
    color: var(--set-muted);
    font-size: 14px;
    line-height: 1.65;
}

.settings-profile {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}

.settings-profile-avatar {
    width: 48px;
    height: 48px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: var(--set-primary);
    font-size: 17px;
    font-weight: 800;
    background: var(--set-blue-soft-2);
    border: 1px solid var(--set-blue-border);
}

.settings-profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.settings-profile-name {
    color: var(--set-text);
    font-size: 14px;
    font-weight: 800;
}

.settings-profile-email {
    margin-top: 2px;
    color: var(--set-muted);
    font-size: 12px;
}

/* =====================================================
   ALERTS
===================================================== */

.settings-alert {
    width: 100%;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 16px;
    padding: 13px 15px;
    border-radius: 14px;
    font-size: 13px;
    line-height: 1.55;
    animation: settingsAlert .3s ease;
}

.settings-alert.success {
    color: #047857;
    background: var(--set-success-bg);
    border: 1px solid #a7f3d0;
}

.settings-alert.error {
    color: #b91c1c;
    background: var(--set-danger-bg);
    border: 1px solid #fecaca;
}

@keyframes settingsAlert {
    from {
        opacity: 0;
        transform: translateY(-6px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* =====================================================
   MAIN LAYOUT
===================================================== */

.settings-layout {
    width: 100%;
    display: grid;
    grid-template-columns: 235px minmax(0, 1fr);
    gap: 20px;
    align-items: start;
}

.settings-nav {
    position: sticky;
    top: 84px;
    width: 100%;
    padding: 9px;
    border: 1px solid var(--set-border);
    border-radius: 18px;
    background: var(--set-surface);
    box-shadow: var(--set-shadow);
}

.settings-nav-head {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 10px 14px;
    margin-bottom: 3px;
    border-bottom: 1px solid var(--set-border);
}

.settings-nav-head-icon {
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    color: var(--set-primary);
    background: var(--set-blue-soft);
}

.settings-nav-head-text {
    color: var(--set-text);
    font-size: 13px;
    font-weight: 800;
}

.settings-nav-item {
    position: relative;
    width: 100%;
    min-height: 44px;
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 0 12px;
    margin-top: 4px;
    border: 0;
    border-radius: 12px;
    color: var(--set-muted);
    background: transparent;
    cursor: pointer;
    text-align: left;
    font: inherit;
    transition: .2s ease;
}

.settings-nav-item i {
    width: 18px;
    text-align: center;
    font-size: 14px;
}

.settings-nav-item span {
    font-size: 13px;
    font-weight: 700;
}

.settings-nav-item:hover {
    color: var(--set-primary);
    background: var(--set-blue-soft);
}

.settings-nav-item.active {
    color: var(--set-primary);
    background: var(--set-blue-soft);
}

.settings-nav-item.active::after {
    content: "";
    position: absolute;
    right: 8px;
    width: 4px;
    height: 22px;
    border-radius: 99px;
    background: var(--set-primary);
}

/* =====================================================
   CONTENT
===================================================== */

.settings-content {
    width: 100%;
    min-width: 0;
}

.settings-section {
    display: none;
}

.settings-section.active {
    display: block;
}

.settings-card {
    width: 100%;
    margin-bottom: 18px;
    padding: 20px;
    border: 1px solid var(--set-border);
    border-radius: var(--set-radius);
    background: var(--set-surface);
    box-shadow: var(--set-shadow);
}

.settings-card:last-child {
    margin-bottom: 0;
}

.settings-card-header {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    margin-bottom: 18px;
}

.settings-card-icon {
    width: 42px;
    height: 42px;
    flex: 0 0 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    color: var(--set-primary);
    background: var(--set-blue-soft);
}

.settings-card-title {
    color: var(--set-text);
    font-size: 16px;
    font-weight: 800;
}

.settings-card-description {
    margin-top: 4px;
    color: var(--set-muted);
    font-size: 12px;
    line-height: 1.55;
}

/* =====================================================
   PROFILE
===================================================== */

.seller-profile-banner {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 15px;
    margin-bottom: 18px;
    border: 1px solid var(--set-blue-border);
    border-radius: 15px;
    background: var(--set-blue-soft);
}

.seller-avatar {
    width: 58px;
    height: 58px;
    flex: 0 0 58px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-radius: 16px;
    color: var(--set-primary);
    background: #fff;
    border: 1px solid var(--set-blue-border);
    font-weight: 800;
}

.seller-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.seller-profile-name {
    color: var(--set-text);
    font-size: 16px;
    font-weight: 800;
}

.seller-profile-email {
    margin-top: 3px;
    color: var(--set-muted);
    font-size: 12px;
}

/* =====================================================
   FORMS
===================================================== */

.settings-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}

.settings-field {
    min-width: 0;
    display: flex;
    flex-direction: column;
}

.settings-field.full {
    grid-column: 1 / -1;
}

.settings-field label {
    margin-bottom: 7px;
    color: var(--set-text-2);
    font-size: 12px;
    font-weight: 800;
}

.settings-input,
.settings-select {
    width: 100%;
    min-height: 45px;
    padding: 10px 13px;
    border: 1px solid var(--set-border);
    border-radius: 12px;
    outline: none;
    color: var(--set-text);
    background: #fff;
    font: inherit;
    font-size: 13px;
    transition: .2s ease;
}

.settings-input:focus,
.settings-select:focus {
    border-color: var(--set-primary);
    box-shadow: 0 0 0 4px rgba(37,99,235,.08);
}

.settings-input[readonly] {
    color: var(--set-muted);
    background: var(--set-surface-soft);
}

textarea.settings-input {
    min-height: 90px;
    resize: vertical;
}

/* =====================================================
   SETTING ROW
===================================================== */

.setting-row {
    width: 100%;
    min-height: 66px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 12px 0;
    border-bottom: 1px solid var(--set-border);
    transition: .25s ease;
}

.setting-row:last-child {
    border-bottom: 0;
}

.setting-row.setting-changed {
    padding-left: 10px;
    padding-right: 10px;
    border-radius: 12px;
    background: var(--set-blue-soft);
}

.setting-info {
    min-width: 0;
}

.setting-info strong {
    display: block;
    color: var(--set-text-2);
    font-size: 13px;
    font-weight: 800;
}

.setting-info span {
    display: block;
    margin-top: 4px;
    color: var(--set-muted);
    font-size: 11px;
    line-height: 1.5;
}

/* =====================================================
   TOGGLE
===================================================== */

.toggle {
    position: relative;
    width: 48px;
    height: 27px;
    flex: 0 0 48px;
    display: inline-block;
}

.toggle input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.toggle-slider {
    position: absolute;
    inset: 0;
    cursor: pointer;
    border-radius: 99px;
    background: #cbd5e1;
    transition: .25s ease;
}

.toggle-slider::before {
    content: "";
    position: absolute;
    width: 21px;
    height: 21px;
    left: 3px;
    top: 3px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 2px 6px rgba(15,23,42,.18);
    transition: .25s ease;
}

.toggle input:checked + .toggle-slider {
    background: var(--set-primary);
}

.toggle input:checked + .toggle-slider::before {
    transform: translateX(21px);
}

/* =====================================================
   SAVE BUTTON
===================================================== */

.settings-save {
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 18px;
    padding: 0 17px;
    border: 0;
    border-radius: 11px;
    color: #fff;
    background: linear-gradient(
        135deg,
        var(--set-primary),
        var(--set-blue)
    );
    font: inherit;
    font-size: 12px;
    font-weight: 800;
    cursor: pointer;
    box-shadow: 0 8px 18px rgba(37,99,235,.18);
    transition: .2s ease;
}

.settings-save:hover {
    transform: translateY(-1px);
    box-shadow: var(--set-shadow-hover);
}

/* =====================================================
   PAYMENT STATUS
===================================================== */

.payment-status-card {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-top: 18px;
    padding: 15px;
    border: 1px solid var(--set-border);
    border-radius: 15px;
    background: var(--set-surface-soft);
}

.payment-status-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.payment-status-icon {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    color: var(--set-primary);
    background: var(--set-blue-soft);
}

.payment-status-title {
    color: var(--set-text);
    font-size: 13px;
    font-weight: 800;
}

.payment-status-text {
    margin-top: 3px;
    color: var(--set-muted);
    font-size: 11px;
}

.payment-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 11px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 800;
    white-space: nowrap;
}

.payment-status-badge.enabled {
    color: #047857;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
}

.payment-status-badge.disabled {
    color: #b91c1c;
    background: #fef2f2;
    border: 1px solid #fecaca;
}

/* =====================================================
   THEME
===================================================== */

.theme-options {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
}

.theme-option {
    position: relative;
}

.theme-option input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.theme-label {
    display: block;
    padding: 13px;
    border: 1px solid var(--set-border);
    border-radius: 15px;
    cursor: pointer;
    transition: .2s ease;
}

.theme-option input:checked + .theme-label {
    border-color: var(--set-primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,.08);
    background: var(--set-blue-soft);
}

.theme-preview {
    height: 70px;
    margin-bottom: 10px;
    border-radius: 10px;
    border: 1px solid var(--set-border);
}

.theme-preview.dark {
    background:
        linear-gradient(135deg, #0f172a, #1e293b);
}

.theme-preview.light {
    background:
        linear-gradient(135deg, #ffffff, #dbeafe);
}

.theme-preview.auto {
    background:
        linear-gradient(
            135deg,
            #ffffff 0 50%,
            #0f172a 50% 100%
        );
}

.theme-name {
    color: var(--set-text);
    font-size: 13px;
    font-weight: 800;
}

.theme-description {
    margin-top: 3px;
    color: var(--set-muted);
    font-size: 11px;
}

/* =====================================================
   SECURITY
===================================================== */

.security-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 14px 0;
    border-bottom: 1px solid var(--set-border);
}

.security-item:last-of-type {
    border-bottom: 0;
}

.security-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.security-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    color: var(--set-primary);
    background: var(--set-blue-soft);
}

.security-title {
    color: var(--set-text-2);
    font-size: 13px;
    font-weight: 800;
}

.security-text {
    margin-top: 3px;
    color: var(--set-muted);
    font-size: 11px;
    line-height: 1.5;
}

/* =====================================================
   QR
===================================================== */

.qr-preview {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 17px;
    padding: 13px;
    border: 1px solid var(--set-blue-border);
    border-radius: 14px;
    background: var(--set-blue-soft);
}

.qr-preview img {
    width: 84px;
    height: 84px;
    flex-shrink: 0;
    object-fit: contain;
    padding: 5px;
    border-radius: 9px;
    background: #fff;
    border: 1px solid #e2e8f0;
}

.qr-preview-info strong {
    display: block;
    color: var(--set-text-2);
    font-size: 12px;
    font-weight: 800;
}

.qr-preview-info span {
    display: block;
    margin-top: 4px;
    color: var(--set-muted);
    font-size: 11px;
    line-height: 1.5;
}

/* =====================================================
   INFO BOX
===================================================== */

.info-box {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 13px;
    border: 1px solid var(--set-blue-border);
    border-radius: 12px;
    color: #475569;
    background: var(--set-blue-soft);
    font-size: 12px;
    line-height: 1.55;
}

.info-box > i {
    flex: 0 0 auto;
    margin-top: 2px;
    color: var(--set-primary);
}

/* =====================================================
   THEME TRANSITION
===================================================== */

html.theme-transition,
html.theme-transition * {
    transition:
        background-color .25s ease,
        color .25s ease,
        border-color .25s ease !important;
}

/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width:1200px) {

    .settings-layout {
        grid-template-columns: 215px minmax(0, 1fr);
    }

}

@media (max-width:1000px) {

    .settings-layout {
        grid-template-columns: 1fr;
    }

    .settings-nav {
        position: relative;
        top: auto;
    }

    .settings-nav {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 5px;
    }

    .settings-nav-head {
        grid-column: 1 / -1;
        margin-bottom: 0;
    }

    .settings-nav-item {
        margin-top: 0;
    }

}

@media (max-width:760px) {

    .seller-settings-page {
        padding: 15px 12px 35px;
    }

    .settings-hero {
        padding: 18px;
    }

    .settings-hero-content {
        align-items: flex-start;
        flex-direction: column;
    }

    .settings-profile {
        width: 100%;
    }

    .settings-grid {
        grid-template-columns: 1fr;
    }

    .settings-field.full {
        grid-column: auto;
    }

    .theme-options {
        grid-template-columns: 1fr;
    }

    .settings-nav {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .payment-status-card {
        align-items: flex-start;
        flex-direction: column;
    }

}

@media (max-width:500px) {

    .settings-hero-left {
        align-items: flex-start;
    }

    .settings-hero-icon {
        width: 48px;
        height: 48px;
        flex-basis: 48px;
        font-size: 19px;
    }

    .settings-title {
        font-size: 24px;
    }

    .settings-subtitle {
        font-size: 12px;
    }

    .settings-card {
        padding: 15px;
        border-radius: 16px;
    }

    .settings-nav {
        grid-template-columns: 1fr 1fr;
    }

    .settings-nav-item {
        padding: 0 9px;
    }

    .settings-nav-item span {
        font-size: 11px;
    }

    .qr-preview {
        align-items: flex-start;
        flex-direction: column;
    }

}
</style>

<div class="seller-settings-page">

    <div class="settings-wrapper">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="settings-hero">

            <div class="settings-hero-content">

                <div class="settings-hero-left">

                    <div class="settings-hero-icon">
                        <i class="fa-solid fa-sliders"></i>
                    </div>

                    <div>

                        <div class="settings-kicker">
                            Smart Basket Seller Center
                        </div>

                        <h1 class="settings-title">
                            Seller <span>Settings</span>
                        </h1>

                        <p class="settings-subtitle">
                            Manage your store, operations, notifications,
                            payments, appearance and security from one
                            professional seller workspace.
                        </p>

                    </div>

                </div>

                <div class="settings-profile">

                    <div class="settings-profile-avatar">

                        @if(!empty($seller->shop_logo))

                            <img
                                src="{{ asset('storage/' . ltrim($seller->shop_logo, '/')) }}?v={{ optional($seller->updated_at)->timestamp ?? time() }}"
                                alt="Shop Logo"
                            >

                        @else

                            {{ strtoupper(substr($seller->seller_name ?? 'S', 0, 1)) }}

                        @endif

                    </div>

                    <div>

                        <div class="settings-profile-name">
                            {{ $seller->seller_name ?? 'Seller' }}
                        </div>

                        <div class="settings-profile-email">
                            {{ $seller->email ?? 'Seller account' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- =====================================================
             ALERTS
        ====================================================== --}}

        @if(session('success'))

            <div class="settings-alert success">

                <i class="fa-solid fa-circle-check"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif

        @if(session('error'))

            <div class="settings-alert error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif

        @if($errors->any())

            <div class="settings-alert error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            </div>

        @endif

        <div class="settings-layout">

            {{-- =================================================
                 SETTINGS MENU
            ================================================== --}}

            <aside class="settings-nav">

                <div class="settings-nav-head">

                    <div class="settings-nav-head-icon">
                        <i class="fa-solid fa-gear"></i>
                    </div>

                    <div class="settings-nav-head-text">
                        Settings Menu
                    </div>

                </div>

                <button type="button"
                        class="settings-nav-item active"
                        data-section="store">
                    <i class="fa-solid fa-store"></i>
                    <span>Store</span>
                </button>

                <button type="button"
                        class="settings-nav-item"
                        data-section="operations">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Operations</span>
                </button>

                <button type="button"
                        class="settings-nav-item"
                        data-section="account">
                    <i class="fa-solid fa-user"></i>
                    <span>Account</span>
                </button>

                <button type="button"
                        class="settings-nav-item"
                        data-section="notifications">
                    <i class="fa-solid fa-bell"></i>
                    <span>Notifications</span>
                </button>

                <button type="button"
                        class="settings-nav-item"
                        data-section="payments">
                    <i class="fa-solid fa-credit-card"></i>
                    <span>Payments</span>
                </button>

                <button type="button"
                        class="settings-nav-item"
                        data-section="shipping">
                    <i class="fa-solid fa-truck-fast"></i>
                    <span>Shipping</span>
                </button>

                <button type="button"
                        class="settings-nav-item"
                        data-section="appearance">
                    <i class="fa-solid fa-palette"></i>
                    <span>Appearance</span>
                </button>

                <button type="button"
                        class="settings-nav-item"
                        data-section="security">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Security</span>
                </button>

            </aside>

            <div class="settings-content">

                {{-- =================================================
                     STORE
                ================================================== --}}

                <section class="settings-section active"
                         data-content="store">

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-store"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Store Information
                                </div>

                                <div class="settings-card-description">
                                    View your store identity and seller information.
                                </div>

                            </div>

                        </div>

                        <div class="seller-profile-banner">

                            <div class="seller-avatar">

                                @if(!empty($seller->shop_logo))

                                    <img
                                        src="{{ asset('storage/' . ltrim($seller->shop_logo, '/')) }}?v={{ optional($seller->updated_at)->timestamp ?? time() }}"
                                        alt="Shop Logo"
                                    >

                                @else

                                    {{ strtoupper(substr($seller->shop_name ?? $seller->seller_name ?? 'S', 0, 2)) }}

                                @endif

                            </div>

                            <div>

                                <div class="seller-profile-name">
                                    {{ $seller->shop_name ?? $seller->seller_name ?? 'Smart Basket Seller' }}
                                </div>

                                <div class="seller-profile-email">
                                    {{ $seller->email ?? '' }}
                                </div>

                            </div>

                        </div>

                        <form method="POST"
                              action="{{ route('seller.settings.update') }}">

                            @csrf
                            @method('PUT')

                            <input type="hidden"
                                   name="theme"
                                   value="{{ $seller->theme ?? 'light' }}">

                            <input type="hidden"
                                   name="notifications_enabled"
                                   value="{{ (bool)($seller->notifications_enabled ?? true) ? 1 : 0 }}">

                            <input type="hidden"
                                   name="online_payments_enabled"
                                   value="{{ (bool)($seller->online_payments_enabled ?? false) ? 1 : 0 }}">

                            <div class="settings-grid">

                                <div class="settings-field">

                                    <label>Store Name</label>

                                    <input type="text"
                                           class="settings-input"
                                           value="{{ $seller->shop_name ?? '' }}"
                                           readonly>

                                </div>

                                <div class="settings-field">

                                    <label>Seller Name</label>

                                    <input type="text"
                                           class="settings-input"
                                           value="{{ $seller->seller_name ?? '' }}"
                                           readonly>

                                </div>

                                <div class="settings-field">

                                    <label>Email Address</label>

                                    <input type="email"
                                           class="settings-input"
                                           value="{{ $seller->email ?? '' }}"
                                           readonly>

                                </div>

                                <div class="settings-field">

                                    <label>Mobile Number</label>

                                    <input type="text"
                                           class="settings-input"
                                           value="{{ $seller->mobile_number ?? '' }}"
                                           readonly>

                                </div>

                            </div>

                            <div class="info-box"
                                 style="margin-top:18px;">

                                <i class="fa-solid fa-circle-info"></i>

                                <div>
                                    Store identity information is managed through
                                    your seller profile. Use the common seller
                                    taskbar/menu for profile management.
                                </div>

                            </div>

                        </form>

                    </div>



                </section>

                {{-- =================================================
                     OPERATIONS
                ================================================== --}}

                <section class="settings-section"
                         data-content="operations">

                    <form method="POST"
                          action="{{ route('seller.settings.update') }}">

                        @csrf
                        @method('PUT')

                        <input type="hidden"
                               name="theme"
                               value="{{ $seller->theme ?? 'light' }}">

                        <input type="hidden"
                               name="notifications_enabled"
                               value="{{ (bool)($seller->notifications_enabled ?? true) ? 1 : 0 }}">

                        <input type="hidden"
                               name="online_payments_enabled"
                               value="{{ (bool)($seller->online_payments_enabled ?? false) ? 1 : 0 }}">

                        @php

                            $operationGroups = [

                                'Order Settings' => [
                                    'auto_accept_orders' => 'Auto accept orders',
                                    'allow_order_cancellation' => 'Allow order cancellation',
                                    'allow_return_requests' => 'Allow return requests',
                                    'allow_exchange_requests' => 'Allow exchange requests',
                                    'auto_update_order_status' => 'Auto update order status',
                                    'order_confirmation_notification' => 'Order confirmation notification',
                                    'delivery_status_notification' => 'Delivery status notification',
                                ],

                                'Product Settings' => [
                                    'allow_customer_reviews' => 'Allow customer reviews',
                                    'allow_customer_questions' => 'Allow customer questions',
                                    'show_stock_quantity' => 'Show stock quantity',
                                    'product_visibility_enabled' => 'Enable product visibility',
                                    'auto_hide_out_of_stock' => 'Auto hide out-of-stock products',
                                ],

                                'Shipping and Delivery' => [
                                    'shipping_enabled' => 'Shipping enabled',
                                    'seller_delivery' => 'Seller delivery',
                                    'platform_delivery' => 'Platform delivery',
                                    'pickup_option' => 'Pickup option',
                                    'same_day_delivery' => 'Same-day delivery',
                                    'express_delivery' => 'Express delivery',
                                ],

                                'Privacy and Store Visibility' => [
                                    'profile_visibility' => 'Profile visibility',
                                    'shop_visibility' => 'Shop visibility',
                                    'show_mobile_number' => 'Show mobile number',
                                    'show_email' => 'Show email',
                                    'show_business_information' => 'Show business information',
                                    'store_active' => 'Store active',
                                    'temporarily_closed' => 'Store temporarily closed',
                                    'vacation_mode' => 'Vacation mode',
                                    'allow_customer_messages' => 'Allow customer messages',
                                    'auto_reply' => 'Automatic customer reply',
                                ],

                                'Invoice and Receipt' => [
                                    'show_seller_logo_on_invoice' => 'Show seller logo',
                                    'show_gst_on_invoice' => 'Show GST',
                                    'show_seller_address_on_invoice' => 'Show seller address',
                                    'show_customer_address_on_invoice' => 'Show customer address',
                                    'show_payment_details_on_invoice' => 'Show payment details',
                                    'show_qr_on_invoice' => 'Show payment QR',
                                ],

                            ];

                        @endphp

                        @foreach($operationGroups as $groupTitle => $groupSettings)

                            <div class="settings-card">

                                <div class="settings-card-header">

                                    <div class="settings-card-icon">
                                        <i class="fa-solid fa-sliders"></i>
                                    </div>

                                    <div>

                                        <div class="settings-card-title">
                                            {{ $groupTitle }}
                                        </div>

                                        <div class="settings-card-description">
                                            Configure how this part of your seller
                                            workflow behaves.
                                        </div>

                                    </div>

                                </div>

                                @foreach($groupSettings as $settingKey => $settingLabel)

                                    <div class="setting-row">

                                        <div class="setting-info">

                                            <strong>
                                                {{ $settingLabel }}
                                            </strong>

                                            <span>
                                                Apply this preference across the
                                                relevant seller workflow.
                                            </span>

                                        </div>

                                        <label class="toggle">

                                            <input type="hidden"
                                                   name="preferences[{{ $settingKey }}]"
                                                   value="0">

                                            <input type="checkbox"
                                                   name="preferences[{{ $settingKey }}]"
                                                   value="1"
                                                   {{ !empty($preferences[$settingKey]) ? 'checked' : '' }}>

                                            <span class="toggle-slider"></span>

                                        </label>

                                    </div>

                                @endforeach

                            </div>

                        @endforeach

                        <div class="settings-card">

                            <div class="settings-card-header">

                                <div class="settings-card-icon">
                                    <i class="fa-solid fa-sliders"></i>
                                </div>

                                <div>

                                    <div class="settings-card-title">
                                        Store Defaults
                                    </div>

                                    <div class="settings-card-description">
                                        Configure default values used by seller operations.
                                    </div>

                                </div>

                            </div>

                            <div class="settings-grid">

                                <div class="settings-field">

                                    <label>Delivery Charge</label>

                                    <input class="settings-input"
                                           type="number"
                                           min="0"
                                           step="0.01"
                                           name="preferences[delivery_charge]"
                                           value="{{ $preferences['delivery_charge'] ?? 0 }}">

                                </div>

                                <div class="settings-field">

                                    <label>Free Shipping Threshold</label>

                                    <input class="settings-input"
                                           type="number"
                                           min="0"
                                           step="0.01"
                                           name="preferences[free_shipping_threshold]"
                                           value="{{ $preferences['free_shipping_threshold'] ?? 0 }}">

                                </div>

                                <div class="settings-field">

                                    <label>Estimated Delivery Days</label>

                                    <input class="settings-input"
                                           type="number"
                                           min="1"
                                           name="preferences[estimated_delivery_days]"
                                           value="{{ $preferences['estimated_delivery_days'] ?? 1 }}">

                                </div>

                                <div class="settings-field">

                                    <label>Low Stock Threshold</label>

                                    <input class="settings-input"
                                           type="number"
                                           min="0"
                                           name="preferences[low_stock_threshold]"
                                           value="{{ $preferences['low_stock_threshold'] ?? 5 }}">

                                </div>

                                <div class="settings-field">

                                    <label>Default Product Status</label>

                                    <select class="settings-select"
                                            name="preferences[default_product_status]">

                                        <option value="active"
                                                @selected(($preferences['default_product_status'] ?? 'active') === 'active')>
                                            Active
                                        </option>

                                        <option value="inactive"
                                                @selected(($preferences['default_product_status'] ?? 'active') === 'inactive')>
                                            Inactive
                                        </option>

                                    </select>

                                </div>

                                <div class="settings-field">

                                    <label>Default Rating</label>

                                    <input class="settings-input"
                                           type="number"
                                           min="0"
                                           max="5"
                                           step="0.1"
                                           name="preferences[default_rating]"
                                           value="{{ $preferences['default_rating'] ?? 0 }}">

                                </div>

                                <div class="settings-field">

                                    <label>Invoice Prefix</label>

                                    <input class="settings-input"
                                           type="text"
                                           maxlength="30"
                                           name="preferences[invoice_prefix]"
                                           value="{{ $preferences['invoice_prefix'] ?? '' }}">

                                </div>

                                <div class="settings-field full">

                                    <label>Invoice Footer</label>

                                    <textarea class="settings-input"
                                              name="preferences[invoice_footer]"
                                              rows="3">{{ $preferences['invoice_footer'] ?? '' }}</textarea>

                                </div>

                            </div>

                            <button type="submit"
                                    class="settings-save">

                                <i class="fa-solid fa-floppy-disk"></i>

                                Save Operations Settings

                            </button>

                        </div>

                    </form>

                    {{-- CUSTOMER COMMUNICATION --}}

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-comments"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Customer Communication
                                </div>

                                <div class="settings-card-description">
                                    Configure predefined messages used during the
                                    order lifecycle.
                                </div>

                            </div>

                        </div>

                        <form method="POST"
                              action="{{ route('seller.settings.update') }}">

                            @csrf
                            @method('PUT')

                            <input type="hidden"
                                   name="theme"
                                   value="{{ $seller->theme ?? 'light' }}">

                            <input type="hidden"
                                   name="notifications_enabled"
                                   value="{{ (bool)($seller->notifications_enabled ?? true) ? 1 : 0 }}">

                            <input type="hidden"
                                   name="online_payments_enabled"
                                   value="{{ (bool)($seller->online_payments_enabled ?? false) ? 1 : 0 }}">

                            @foreach([
                                'welcome_message' => 'Welcome message',
                                'order_message' => 'Order message',
                                'cancellation_message' => 'Cancellation message',
                                'delivery_message' => 'Delivery message'
                            ] as $messageKey => $messageLabel)

                                <div class="settings-field"
                                     style="margin-top:14px;">

                                    <label>
                                        {{ $messageLabel }}
                                    </label>

                                    <textarea class="settings-input"
                                              name="preferences[{{ $messageKey }}]"
                                              rows="2">{{ $preferences[$messageKey] ?? '' }}</textarea>

                                </div>

                            @endforeach

                            <button type="submit"
                                    class="settings-save">

                                <i class="fa-solid fa-floppy-disk"></i>

                                Save Messages

                            </button>

                        </form>

                    </div>

                </section>

                {{-- =================================================
                     ACCOUNT
                ================================================== --}}

                <section class="settings-section"
                         data-content="account">

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Account Information
                                </div>

                                <div class="settings-card-description">
                                    Your Smart Basket seller account details.
                                </div>

                            </div>

                        </div>

                        <div class="settings-grid">

                            <div class="settings-field">

                                <label>Seller Name</label>

                                <input class="settings-input"
                                       value="{{ $seller->seller_name ?? '' }}"
                                       readonly>

                            </div>

                            <div class="settings-field">

                                <label>Email Address</label>

                                <input class="settings-input"
                                       value="{{ $seller->email ?? '' }}"
                                       readonly>

                            </div>

                            <div class="settings-field">

                                <label>Mobile Number</label>

                                <input class="settings-input"
                                       value="{{ $seller->mobile_number ?? '' }}"
                                       readonly>

                            </div>

                            <div class="settings-field">

                                <label>Seller ID</label>

                                <input class="settings-input"
                                       value="#{{ $seller->id }}"
                                       readonly>

                            </div>

                        </div>

                        <div class="info-box"
                             style="margin-top:18px;">

                            <i class="fa-solid fa-circle-info"></i>

                            <div>
                                Your account identity is protected and shown here
                                for reference. Profile editing remains available
                                through the common seller taskbar.
                            </div>

                        </div>

                    </div>

                </section>

                {{-- =================================================
                     NOTIFICATIONS
                ================================================== --}}

                <section class="settings-section"
                         data-content="notifications">

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-bell"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Notification Preferences
                                </div>

                                <div class="settings-card-description">
                                    Control seller alerts and important account notifications.
                                </div>

                            </div>

                        </div>

                        <form method="POST"
                              action="{{ route('seller.settings.update') }}"
                              id="notification-form">

                            @csrf
                            @method('PUT')

                            <input type="hidden"
                                   name="theme"
                                   value="{{ $seller->theme ?? 'light' }}">

                            <input type="hidden"
                                   name="online_payments_enabled"
                                   value="{{ (bool)($seller->online_payments_enabled ?? false) ? 1 : 0 }}">

                            <div class="setting-row">

                                <div class="setting-info">

                                    <strong>
                                        Seller Notifications
                                    </strong>

                                    <span>
                                        Receive order alerts, account updates and
                                        important seller notifications.
                                    </span>

                                </div>

                                <label class="toggle">

                                    <input type="hidden"
                                           name="notifications_enabled"
                                           value="0">

                                    <input type="checkbox"
                                           name="notifications_enabled"
                                           value="1"
                                           {{ (bool)($seller->notifications_enabled ?? true) ? 'checked' : '' }}>

                                    <span class="toggle-slider"></span>

                                </label>

                            </div>

                            @php

                                $notificationPreferences = [
                                    'new_order_notification' => 'New order notification',
                                    'order_cancellation_notification' => 'Order cancellation',
                                    'payment_received_notification' => 'Payment received',
                                    'payment_failed_notification' => 'Payment failed',
                                    'low_stock_alert' => 'Low stock alert',
                                    'customer_message_notification' => 'Customer message',
                                    'seller_verification_notification' => 'Seller verification notification',
                                    'promotional_notifications' => 'Promotional notifications',
                                    'email_notifications' => 'Email notifications',
                                    'browser_notifications' => 'Browser notifications',
                                ];

                            @endphp

                            @foreach($notificationPreferences as $notificationKey => $notificationLabel)

                                <div class="setting-row">

                                    <div class="setting-info">

                                        <strong>
                                            {{ $notificationLabel }}
                                        </strong>

                                        <span>
                                            Receive this alert in your seller workspace.
                                        </span>

                                    </div>

                                    <label class="toggle">

                                        <input type="hidden"
                                               name="preferences[{{ $notificationKey }}]"
                                               value="0">

                                        <input type="checkbox"
                                               name="preferences[{{ $notificationKey }}]"
                                               value="1"
                                               {{ !empty($preferences[$notificationKey]) ? 'checked' : '' }}>

                                        <span class="toggle-slider"></span>

                                    </label>

                                </div>

                            @endforeach

                            <button type="submit"
                                    class="settings-save">

                                <i class="fa-solid fa-bell"></i>

                                Save Notifications

                            </button>

                        </form>

                    </div>

                </section>

                {{-- =================================================
                     PAYMENTS
                ================================================== --}}

                <section class="settings-section"
                         data-content="payments">

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Payment Settings
                                </div>

                                <div class="settings-card-description">
                                            Configure payout details. Customer online payments are processed and verified by Smart Basket's payment provider.
                                </div>

                            </div>

                        </div>

                        @php

                            $sellerUpiId = old('payment_upi_id', $seller->getPaymentUpiId());
                            $sellerPaymentMobile = old('payment_mobile_number', $seller->payment_mobile_number ?? '');
                            $sellerPaymentBusiness = old('payment_business_name', $seller->payment_business_name ?? $seller->shop_name ?? $seller->seller_name ?? '');

                            $onlinePaymentsEnabled =
                                (bool)($seller->online_payments_enabled ?? false);

                        @endphp

                        <form method="POST"
                              action="{{ route('seller.settings.update') }}"
                              id="payment-settings-form">

                            @csrf
                            @method('PUT')

                            <input type="hidden"
                                   name="theme"
                                   value="{{ $seller->theme ?? 'light' }}">

                            <input type="hidden"
                                   name="notifications_enabled"
                                   value="{{ (bool)($seller->notifications_enabled ?? true) ? 1 : 0 }}">

                            {{-- ONLY VALUE SENT TO LARAVEL FOR ONLINE PAYMENT --}}
                            <input type="hidden"
                                   name="online_payments_enabled"
                                   id="online-payments-enabled-value"
                                   value="{{ $onlinePaymentsEnabled ? 1 : 0 }}">

                            {{-- =================================================
                                 ONLINE PAYMENT TOGGLE
                            ================================================== --}}

                            <div class="setting-row">

                                <div class="setting-info">

                                    <strong>
                                        Online Payments
                                    </strong>

                                    <span>
                                        Allow customers to pay online through Smart Basket's secure payment provider.
                                        Payments are confirmed by the provider, not by a QR scan or customer-submitted details.
                                    </span>

                                </div>

                                <label class="toggle">

                                    {{-- Visual checkbox only --}}
                                    <input type="checkbox"
                                           id="online-payments-toggle"
                                           {{ $onlinePaymentsEnabled ? 'checked' : '' }}>

                                    <span class="toggle-slider"></span>

                                </label>

                            </div>

                            <div class="settings-field" style="margin-top:20px;">
                                <label for="seller-payment-business-name">Payout account name</label>
                                <input id="seller-payment-business-name" class="settings-input" type="text" name="payment_business_name" value="{{ $sellerPaymentBusiness }}" maxlength="150" autocomplete="organization" placeholder="Business or account holder name">
                            </div>

                            <div class="settings-field" style="margin-top:16px;">
                                <label for="seller-upi-id">UPI ID</label>
                                <input id="seller-upi-id" class="settings-input" type="text" name="payment_upi_id" value="{{ $sellerUpiId }}" maxlength="100" autocomplete="off" placeholder="example@upi" inputmode="email">
                            </div>

                            <div class="settings-field" style="margin-top:16px;">
                                <label for="seller-payment-mobile">Mobile number</label>
                                <input id="seller-payment-mobile" class="settings-input" type="tel" name="payment_mobile_number" value="{{ $sellerPaymentMobile }}" maxlength="20" autocomplete="tel" placeholder="10-digit mobile number">
                            </div>

                            <div class="info-box" style="margin-top:17px;">
                                <i class="fa-solid fa-circle-info"></i>
                                <div>No QR image is needed. No QR image is required. UPI settings are saved to your seller profile. Customer payment status still depends on server-side provider verification.</div>
                            </div>

                            {{-- =================================================
                                 PAYMENT STATUS
                            ================================================== --}}

                            <div class="payment-status-card">

                                <div class="payment-status-left">

                                    <div class="payment-status-icon">
                                        <i class="fa-solid fa-money-bill-transfer"></i>
                                    </div>

                                    <div>

                                        <div class="payment-status-title">
                                            Customer Payment Availability
                                        </div>

                                        <div class="payment-status-text">
                                            Current seller payment preference.
                                        </div>

                                    </div>

                                </div>

                                <div
                                    class="payment-status-badge {{ $onlinePaymentsEnabled ? 'enabled' : 'disabled' }}"
                                    id="payment-status-badge"
                                >

                                    <i
                                        class="fa-solid {{ $onlinePaymentsEnabled ? 'fa-circle-check' : 'fa-circle-xmark' }}"
                                        id="payment-status-icon"
                                    ></i>

                                    <span id="payment-status-text">

                                        {{ $onlinePaymentsEnabled
                                            ? 'Online Payments Enabled'
                                            : 'Online Payments Disabled'
                                        }}

                                    </span>

                                </div>

                            </div>

                            <button type="submit"
                                    class="settings-save">

                                <i class="fa-solid fa-floppy-disk"></i>

                                Save Payment Settings

                            </button>

                        </form>

                    </div>

                    <div class="settings-card" id="seller-payment-qr" style="margin-top:22px;">
                        <div class="settings-card-header">
                            <div class="settings-card-icon"><i class="fa-solid fa-qrcode"></i></div>
                            <div>
                                <div class="settings-card-title">Seller QR Code</div>
                                <div class="settings-card-description">Manage the QR image associated with your seller profile. It may be shown on your own product pages.</div>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success" role="status">{{ session('success') }}</div>
                        @endif
                        @if($errors->has('payment_qr'))
                            <div class="alert alert-danger" role="alert">{{ $errors->first('payment_qr') }}</div>
                        @endif

                        @php
                            $sellerQrPath = ltrim((string) $seller->payment_qr, '/');
                            if (str_starts_with($sellerQrPath, 'storage/')) $sellerQrPath = substr($sellerQrPath, 8);
                            $sellerQrExists = $sellerQrPath !== '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($sellerQrPath);
                        @endphp

                        @if($sellerQrExists)
                            <div style="margin:0 0 18px;">
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($sellerQrPath) }}" alt="Your current seller payment QR code" style="display:block;width:min(240px,100%);max-height:260px;object-fit:contain;padding:12px;border:1px solid var(--border-color,#dbe3ef);border-radius:16px;background:#fff;">
                            </div>
                        @else
                            <p class="text-muted">No QR code is currently saved.</p>
                        @endif

                        <form method="POST" action="{{ route('seller.payment-qr.update') }}" enctype="multipart/form-data" style="display:grid;gap:12px;">
                            @csrf
                            <label for="seller-payment-qr-file">Choose a QR image (PNG, JPG, JPEG, WebP; up to 2 MB)</label>
                            <input id="seller-payment-qr-file" type="file" name="payment_qr" accept="image/png,image/jpeg,image/webp" required onchange="previewSellerPaymentQr(this)" class="form-control">
                            <img id="seller-payment-qr-preview" alt="Preview of selected QR code" hidden style="width:min(220px,100%);max-height:240px;object-fit:contain;border-radius:14px;background:#fff;padding:8px;">
                            <button type="submit" class="settings-save"><i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i> {{ $sellerQrExists ? 'Replace QR Code' : 'Upload QR Code' }}</button>
                        </form>

                        @if($sellerQrExists)
                            <form method="POST" action="{{ route('seller.payment-qr.delete') }}" style="margin-top:12px;" onsubmit="return confirm('Remove your seller QR code?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"><i class="fa-regular fa-trash-can" aria-hidden="true"></i> Remove QR Code</button>
                            </form>
                        @endif
                        <p class="small text-muted" style="margin-top:14px;">Displaying a QR code does not verify a payment or mark an order as paid. Payment confirmation remains part of the secure payment workflow.</p>
                    </div>

                </section>

                {{-- =================================================
                     SHIPPING
                ================================================== --}}

                <section class="settings-section"
                         data-content="shipping">

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Shipping Preferences
                                </div>

                                <div class="settings-card-description">
                                    Configure delivery-related preferences for your
                                    seller store.
                                </div>

                            </div>

                        </div>

                        <div class="setting-row">

                            <div class="setting-info">

                                <strong>
                                    Shipping Management
                                </strong>

                                <span>
                                    Shipping preferences can be configured from
                                    the Operations settings.
                                </span>

                            </div>

                            <i class="fa-solid fa-circle-check"
                               style="color:#059669;"
                               aria-hidden="true"></i>

                        </div>

                        <div class="setting-row">

                            <div class="setting-info">

                                <strong>
                                    Delivery Charge
                                </strong>

                                <span>
                                    Current configured delivery charge.
                                </span>

                            </div>

                            <strong>
                                ₹{{ number_format((float)($preferences['delivery_charge'] ?? 0), 2) }}
                            </strong>

                        </div>

                        <div class="setting-row">

                            <div class="setting-info">

                                <strong>
                                    Free Shipping Threshold
                                </strong>

                                <span>
                                    Orders above this amount can qualify for
                                    free shipping.
                                </span>

                            </div>

                            <strong>
                                ₹{{ number_format((float)($preferences['free_shipping_threshold'] ?? 0), 2) }}
                            </strong>

                        </div>

                        <div class="setting-row">

                            <div class="setting-info">

                                <strong>
                                    Estimated Delivery
                                </strong>

                                <span>
                                    Default estimated delivery period.
                                </span>

                            </div>

                            <strong>
                                {{ $preferences['estimated_delivery_days'] ?? 1 }}
                                {{ ((int)($preferences['estimated_delivery_days'] ?? 1) === 1) ? 'Day' : 'Days' }}
                            </strong>

                        </div>

                        <div class="info-box"
                             style="margin-top:18px;">

                            <i class="fa-solid fa-truck-fast"></i>

                            <div>
                                Detailed shipping controls are available under
                                Operations so all delivery preferences remain
                                centralized in one place.
                            </div>

                        </div>

                    </div>

                </section>

                {{-- =================================================
                     APPEARANCE
                ================================================== --}}

                <section class="settings-section"
                         data-content="appearance">

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-palette"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Appearance & Theme
                                </div>

                                <div class="settings-card-description">
                                    Choose the appearance of your Smart Basket
                                    seller workspace.
                                </div>

                            </div>

                        </div>

                        <form id="theme-settings-form"
                              method="POST"
                              action="{{ route('seller.settings.update') }}">

                            @csrf
                            @method('PUT')

                            <input type="hidden"
                                   name="notifications_enabled"
                                   value="{{ (bool)($seller->notifications_enabled ?? true) ? 1 : 0 }}">

                            <input type="hidden"
                                   name="online_payments_enabled"
                                   value="{{ (bool)($seller->online_payments_enabled ?? false) ? 1 : 0 }}">

                            <div class="theme-options">

                                <div class="theme-option">

                                    <input type="radio"
                                           name="theme"
                                           value="dark"
                                           id="theme-dark"
                                           {{ ($seller->theme ?? 'light') === 'dark' ? 'checked' : '' }}>

                                    <label for="theme-dark"
                                           class="theme-label">

                                        <div class="theme-preview dark"></div>

                                        <div class="theme-name">
                                            Dark Premium
                                        </div>

                                        <div class="theme-description">
                                            Premium dark dashboard
                                        </div>

                                    </label>

                                </div>

                                <div class="theme-option">

                                    <input type="radio"
                                           name="theme"
                                           value="light"
                                           id="theme-light"
                                           {{ ($seller->theme ?? 'light') === 'light' ? 'checked' : '' }}>

                                    <label for="theme-light"
                                           class="theme-label">

                                        <div class="theme-preview light"></div>

                                        <div class="theme-name">
                                            Light
                                        </div>

                                        <div class="theme-description">
                                            Clean blue & white interface
                                        </div>

                                    </label>

                                </div>

                                <div class="theme-option">

                                    <input type="radio"
                                           name="theme"
                                           value="system"
                                           id="theme-system"
                                           {{ ($seller->theme ?? 'light') === 'system' ? 'checked' : '' }}>

                                    <label for="theme-system"
                                           class="theme-label">

                                        <div class="theme-preview auto"></div>

                                        <div class="theme-name">
                                            System
                                        </div>

                                        <div class="theme-description">
                                            Follow device appearance
                                        </div>

                                    </label>

                                </div>

                            </div>

                            <button type="submit"
                                    class="settings-save">

                                <i class="fa-solid fa-palette"></i>

                                Save Theme

                            </button>

                        </form>

                    </div>

                </section>

                {{-- =================================================
                     SECURITY
                ================================================== --}}

                <section class="settings-section"
                         data-content="security">

                    <div class="settings-card">

                        <div class="settings-card-header">

                            <div class="settings-card-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>

                            <div>

                                <div class="settings-card-title">
                                    Account Security
                                </div>

                                <div class="settings-card-description">
                                    Protect your seller account and update your
                                    password securely.
                                </div>

                            </div>

                        </div>

                        <form method="POST"
                              action="{{ route('seller.settings.password') }}"
                              class="settings-grid"
                              style="margin-top:4px;">

                            @csrf
                            @method('PUT')

                            <div class="settings-field">

                                <label for="current_password">
                                    Current Password
                                </label>

                                <input id="current_password"
                                       class="settings-input"
                                       type="password"
                                       name="current_password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="Enter current password">

                            </div>

                            <div class="settings-field">

                                <label for="password">
                                    New Password
                                </label>

                                <input id="password"
                                       class="settings-input"
                                       type="password"
                                       name="password"
                                       required
                                       autocomplete="new-password"
                                       placeholder="Enter new password">

                            </div>

                            <div class="settings-field">

                                <label for="password_confirmation">
                                    Confirm New Password
                                </label>

                                <input id="password_confirmation"
                                       class="settings-input"
                                       type="password"
                                       name="password_confirmation"
                                       required
                                       autocomplete="new-password"
                                       placeholder="Confirm new password">

                            </div>

                            <div class="settings-field"
                                 style="justify-content:flex-end;">

                                <button type="submit"
                                        class="settings-save">

                                    <i class="fa-solid fa-key"></i>

                                    Change Password

                                </button>

                            </div>

                        </form>

                        <div class="security-item">

                            <div class="security-left">

                                <div class="security-icon">
                                    <i class="fa-solid fa-lock"></i>
                                </div>

                                <div>

                                    <div class="security-title">
                                        Password Protection
                                    </div>

                                    <div class="security-text">
                                        Use a strong password and keep your seller
                                        account credentials private.
                                    </div>

                                </div>

                            </div>

                            <i class="fa-solid fa-circle-check"
                               style="color:#059669;"
                               aria-hidden="true"></i>

                        </div>

                        <div class="security-item">

                            <div class="security-left">

                                <div class="security-icon">
                                    <i class="fa-solid fa-user-shield"></i>
                                </div>

                                <div>

                                    <div class="security-title">
                                        Seller Account
                                    </div>

                                    <div class="security-text">
                                        Your seller identity and account information
                                        are protected.
                                    </div>

                                </div>

                            </div>

                            <i class="fa-solid fa-shield-halved"
                               style="color:#2563eb;"
                               aria-hidden="true"></i>

                        </div>

                        <div class="info-box"
                             style="margin-top:17px;">

                            <i class="fa-solid fa-circle-info"></i>

                            <div>
                                For security, password changes require your current
                                password before the new password can be saved.
                            </div>

                        </div>

                    </div>

                </section>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       SETTINGS TABS
    ===================================================== */

    const buttons =
        document.querySelectorAll('.settings-nav-item');

    const sections =
        document.querySelectorAll('.settings-section');

    function openSection(sectionName) {

        buttons.forEach(function (button) {

            button.classList.toggle(
                'active',
                button.dataset.section === sectionName
            );

        });

        sections.forEach(function (section) {

            section.classList.toggle(
                'active',
                section.dataset.content === sectionName
            );

        });

        try {

            localStorage.setItem(
                'smartbasket_settings_section',
                sectionName
            );

        } catch (e) {}

    }

    buttons.forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                const sectionName =
                    this.dataset.section;

                if (!sectionName) {
                    return;
                }

                openSection(sectionName);

                if (window.innerWidth <= 1000) {

                    const content =
                        document.querySelector(
                            '.settings-content'
                        );

                    if (content) {

                        setTimeout(
                            function () {

                                content.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });

                            },
                            50
                        );

                    }

                }

            }
        );

    });

    let savedSection = null;

    try {

        savedSection =
            localStorage.getItem(
                'smartbasket_settings_section'
            );

    } catch (e) {}

    const requestedSection = new URLSearchParams(window.location.search).get('_section');

    if (
        requestedSection &&
        document.querySelector('[data-content="' + requestedSection + '"]')
    ) {
        openSection(requestedSection);
    } else if (
        savedSection &&
        document.querySelector(
            '[data-content="' + savedSection + '"]'
        )
    ) {

        openSection(savedSection);

    } else {

        openSection('store');

    }


    /* =====================================================
       THEME SYSTEM
    ===================================================== */

    const themeRadios =
        document.querySelectorAll(
            'input[name="theme"]'
        );

    const html =
        document.documentElement;

    function systemTheme() {

        return window.matchMedia(
            '(prefers-color-scheme: dark)'
        ).matches
            ? 'dark'
            : 'light';

    }

    function applySellerTheme(theme) {

        let finalTheme = theme;

        if (theme === 'system') {
            finalTheme = systemTheme();
        }

        if (
            finalTheme !== 'dark' &&
            finalTheme !== 'light'
        ) {
            finalTheme = 'light';
        }

        html.classList.add(
            'theme-transition'
        );

        html.setAttribute(
            'data-theme',
            finalTheme
        );

        html.setAttribute(
            'data-sb-theme',
            finalTheme
        );

        html.setAttribute(
            'data-seller-theme',
            theme
        );

        try {

            localStorage.setItem(
                'smartbasket_seller_theme',
                theme
            );

        } catch (e) {}

        window.dispatchEvent(
            new CustomEvent(
                'smartbasket-theme-changed',
                {
                    detail: {
                        theme: theme,
                        finalTheme: finalTheme
                    }
                }
            )
        );

        setTimeout(
            function () {

                html.classList.remove(
                    'theme-transition'
                );

            },
            300
        );

    }

    themeRadios.forEach(function (radio) {

        radio.addEventListener(
            'change',
            function () {

                if (this.checked) {
                    applySellerTheme(
                        this.value
                    );
                }

            }
        );

    });

    const databaseTheme =
        @json($seller->theme ?? 'light');

    const initialTheme =
        databaseTheme || 'light';

    const initialRadio =
        document.querySelector(
            'input[name="theme"][value="' +
            initialTheme +
            '"]'
        );

    if (initialRadio) {
        initialRadio.checked = true;
    }

    applySellerTheme(
        initialTheme
    );


    /* =====================================================
       SYSTEM THEME CHANGE
    ===================================================== */

    const mediaQuery =
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        );

    function handleSystemThemeChange() {

        let current = null;

        try {

            current =
                localStorage.getItem(
                    'smartbasket_seller_theme'
                );

        } catch (e) {}

        if (current === 'system') {

            applySellerTheme(
                'system'
            );

        }

    }

    if (
        typeof mediaQuery.addEventListener ===
        'function'
    ) {

        mediaQuery.addEventListener(
            'change',
            handleSystemThemeChange
        );

    } else {

        mediaQuery.addListener(
            handleSystemThemeChange
        );

    }


    /* =====================================================
       THEME FORM SAVE
    ===================================================== */

    const themeForm =
        document.getElementById(
            'theme-settings-form'
        );

    if (themeForm) {

        themeForm.addEventListener(
            'submit',
            function () {

                const checked =
                    document.querySelector(
                        'input[name="theme"]:checked'
                    );

                if (checked) {

                    try {

                        localStorage.setItem(
                            'smartbasket_seller_theme',
                            checked.value
                        );

                    } catch (e) {}

                }

            }
        );

    }


    /* =====================================================
       TOGGLE VISUAL FEEDBACK
    ===================================================== */

    document.querySelectorAll(
        '.toggle input[type="checkbox"]'
    ).forEach(function (input) {

        input.addEventListener(
            'change',
            function () {

                const row =
                    this.closest('.setting-row');

                if (!row) {
                    return;
                }

                row.classList.add(
                    'setting-changed'
                );

                setTimeout(
                    function () {

                        row.classList.remove(
                            'setting-changed'
                        );

                    },
                    550
                );

            }
        );

    });


    /* =====================================================
       ONLINE PAYMENT LIVE STATUS
    ===================================================== */

    const paymentCheckbox =
        document.getElementById(
            'online-payments-toggle'
        );

    const paymentValue =
        document.getElementById(
            'online-payments-enabled-value'
        );

    const paymentBadge =
        document.getElementById(
            'payment-status-badge'
        );

    const paymentStatusIcon =
        document.getElementById(
            'payment-status-icon'
        );

    const paymentStatusText =
        document.getElementById(
            'payment-status-text'
        );

    function updatePaymentStatus() {

        if (
            !paymentCheckbox ||
            !paymentValue ||
            !paymentBadge ||
            !paymentStatusIcon ||
            !paymentStatusText
        ) {
            return;
        }

        paymentValue.value =
            paymentCheckbox.checked
                ? '1'
                : '0';

        if (paymentCheckbox.checked) {

            paymentBadge.classList.remove(
                'disabled'
            );

            paymentBadge.classList.add(
                'enabled'
            );

            paymentStatusIcon.className =
                'fa-solid fa-circle-check';

            paymentStatusText.textContent =
                'Online Payments Enabled';

        } else {

            paymentBadge.classList.remove(
                'enabled'
            );

            paymentBadge.classList.add(
                'disabled'
            );

            paymentStatusIcon.className =
                'fa-solid fa-circle-xmark';

            paymentStatusText.textContent =
                'Online Payments Disabled';

        }

    }

    if (paymentCheckbox) {

        paymentCheckbox.addEventListener(
            'change',
            updatePaymentStatus
        );

        updatePaymentStatus();

    }


    /* =====================================================
       PAYMENT FORM SAVE
    ===================================================== */

    const paymentForm =
        document.getElementById(
            'payment-settings-form'
        );

    if (paymentForm) {

        paymentForm.addEventListener(
            'submit',
            function () {

                if (
                    paymentCheckbox &&
                    paymentValue
                ) {

                    paymentValue.value =
                        paymentCheckbox.checked
                            ? '1'
                            : '0';

                }

            }
        );

    }


    /* =====================================================
       AUTO HIDE ALERT
    ===================================================== */

    const alerts =
        document.querySelectorAll(
            '.settings-alert'
        );

    alerts.forEach(function (alert) {

        setTimeout(
            function () {

                alert.style.transition =
                    'opacity .3s ease, transform .3s ease';

                alert.style.opacity = '0';

                alert.style.transform =
                    'translateY(-5px)';

                setTimeout(
                    function () {

                        if (alert.parentNode) {

                            alert.parentNode.removeChild(
                                alert
                            );

                        }

                    },
                    300
                );

            },
            5000
        );

    });


    /* =====================================================
       PASSWORD CONFIRMATION UX
    ===================================================== */

    const password =
        document.getElementById(
            'password'
        );

    const passwordConfirmation =
        document.getElementById(
            'password_confirmation'
        );

    if (
        password &&
        passwordConfirmation
    ) {

        passwordConfirmation.addEventListener(
            'input',
            function () {

                if (
                    password.value &&
                    this.value &&
                    password.value !== this.value
                ) {

                    this.style.borderColor =
                        '#ef4444';

                } else {

                    this.style.borderColor =
                        '';

                }

            }
        );

    }

});
</script>

<script>
function previewSellerPaymentQr(input) {
    const preview = document.getElementById('seller-payment-qr-preview');
    if (!preview) return;
    if (preview.dataset.objectUrl) URL.revokeObjectURL(preview.dataset.objectUrl);
    if (input.files && input.files[0]) {
        const url = URL.createObjectURL(input.files[0]);
        preview.src = url;
        preview.dataset.objectUrl = url;
        preview.hidden = false;
    } else {
        preview.removeAttribute('src');
        preview.hidden = true;
    }
}
</script>

@endsection
