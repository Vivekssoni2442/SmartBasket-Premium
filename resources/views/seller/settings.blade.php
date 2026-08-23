@extends('seller.partials.premium-layout')

@section('title', 'Seller Settings')


@section('content')

<style>

/* =========================================================
   SMART BASKET SELLER SETTINGS
   ========================================================= */

.seller-settings-page {

    min-height: 100vh;

    padding: 30px;

    background:
        var(--sb-bg) !important;

    color:
        var(--sb-text) !important;

}


/* =========================================================
   HEADER
   ========================================================= */

.settings-header {

    margin-bottom: 25px;

}

.settings-header h1 {

    margin: 0;

    font-size: 29px;

    font-weight: 800;

    color:
        var(--sb-text) !important;

}

.settings-header h1 span {

    color:
        var(--sb-primary) !important;

}

.settings-header p {

    margin-top: 7px;

    color:
        var(--sb-text-secondary) !important;

    font-size: 12px;

}


/* =========================================================
   LAYOUT
   ========================================================= */

.settings-layout {

    display: grid;

    grid-template-columns:
        250px minmax(0, 1fr);

    gap: 20px;

    align-items: start;

}


/* =========================================================
   NAVIGATION
   ========================================================= */

.settings-nav {

    position: sticky;

    top: 20px;

    padding: 10px;

    border-radius: 20px;

    border:
        1px solid var(--sb-border) !important;

    background:
        var(--sb-card) !important;

    box-shadow:
        var(--sb-shadow);

    backdrop-filter:
        blur(18px);

}

.settings-nav-title {

    padding: 13px;

    color:
        var(--sb-text-secondary) !important;

    font-size: 10px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 1px;

}

.settings-nav-item {

    width: 100%;

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 12px 13px;

    margin-bottom: 3px;

    border-radius: 12px;

    border: 0;

    background:
        transparent !important;

    color:
        var(--sb-text-secondary) !important;

    text-align: left;

    font-size: 11px;

    font-weight: 600;

    cursor: pointer;

    transition:
        background .2s ease,
        color .2s ease,
        transform .2s ease;

}

.settings-nav-item i {

    width: 22px;

    color:
        var(--sb-text-secondary) !important;

}

.settings-nav-item:hover {

    background:
        var(--sb-card-hover) !important;

    color:
        var(--sb-primary) !important;

    transform:
        translateX(2px);

}

.settings-nav-item:hover i {

    color:
        var(--sb-primary) !important;

}

.settings-nav-item.active {

    background:
        color-mix(
            in srgb,
            var(--sb-primary) 12%,
            transparent
        ) !important;

    color:
        var(--sb-primary) !important;

    box-shadow:
        inset 3px 0 var(--sb-primary);

}

.settings-nav-item.active i {

    color:
        var(--sb-primary) !important;

}


/* =========================================================
   CONTENT
   ========================================================= */

.settings-content {

    min-width: 0;

}

.settings-section {

    display: none;

}

.settings-section.active {

    display: block;

    animation:
        settingsFade .25s ease;

}

@keyframes settingsFade {

    from {

        opacity: 0;

        transform:
            translateY(6px);

    }

    to {

        opacity: 1;

        transform:
            translateY(0);

    }

}


/* =========================================================
   CARD
   ========================================================= */

.settings-card {

    margin-bottom: 18px;

    padding: 23px;

    border-radius: 21px;

    border:
        1px solid var(--sb-border) !important;

    background:
        var(--sb-card) !important;

    color:
        var(--sb-text) !important;

    box-shadow:
        var(--sb-shadow);

    backdrop-filter:
        blur(18px);

}

.settings-card-header {

    display: flex;

    align-items: center;

    gap: 13px;

    margin-bottom: 20px;

}

.settings-card-icon {

    width: 43px;

    height: 43px;

    border-radius: 13px;

    display: flex;

    align-items: center;

    justify-content: center;

    background:
        color-mix(
            in srgb,
            var(--sb-primary) 10%,
            transparent
        ) !important;

    color:
        var(--sb-primary) !important;

}

.settings-card-title {

    font-size: 15px;

    font-weight: 800;

    color:
        var(--sb-text) !important;

}

.settings-card-description {

    margin-top: 3px;

    color:
        var(--sb-text-secondary) !important;

    font-size: 10px;

}


/* =========================================================
   PROFILE
   ========================================================= */

.seller-profile-banner {

    display: flex;

    align-items: center;

    gap: 16px;

    padding: 18px;

    margin-bottom: 18px;

    border-radius: 17px;

    background:
        linear-gradient(
            135deg,
            color-mix(
                in srgb,
                var(--sb-primary) 10%,
                transparent
            ),
            color-mix(
                in srgb,
                var(--sb-primary) 3%,
                transparent
            )
        ) !important;

    border:
        1px solid
        color-mix(
            in srgb,
            var(--sb-primary) 15%,
            transparent
        ) !important;

}

.seller-avatar {

    width: 58px;

    height: 58px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 17px;

    background:
        linear-gradient(
            135deg,
            var(--sb-primary),
            var(--sb-primary-hover)
        ) !important;

    color: #fff !important;

    font-size: 21px;

    font-weight: 800;

}

.seller-profile-name {

    font-size: 15px;

    font-weight: 800;

    color:
        var(--sb-text) !important;

}

.seller-profile-email {

    margin-top: 3px;

    color:
        var(--sb-text-secondary) !important;

    font-size: 10px;

}


/* =========================================================
   FORM
   ========================================================= */

.settings-grid {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 15px;

}

.settings-field {

    display: flex;

    flex-direction: column;

    gap: 7px;

}

.settings-field.full {

    grid-column:
        1 / -1;

}

.settings-field label {

    color:
        var(--sb-text-secondary) !important;

    font-size: 10px;

    font-weight: 600;

}

.settings-input,
.settings-select {

    width: 100%;

    min-height: 45px;

    padding: 10px 13px;

    border-radius: 12px;

    border:
        1px solid var(--sb-border) !important;

    outline: none;

    background:
        var(--sb-input) !important;

    color:
        var(--sb-text) !important;

    font-size: 11px;

    transition:
        border .2s ease,
        box-shadow .2s ease,
        background .2s ease;

}

.settings-input:focus,
.settings-select:focus {

    border-color:
        var(--sb-primary) !important;

    box-shadow:
        0 0 0 3px
        color-mix(
            in srgb,
            var(--sb-primary) 10%,
            transparent
        ) !important;

}

.settings-input::placeholder {

    color:
        var(--sb-text-secondary) !important;

}

.settings-select option {

    background:
        var(--sb-card);

    color:
        var(--sb-text);

}


/* =========================================================
   TOGGLE
   ========================================================= */

.setting-row {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding: 16px 0;

    border-bottom:
        1px solid var(--sb-border) !important;

}

.setting-row:last-child {

    border-bottom: 0;

}

.setting-info strong {

    display: block;

    color:
        var(--sb-text) !important;

    font-size: 12px;

}

.setting-info span {

    display: block;

    margin-top: 4px;

    color:
        var(--sb-text-secondary) !important;

    font-size: 10px;

}

.toggle {

    position: relative;

    width: 48px;

    height: 27px;

    flex-shrink: 0;

}

.toggle input {

    opacity: 0;

    width: 0;

    height: 0;

}

.toggle-slider {

    position: absolute;

    inset: 0;

    border-radius: 30px;

    background:
        var(--sb-border) !important;

    border:
        1px solid var(--sb-border);

    cursor: pointer;

    transition: .25s;

}

.toggle-slider::before {

    content: "";

    position: absolute;

    width: 19px;

    height: 19px;

    left: 4px;

    top: 3px;

    border-radius: 50%;

    background:
        var(--sb-text) !important;

    transition: .25s;

}

.toggle input:checked + .toggle-slider {

    background:
        var(--sb-primary) !important;

    border-color:
        var(--sb-primary) !important;

}

.toggle input:checked + .toggle-slider::before {

    transform:
        translateX(21px);

    background:
        #fff !important;

}


/* =========================================================
   THEME OPTIONS
   ========================================================= */

.theme-options {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 13px;

}

.theme-option {

    position: relative;

}

.theme-option input {

    position: absolute;

    opacity: 0;

}

.theme-label {

    display: block;

    padding: 15px;

    border-radius: 15px;

    border:
        1px solid var(--sb-border) !important;

    background:
        var(--sb-card-hover) !important;

    color:
        var(--sb-text) !important;

    cursor: pointer;

    transition:
        .25s ease;

}

.theme-label:hover {

    border-color:
        var(--sb-primary) !important;

}

.theme-option input:checked + .theme-label {

    border-color:
        var(--sb-primary) !important;

    background:
        color-mix(
            in srgb,
            var(--sb-primary) 8%,
            var(--sb-card)
        ) !important;

    box-shadow:
        0 0 20px
        color-mix(
            in srgb,
            var(--sb-primary) 10%,
            transparent
        );

}

.theme-preview {

    height: 65px;

    border-radius: 10px;

    margin-bottom: 10px;

}

.theme-preview.dark {

    background:
        linear-gradient(
            135deg,
            #020617,
            #111827
        );

}

.theme-preview.light {

    background:
        linear-gradient(
            135deg,
            #ffffff,
            #dbeafe
        );

}

.theme-preview.auto {

    background:
        linear-gradient(
            90deg,
            #020617 50%,
            #ffffff 50%
        );

}

.theme-name {

    font-size: 11px;

    font-weight: 700;

    color:
        var(--sb-text) !important;

}

.theme-description {

    margin-top: 3px;

    color:
        var(--sb-text-secondary) !important;

    font-size: 9px;

}


/* =========================================================
   SECURITY
   ========================================================= */

.security-item {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    padding: 17px;

    border-radius: 14px;

    background:
        var(--sb-card-hover) !important;

    border:
        1px solid var(--sb-border) !important;

    margin-bottom: 10px;

}

.security-item:last-child {

    margin-bottom: 0;

}

.security-left {

    display: flex;

    align-items: center;

    gap: 13px;

}

.security-icon {

    width: 40px;

    height: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background:
        color-mix(
            in srgb,
            var(--sb-primary) 10%,
            transparent
        ) !important;

    color:
        var(--sb-primary) !important;

}

.security-title {

    font-size: 11px;

    font-weight: 700;

    color:
        var(--sb-text) !important;

}

.security-text {

    margin-top: 3px;

    color:
        var(--sb-text-secondary) !important;

    font-size: 9px;

}

.security-btn {

    padding: 9px 13px;

    border-radius: 10px;

    border:
        1px solid
        color-mix(
            in srgb,
            var(--sb-primary) 20%,
            transparent
        ) !important;

    background:
        color-mix(
            in srgb,
            var(--sb-primary) 8%,
            transparent
        ) !important;

    color:
        var(--sb-primary) !important;

    font-size: 10px;

    font-weight: 700;

    cursor: pointer;

    text-decoration: none;

}

.security-btn:hover {

    background:
        var(--sb-primary) !important;

    color:
        #fff !important;

}


/* =========================================================
   SAVE BUTTON
   ========================================================= */

.settings-save {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    padding: 12px 20px;

    border: 0;

    border-radius: 12px;

    background:
        linear-gradient(
            135deg,
            var(--sb-primary),
            var(--sb-primary-hover)
        ) !important;

    color:
        #fff !important;

    font-size: 11px;

    font-weight: 800;

    cursor: pointer;

    box-shadow:
        0 10px 25px
        color-mix(
            in srgb,
            var(--sb-primary) 18%,
            transparent
        );

    transition:
        transform .2s ease;

}

.settings-save:hover {

    transform:
        translateY(-1px);

}


/* =========================================================
   MOBILE
   ========================================================= */

@media(max-width:900px) {

    .settings-layout {

        grid-template-columns:
            1fr;

    }

    .settings-nav {

        position: relative;

        top: 0;

        display: flex;

        overflow-x: auto;

        gap: 4px;

    }

    .settings-nav-title {

        display: none;

    }

    .settings-nav-item {

        min-width:
            max-content;

    }

}


@media(max-width:600px) {

    .seller-settings-page {

        padding:
            20px 15px;

    }

    .settings-header h1 {

        font-size: 22px;

    }

    .settings-grid {

        grid-template-columns:
            1fr;

    }

    .theme-options {

        grid-template-columns:
            1fr;

    }

    .settings-card {

        padding: 17px;

    }

}

</style>


<div class="seller-settings-page">


    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="settings-header">

        <h1>
            Seller <span>Settings</span>
        </h1>

        <p>
            Manage your store, account, notifications, security and seller preferences.
        </p>

    </div>


    <div class="settings-layout">


        {{-- =====================================================
             NAVIGATION
        ====================================================== --}}

        <aside class="settings-nav">

            <div class="settings-nav-title">
                Settings
            </div>


            <button
                type="button"
                class="settings-nav-item active"
                data-section="store"
            >

                <i class="fa-solid fa-store"></i>

                Store Settings

            </button>


            <button
                type="button"
                class="settings-nav-item"
                data-section="account"
            >

                <i class="fa-solid fa-user"></i>

                Account

            </button>


            <button
                type="button"
                class="settings-nav-item"
                data-section="notifications"
            >

                <i class="fa-solid fa-bell"></i>

                Notifications

            </button>


            <button
                type="button"
                class="settings-nav-item"
                data-section="payments"
            >

                <i class="fa-solid fa-credit-card"></i>

                Payments

            </button>


            <button
                type="button"
                class="settings-nav-item"
                data-section="shipping"
            >

                <i class="fa-solid fa-truck"></i>

                Shipping

            </button>


            <button
                type="button"
                class="settings-nav-item"
                data-section="appearance"
            >

                <i class="fa-solid fa-palette"></i>

                Appearance

            </button>


            <button
                type="button"
                class="settings-nav-item"
                data-section="security"
            >

                <i class="fa-solid fa-shield-halved"></i>

                Security

            </button>

        </aside>


        {{-- =====================================================
             CONTENT
        ====================================================== --}}

        <div class="settings-content">


            {{-- =================================================
                 STORE
            ================================================== --}}

            <section
                class="settings-section active"
                data-content="store"
            >

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
                                Manage how your seller store appears to customers.
                            </div>

                        </div>

                    </div>


                    <div class="seller-profile-banner">

                        <div class="seller-avatar">
                            SB
                        </div>

                        <div>

                            <div class="seller-profile-name">
                                {{ $seller->name ?? 'Seller' }}
                            </div>

                            <div class="seller-profile-email">
                                {{ $seller->email ?? 'Seller account' }}
                            </div>

                        </div>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('seller.settings.update') }}"
                    >

                        @csrf

                        @method('PUT')


                        <div class="settings-grid">

                            <div class="settings-field">

                                <label>
                                    Store Name
                                </label>

                                <input
                                    type="text"
                                    name="store_name"
                                    class="settings-input"
                                    value="{{ old('store_name', $seller->store_name ?? '') }}"
                                    placeholder="Your store name"
                                >

                            </div>


                            <div class="settings-field">

                                <label>
                                    Business Type
                                </label>

                                <select
                                    name="business_type"
                                    class="settings-select"
                                >

                                    <option value="">
                                        Select business type
                                    </option>

                                    <option
                                        value="individual"
                                        {{ ($seller->business_type ?? '') === 'individual' ? 'selected' : '' }}
                                    >
                                        Individual
                                    </option>

                                    <option
                                        value="proprietorship"
                                        {{ ($seller->business_type ?? '') === 'proprietorship' ? 'selected' : '' }}
                                    >
                                        Proprietorship
                                    </option>

                                    <option
                                        value="partnership"
                                        {{ ($seller->business_type ?? '') === 'partnership' ? 'selected' : '' }}
                                    >
                                        Partnership
                                    </option>

                                    <option
                                        value="company"
                                        {{ ($seller->business_type ?? '') === 'company' ? 'selected' : '' }}
                                    >
                                        Private / Public Company
                                    </option>

                                </select>

                            </div>


                            <div class="settings-field full">

                                <label>
                                    Store Description
                                </label>

                                <textarea
                                    name="store_description"
                                    class="settings-input"
                                    rows="4"
                                    placeholder="Tell customers about your store..."
                                >{{ old('store_description', $seller->store_description ?? '') }}</textarea>

                            </div>

                        </div>


                        <br>


                        <button
                            type="submit"
                            class="settings-save"
                        >

                            <i class="fa-solid fa-check"></i>

                            Save Store Settings

                        </button>

                    </form>

                </div>

            </section>


            {{-- =================================================
                 ACCOUNT
            ================================================== --}}

            <section
                class="settings-section"
                data-content="account"
            >

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
                                Your seller account information.
                            </div>

                        </div>

                    </div>


                    <div class="settings-grid">

                        <div class="settings-field">

                            <label>
                                Seller Name
                            </label>

                            <input
                                type="text"
                                class="settings-input"
                                value="{{ $seller->name ?? '' }}"
                                readonly
                            >

                        </div>


                        <div class="settings-field">

                            <label>
                                Email Address
                            </label>

                            <input
                                type="email"
                                class="settings-input"
                                value="{{ $seller->email ?? '' }}"
                                readonly
                            >

                        </div>


                        <div class="settings-field">

                            <label>
                                Phone Number
                            </label>

                            <input
                                type="text"
                                class="settings-input"
                                value="{{ $seller->phone ?? '' }}"
                                readonly
                            >

                        </div>


                        <div class="settings-field">

                            <label>
                                Seller Status
                            </label>

                            <input
                                type="text"
                                class="settings-input"
                                value="Active"
                                readonly
                            >

                        </div>

                    </div>

                </div>

            </section>


            {{-- =================================================
                 NOTIFICATIONS
            ================================================== --}}

            <section
                class="settings-section"
                data-content="notifications"
            >

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
                                Control seller alerts and order notifications.
                            </div>

                        </div>

                    </div>


                    @foreach([
                        [
                            'title' => 'New Order Alerts',
                            'text' => 'Get notified when a customer places an order.',
                            'checked' => true
                        ],
                        [
                            'title' => 'Payment Notifications',
                            'text' => 'Receive alerts when payments are completed.',
                            'checked' => true
                        ],
                        [
                            'title' => 'Low Stock Alerts',
                            'text' => 'Get notified when products are running low.',
                            'checked' => true
                        ],
                        [
                            'title' => 'Marketing Updates',
                            'text' => 'Receive SMART BASKET seller offers and updates.',
                            'checked' => false
                        ]
                    ] as $notification)

                        <div class="setting-row">

                            <div class="setting-info">

                                <strong>
                                    {{ $notification['title'] }}
                                </strong>

                                <span>
                                    {{ $notification['text'] }}
                                </span>

                            </div>


                            <label class="toggle">

                                <input
                                    type="checkbox"
                                    {{ $notification['checked'] ? 'checked' : '' }}
                                >

                                <span class="toggle-slider"></span>

                            </label>

                        </div>

                    @endforeach

                </div>

            </section>


            {{-- =================================================
                 PAYMENTS
            ================================================== --}}

            <section
                class="settings-section"
                data-content="payments"
            >

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
                                Manage your seller payment preferences.
                            </div>

                        </div>

                    </div>


                    <div class="setting-row">

                        <div class="setting-info">

                            <strong>
                                UPI Payments
                            </strong>

                            <span>
                                Accept supported UPI payments from customers.
                            </span>

                        </div>

                        <label class="toggle">

                            <input
                                type="checkbox"
                                checked
                            >

                            <span class="toggle-slider"></span>

                        </label>

                    </div>


                    <div class="setting-row">

                        <div class="setting-info">

                            <strong>
                                Online Payments
                            </strong>

                            <span>
                                Enable online payment processing.
                            </span>

                        </div>

                        <label class="toggle">

                            <input
                                type="checkbox"
                                checked
                            >

                            <span class="toggle-slider"></span>

                        </label>

                    </div>


                    <div class="setting-row">

                        <div class="setting-info">

                            <strong>
                                Payment QR
                            </strong>

                            <span>
                                Manage your seller payment QR code.
                            </span>

                        </div>

                        <a
                            href="{{ route('seller.profile') }}"
                            class="security-btn"
                        >
                            Manage
                        </a>

                    </div>

                </div>

            </section>


            {{-- =================================================
                 SHIPPING
            ================================================== --}}

            <section
                class="settings-section"
                data-content="shipping"
            >

                <div class="settings-card">

                    <div class="settings-card-header">

                        <div class="settings-card-icon">
                            <i class="fa-solid fa-truck"></i>
                        </div>

                        <div>

                            <div class="settings-card-title">
                                Shipping Preferences
                            </div>

                            <div class="settings-card-description">
                                Configure your store delivery preferences.
                            </div>

                        </div>

                    </div>


                    <div class="settings-grid">

                        <div class="settings-field">

                            <label>
                                Processing Time
                            </label>

                            <select class="settings-select">

                                <option>
                                    Same Day
                                </option>

                                <option selected>
                                    1 - 2 Days
                                </option>

                                <option>
                                    3 - 5 Days
                                </option>

                                <option>
                                    5 - 7 Days
                                </option>

                            </select>

                        </div>


                        <div class="settings-field">

                            <label>
                                Default Shipping
                            </label>

                            <select class="settings-select">

                                <option selected>
                                    Standard Delivery
                                </option>

                                <option>
                                    Express Delivery
                                </option>

                            </select>

                        </div>

                    </div>


                    <br>


                    <div class="setting-row">

                        <div class="setting-info">

                            <strong>
                                Free Shipping
                            </strong>

                            <span>
                                Offer free shipping when eligible.
                            </span>

                        </div>

                        <label class="toggle">

                            <input type="checkbox">

                            <span class="toggle-slider"></span>

                        </label>

                    </div>


                    <div class="setting-row">

                        <div class="setting-info">

                            <strong>
                                Order Tracking
                            </strong>

                            <span>
                                Allow customers to track delivery status.
                            </span>

                        </div>

                        <label class="toggle">

                            <input
                                type="checkbox"
                                checked
                            >

                            <span class="toggle-slider"></span>

                        </label>

                    </div>

                </div>

            </section>


            {{-- =================================================
                 APPEARANCE
            ================================================== --}}

            <section
                class="settings-section"
                data-content="appearance"
            >

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
                                Choose how your seller dashboard looks.
                            </div>

                        </div>

                    </div>


                    <form
                        id="theme-settings-form"
                        method="POST"
                        action="{{ route('seller.settings.update') }}"
                    >

                        @csrf

                        @method('PUT')


                        <div class="theme-options">


                            {{-- DARK --}}

                            <div class="theme-option">

                                <input
                                    type="radio"
                                    name="theme"
                                    value="dark"
                                    id="theme-dark"
                                    {{ ($seller->theme ?? 'dark') === 'dark' ? 'checked' : '' }}
                                >

                                <label
                                    for="theme-dark"
                                    class="theme-label"
                                >

                                    <div class="theme-preview dark"></div>

                                    <div class="theme-name">
                                        Dark Premium
                                    </div>

                                    <div class="theme-description">
                                        Recommended for SMART BASKET
                                    </div>

                                </label>

                            </div>


                            {{-- LIGHT --}}

                            <div class="theme-option">

                                <input
                                    type="radio"
                                    name="theme"
                                    value="light"
                                    id="theme-light"
                                    {{ ($seller->theme ?? 'dark') === 'light' ? 'checked' : '' }}
                                >

                                <label
                                    for="theme-light"
                                    class="theme-label"
                                >

                                    <div class="theme-preview light"></div>

                                    <div class="theme-name">
                                        Light
                                    </div>

                                    <div class="theme-description">
                                        Clean bright interface
                                    </div>

                                </label>

                            </div>


                            {{-- SYSTEM --}}

                            <div class="theme-option">

                                <input
                                    type="radio"
                                    name="theme"
                                    value="auto"
                                    id="theme-auto"
                                    {{ ($seller->theme ?? 'dark') === 'auto' ? 'checked' : '' }}
                                >

                                <label
                                    for="theme-auto"
                                    class="theme-label"
                                >

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


                        <br>


                        <button
                            type="submit"
                            class="settings-save"
                        >

                            <i class="fa-solid fa-palette"></i>

                            Save Theme

                        </button>

                    </form>

                </div>

            </section>


            {{-- =================================================
                 SECURITY
            ================================================== --}}

            <section
                class="settings-section"
                data-content="security"
            >

                <div class="settings-card">

                    <div class="settings-card-header">

                        <div class="settings-card-icon">

                            <i class="fa-solid fa-shield-halved"></i>

                        </div>

                        <div>

                            <div class="settings-card-title">
                                Security
                            </div>

                            <div class="settings-card-description">
                                Protect your seller account.
                            </div>

                        </div>

                    </div>


                    <div class="security-item">

                        <div class="security-left">

                            <div class="security-icon">

                                <i class="fa-solid fa-key"></i>

                            </div>

                            <div>

                                <div class="security-title">
                                    Password
                                </div>

                                <div class="security-text">
                                    Change your seller account password.
                                </div>

                            </div>

                        </div>


                        <a
                            href="{{ url('/forgot-password') }}"
                            class="security-btn"
                        >
                            Change
                        </a>

                    </div>


                    <div class="security-item">

                        <div class="security-left">

                            <div class="security-icon">

                                <i class="fa-solid fa-mobile-screen"></i>

                            </div>

                            <div>

                                <div class="security-title">
                                    Account Verification
                                </div>

                                <div class="security-text">
                                    Keep your seller verification information updated.
                                </div>

                            </div>

                        </div>


                        <a
                            href="{{ route('seller.profile') }}"
                            class="security-btn"
                        >
                            View
                        </a>

                    </div>


                    <div class="security-item">

                        <div class="security-left">

                            <div class="security-icon">

                                <i class="fa-solid fa-user-shield"></i>

                            </div>

                            <div>

                                <div class="security-title">
                                    Seller Profile
                                </div>

                                <div class="security-text">
                                    Review your seller account details.
                                </div>

                            </div>

                        </div>


                        <a
                            href="{{ route('seller.profile') }}"
                            class="security-btn"
                        >
                            Open
                        </a>

                    </div>

                </div>

            </section>


        </div>

    </div>

</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | SETTINGS TABS
        |--------------------------------------------------------------------------
        */

        const buttons =
            document.querySelectorAll(
                '.settings-nav-item'
            );


        const sections =
            document.querySelectorAll(
                '.settings-section'
            );


        buttons.forEach(
            function (button) {

                button.addEventListener(
                    'click',
                    function () {


                        const target =
                            button.getAttribute(
                                'data-section'
                            );


                        buttons.forEach(
                            function (item) {

                                item.classList.remove(
                                    'active'
                                );

                            }
                        );


                        sections.forEach(
                            function (section) {

                                section.classList.remove(
                                    'active'
                                );

                            }
                        );


                        button.classList.add(
                            'active'
                        );


                        const section =
                            document.querySelector(
                                '[data-content="' +
                                target +
                                '"]'
                            );


                        if (section) {

                            section.classList.add(
                                'active'
                            );

                        }

                    }
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | THEME RADIO BUTTONS
        |--------------------------------------------------------------------------
        */

        const themeRadios =
            document.querySelectorAll(
                'input[name="theme"]'
            );


        function getSystemTheme() {

            return window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches
                ? 'dark'
                : 'light';

        }


        /*
        |--------------------------------------------------------------------------
        | APPLY THEME IMMEDIATELY
        |--------------------------------------------------------------------------
        */

        function applyTheme(theme) {


            let finalTheme =
                theme;


            if (
                theme === 'auto' ||
                theme === 'system'
            ) {

                finalTheme =
                    getSystemTheme();

            }


            if (
                finalTheme !== 'dark' &&
                finalTheme !== 'light'
            ) {

                finalTheme =
                    'dark';

            }


            const html =
                document.documentElement;


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


            /*
            |--------------------------------------------------------------
            | SAVE LOCAL THEME
            |--------------------------------------------------------------
            */

            localStorage.setItem(
                'smartbasket_seller_theme',
                theme
            );


            /*
            |--------------------------------------------------------------
            | GLOBAL EVENT
            |--------------------------------------------------------------
            */

            window.dispatchEvent(
                new CustomEvent(
                    'smartbasket-theme-changed',
                    {
                        detail: {
                            theme: theme
                        }
                    }
                )
            );


            /*
            |--------------------------------------------------------------
            | TRANSITION
            |--------------------------------------------------------------
            */

            html.classList.add(
                'theme-transition'
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


        /*
        |--------------------------------------------------------------------------
        | CHANGE EVENT
        |--------------------------------------------------------------------------
        */

        themeRadios.forEach(
            function (radio) {

                radio.addEventListener(
                    'change',
                    function () {

                        if (this.checked) {

                            applyTheme(
                                this.value
                            );

                        }

                    }
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | CURRENT THEME
        |--------------------------------------------------------------------------
        */

        const selectedTheme =
            document.querySelector(
                'input[name="theme"]:checked'
            );


        if (selectedTheme) {

            /*
            |--------------------------------------------------------------
            | Do NOT overwrite localStorage on initial page load
            |--------------------------------------------------------------
            */

            const localTheme =
                localStorage.getItem(
                    'smartbasket_seller_theme'
                );


            if (localTheme) {

                const matchingRadio =
                    document.querySelector(
                        'input[name="theme"][value="' +
                        localTheme +
                        '"]'
                    );


                if (matchingRadio) {

                    matchingRadio.checked =
                        true;

                    applyTheme(
                        localTheme
                    );

                } else {

                    applyTheme(
                        selectedTheme.value
                    );

                }

            } else {

                applyTheme(
                    selectedTheme.value
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | SYSTEM THEME CHANGE
        |--------------------------------------------------------------------------
        */

        const mediaQuery =
            window.matchMedia(
                '(prefers-color-scheme: dark)'
            );


        function handleSystemThemeChange() {

            const current =
                localStorage.getItem(
                    'smartbasket_seller_theme'
                );


            if (
                current === 'auto' ||
                current === 'system'
            ) {

                applyTheme(
                    current
                );

            }

        }


        if (
            mediaQuery.addEventListener
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


        /*
        |--------------------------------------------------------------------------
        | THEME FORM SUBMIT
        |--------------------------------------------------------------------------
        */

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

                        localStorage.setItem(
                            'smartbasket_seller_theme',
                            checked.value
                        );

                    }

                }
            );

        }

    }
);

</script>

@endsection