{{-- =========================================================
SMART BASKET
SELLER GLOBAL TASKBAR


THIS IS THE ONLY SELLER TASKBAR.

FILE:
resources/views/seller/partials/topbar.blade.php


========================================================= --}}

@php



$currentRoute = Route::currentRouteName();

$sellerNavItems = [

    [
        'route' => 'seller.dashboard',
        'label' => 'Dashboard',
        'icon' => 'fa-solid fa-house',
        'match' => [
            'seller.dashboard',
        ],
    ],

    [
        'route' => 'seller.products.index',
        'label' => 'Products',
        'icon' => 'fa-solid fa-box-open',
        'match' => [
            'seller.products.index',
            'seller.products',
            'seller.product.add',
            'seller.product.edit',
        ],
    ],

    [
        'route' => 'seller.orders.index',
        'label' => 'Orders',
        'icon' => 'fa-solid fa-cart-shopping',
        'match' => [
            'seller.orders.index',
            'seller.orders.show',
        ],
    ],

    [
        'route' => 'seller.payments.index',
        'label' => 'Payments',
        'icon' => 'fa-solid fa-wallet',
        'match' => [
            'seller.payments.index',
            'seller.payments.show',
            'seller.payments.receipt',
            'seller.payments.premium-receipt',
        ],
    ],

    [
        'route' => 'seller.profile',
        'label' => 'Profile',
        'icon' => 'fa-solid fa-user',
        'match' => [
            'seller.profile',
        ],
    ],

    [
        'route' => 'seller.settings',
        'label' => 'Settings',
        'icon' => 'fa-solid fa-gear',
        'match' => [
            'seller.settings',
        ],
    ],

];


$threeDotItems = [

    [
        'route' => 'seller.product.add',
        'label' => 'Add Product',
        'icon' => 'fa-solid fa-circle-plus',
    ],

    [
        'route' => 'seller.settings',
        'label' => 'Seller Settings',
        'icon' => 'fa-solid fa-sliders',
    ],

    [
        'route' => 'seller.profile',
        'label' => 'My Profile',
        'icon' => 'fa-solid fa-id-card',
    ],

];


@endphp

<header
    class="seller-global-topbar"
    data-seller-global-topbar
>








<div class="seller-topbar-inner">

    {{-- =====================================================
         BRAND
    ====================================================== --}}

    <a
        href="{{ route('seller.dashboard') }}"
        class="seller-brand"
        aria-label="Smart Basket Seller Dashboard"
    >

        <span
            class="seller-brand-icon"
            aria-hidden="true"
        >

            <i class="fa-solid fa-basket-shopping"></i>

        </span>

        <span class="seller-brand-text">

            <strong>
                SMART BASKET
            </strong>

            <span>
                Seller Panel
            </span>

        </span>

    </a>


    {{-- =====================================================
         MAIN NAVIGATION
    ====================================================== --}}

    <nav
        class="seller-main-nav"
        aria-label="Seller Navigation"
    >

        @foreach($sellerNavItems as $item)

            @php

                $isActive =
                    in_array(
                        $currentRoute,
                        $item['match'],
                        true
                    );

            @endphp

            <a
                href="{{ route($item['route']) }}"
                class="seller-nav-link {{ $isActive ? 'active' : '' }}"
                @if($isActive)
                    aria-current="page"
                @endif
            >

                <span
                    class="seller-nav-icon"
                    aria-hidden="true"
                >

                    <i class="{{ $item['icon'] }}"></i>

                </span>

                <span class="seller-nav-text">
                    {{ $item['label'] }}
                </span>

            </a>

        @endforeach

    </nav>


    {{-- =====================================================
         RIGHT ACTIONS
    ====================================================== --}}

    <div class="seller-topbar-actions">

        <a
            href="{{ route('seller.product.add') }}"
            class="seller-quick-add"
            title="Add Product"
            aria-label="Add Product"
        >

            <i
                class="fa-solid fa-circle-plus"
                aria-hidden="true"
            ></i>

            <span>
                Add Product
            </span>

        </a>


        {{-- =================================================
             MORE BUTTON
        ================================================== --}}

        <div class="seller-more-wrapper">

            <button
                type="button"
                class="seller-more-button"
                data-seller-more-button
                aria-label="More Seller Options"
                aria-expanded="false"
                aria-haspopup="true"
            >

                <i
                    class="fa-solid fa-ellipsis-vertical"
                    aria-hidden="true"
                ></i>

            </button>


            {{-- =================================================
                 MORE MENU
            ================================================== --}}

            <div
                class="seller-more-menu"
                data-seller-more-menu
                role="menu"
                aria-hidden="true"
            >

                <div class="seller-more-header">

                    <div>

                        <strong>
                            Seller Menu
                        </strong>

                        <span>
                            Quick navigation
                        </span>

                    </div>

                    <i
                        class="fa-solid fa-grip"
                        aria-hidden="true"
                    ></i>

                </div>


                @foreach($threeDotItems as $item)

                    <a
                        href="{{ route($item['route']) }}"
                        class="seller-more-item"
                        role="menuitem"
                    >

                        <span
                            class="seller-more-icon"
                            aria-hidden="true"
                        >

                            <i class="{{ $item['icon'] }}"></i>

                        </span>

                        <span class="seller-more-label">
                            {{ $item['label'] }}
                        </span>

                        <i
                            class="fa-solid fa-chevron-right seller-more-arrow"
                            aria-hidden="true"
                        ></i>

                    </a>

                @endforeach


                <div class="seller-more-divider"></div>


                <form
                    action="{{ route('seller.logout') }}"
                    method="POST"
                    class="seller-logout-form"
                >

                    @csrf

                    <button
                        type="submit"
                        class="seller-more-item seller-logout-item"
                        role="menuitem"
                    >

                        <span
                            class="seller-more-icon"
                            aria-hidden="true"
                        >

                            <i class="fa-solid fa-right-from-bracket"></i>

                        </span>

                        <span class="seller-more-label">
                            Logout
                        </span>

                        <i
                            class="fa-solid fa-chevron-right seller-more-arrow"
                            aria-hidden="true"
                        ></i>

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


</header>

<style>

/* =========================================================
   SELLER GLOBAL TASKBAR
   SAME DESIGN ON EVERY SELLER PAGE
========================================================= */

.seller-global-topbar,
.seller-global-topbar * {

    box-sizing:
        border-box;

}


/* =========================================================
   TEXT FONT
========================================================= */

.seller-global-topbar,
.seller-global-topbar a,
.seller-global-topbar button,
.seller-global-topbar span,
.seller-global-topbar strong {

    font-family:
        'Poppins',
        sans-serif !important;

}


/* =========================================================
   FONT AWESOME — VERY IMPORTANT
========================================================= */

.seller-global-topbar i.fa-solid,
.seller-global-topbar i.fas {

    font-family:
        "Font Awesome 6 Free" !important;

    font-weight:
        900 !important;

    font-style:
        normal !important;

    line-height:
        1;

    speak:
        never;

    text-transform:
        none;

    -webkit-font-smoothing:
        antialiased;

}


.seller-global-topbar i.fa-regular,
.seller-global-topbar i.far {

    font-family:
        "Font Awesome 6 Free" !important;

    font-weight:
        400 !important;

}


.seller-global-topbar i.fa-brands,
.seller-global-topbar i.fab {

    font-family:
        "Font Awesome 6 Brands" !important;

    font-weight:
        400 !important;

}


/* =========================================================
   TOPBAR
========================================================= */

.seller-global-topbar {

    position:
        sticky;

    top:
        0;

    left:
        0;

    z-index:
        99999;

    width:
        100%;

    height:
        76px;

    min-height:
        76px;

    margin:
        0;

    padding:
        0;

    background:
        rgba(255,255,255,.97);

    border-bottom:
        1px solid rgba(15,23,42,.08);

    box-shadow:
        0 8px 30px rgba(15,23,42,.07);

    backdrop-filter:
        blur(20px);

    -webkit-backdrop-filter:
        blur(20px);

    color:
        #0f172a;

}


/* =========================================================
   INNER
========================================================= */

.seller-topbar-inner {

    width:
        100%;

    height:
        76px;

    min-height:
        76px;

    display:
        flex;

    align-items:
        center;

    gap:
        18px;

    margin:
        0;

    padding:
        10px 22px;

    overflow:
        visible;

}


/* =========================================================
   BRAND
========================================================= */

.seller-brand {

    flex:
        0 0 auto;

    display:
        flex;

    align-items:
        center;

    gap:
        11px;

    min-width:
        190px;

    height:
        56px;

    margin:
        0;

    padding:
        0;

    color:
        #0f172a !important;

    text-decoration:
        none !important;

    background:
        transparent !important;

    border:
        0 !important;

}


/* =========================================================
   BRAND ICON
========================================================= */

.seller-brand-icon {

    width:
        44px;

    height:
        44px;

    min-width:
        44px;

    min-height:
        44px;

    flex:
        0 0 44px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    border-radius:
        13px;

    background:
        linear-gradient(
            135deg,
            #111827,
            #334155
        );

    color:
        #ffffff;

    box-shadow:
        0 8px 20px rgba(15,23,42,.16);

}


.seller-brand-icon i {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    color:
        #ffffff !important;

    font-family:
        "Font Awesome 6 Free" !important;

    font-size:
        18px;

    font-weight:
        900 !important;

    line-height:
        1;

}


/* =========================================================
   BRAND TEXT
========================================================= */

.seller-brand-text {

    display:
        flex;

    flex-direction:
        column;

    justify-content:
        center;

    min-width:
        0;

}


.seller-brand-text strong {

    display:
        block;

    margin:
        0;

    color:
        #0f172a;

    font-size:
        15px;

    font-weight:
        800;

    line-height:
        1.15;

    letter-spacing:
        .35px;

}


.seller-brand-text > span {

    display:
        block;

    margin:
        3px 0 0;

    color:
        #64748b;

    font-size:
        10px;

    font-weight:
        600;

    line-height:
        1.15;

    letter-spacing:
        .7px;

    text-transform:
        uppercase;

}


/* =========================================================
   NAVIGATION
========================================================= */

.seller-main-nav {

    flex:
        1 1 auto;

    min-width:
        0;

    height:
        56px;

    display:
        flex;

    align-items:
        center;

    gap:
        5px;

    margin:
        0;

    padding:
        0;

    overflow-x:
        auto;

    overflow-y:
        hidden;

    scrollbar-width:
        none;

}


.seller-main-nav::-webkit-scrollbar {

    display:
        none;

}


/* =========================================================
   NAV LINK
========================================================= */

.seller-nav-link {

    position:
        relative;

    flex:
        0 0 auto;

    height:
        44px;

    min-height:
        44px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    gap:
        8px;

    margin:
        0;

    padding:
        0 13px;

    border:
        0 !important;

    border-radius:
        12px;

    background:
        transparent !important;

    color:
        #64748b !important;

    text-decoration:
        none !important;

    font-size:
        13px;

    font-weight:
        600;

    line-height:
        1;

    white-space:
        nowrap;

    transition:
        background .18s ease,
        color .18s ease,
        transform .18s ease;

}


/* =========================================================
   NAV ICON
========================================================= */

.seller-nav-icon {

    width:
        18px;

    height:
        18px;

    flex:
        0 0 18px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

}


.seller-nav-icon i {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    width:
        18px;

    height:
        18px;

    color:
        inherit !important;

    font-family:
        "Font Awesome 6 Free" !important;

    font-size:
        14px;

    font-weight:
        900 !important;

    line-height:
        1;

}


/* =========================================================
   NAV TEXT
========================================================= */

.seller-nav-text {

    display:
        inline-block;

    color:
        inherit !important;

    font-family:
        'Poppins',
        sans-serif !important;

    font-size:
        13px;

    font-weight:
        600;

    line-height:
        1;

}


/* =========================================================
   HOVER
========================================================= */

.seller-nav-link:hover {

    color:
        #0f172a !important;

    background:
        #f1f5f9 !important;

    transform:
        translateY(-1px);

}


/* =========================================================
   ACTIVE
========================================================= */

.seller-nav-link.active {

    color:
        #0f172a !important;

    background:
        #e2e8f0 !important;

    box-shadow:
        inset 0 0 0 1px rgba(15,23,42,.05);

}


.seller-nav-link.active::after {

    content:
        "";

    position:
        absolute;

    left:
        18px;

    right:
        18px;

    bottom:
        2px;

    height:
        3px;

    border-radius:
        50px;

    background:
        #0f172a;

}


/* =========================================================
   RIGHT ACTIONS
========================================================= */

.seller-topbar-actions {

    flex:
        0 0 auto;

    height:
        56px;

    display:
        flex;

    align-items:
        center;

    gap:
        8px;

}


/* =========================================================
   ADD PRODUCT
========================================================= */

.seller-quick-add {

    height:
        43px;

    min-height:
        43px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    gap:
        7px;

    padding:
        0 14px;

    border:
        0 !important;

    border-radius:
        12px;

    background:
        linear-gradient(
            135deg,
            #0f172a,
            #334155
        ) !important;

    color:
        #ffffff !important;

    text-decoration:
        none !important;

    font-size:
        12px;

    font-weight:
        700;

    line-height:
        1;

    white-space:
        nowrap;

    box-shadow:
        0 8px 18px rgba(15,23,42,.15);

    transition:
        transform .18s ease,
        box-shadow .18s ease;

}


.seller-quick-add i {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    color:
        #ffffff !important;

    font-family:
        "Font Awesome 6 Free" !important;

    font-size:
        12px;

    font-weight:
        900 !important;

    line-height:
        1;

}


.seller-quick-add span {

    color:
        #ffffff !important;

    font-family:
        'Poppins',
        sans-serif !important;

    font-size:
        12px;

    font-weight:
        700;

}


.seller-quick-add:hover {

    color:
        #ffffff !important;

    transform:
        translateY(-1px);

    box-shadow:
        0 12px 25px rgba(15,23,42,.20);

}


/* =========================================================
   MORE WRAPPER
========================================================= */

.seller-more-wrapper {

    position:
        relative;

    flex:
        0 0 auto;

}


/* =========================================================
   MORE BUTTON
========================================================= */

.seller-more-button {

    width:
        43px;

    height:
        43px;

    min-width:
        43px;

    min-height:
        43px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    margin:
        0;

    padding:
        0;

    border:
        1px solid rgba(15,23,42,.09) !important;

    border-radius:
        12px;

    background:
        #ffffff !important;

    color:
        #334155 !important;

    cursor:
        pointer;

    appearance:
        none;

    -webkit-appearance:
        none;

    outline:
        none;

    transition:
        background .18s ease,
        transform .18s ease,
        box-shadow .18s ease;

}


.seller-more-button i {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    width:
        18px;

    height:
        18px;

    color:
        inherit !important;

    font-family:
        "Font Awesome 6 Free" !important;

    font-size:
        17px;

    font-weight:
        900 !important;

    line-height:
        1;

}


.seller-more-button:hover,
.seller-more-button.open {

    background:
        #f1f5f9 !important;

    color:
        #0f172a !important;

    transform:
        translateY(-1px);

    box-shadow:
        0 8px 20px rgba(15,23,42,.10);

}


/* =========================================================
   MORE MENU
========================================================= */

.seller-more-menu {

    position:
        absolute;

    top:
        calc(100% + 10px);

    right:
        0;

    width:
        285px;

    margin:
        0;

    padding:
        10px;

    background:
        rgba(255,255,255,.99) !important;

    border:
        1px solid rgba(15,23,42,.08) !important;

    border-radius:
        18px;

    box-shadow:
        0 22px 55px rgba(15,23,42,.16);

    backdrop-filter:
        blur(20px);

    -webkit-backdrop-filter:
        blur(20px);

    opacity:
        0;

    visibility:
        hidden;

    pointer-events:
        none;

    transform:
        translateY(-8px)
        scale(.98);

    transform-origin:
        top right;

    transition:
        opacity .18s ease,
        visibility .18s ease,
        transform .18s ease;

}


.seller-more-menu.show {

    opacity:
        1;

    visibility:
        visible;

    pointer-events:
        auto;

    transform:
        translateY(0)
        scale(1);

}


/* =========================================================
   MENU HEADER
========================================================= */

.seller-more-header {

    width:
        100%;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    padding:
        10px 10px 12px;

}


.seller-more-header > div {

    display:
        flex;

    flex-direction:
        column;

}


.seller-more-header strong {

    display:
        block;

    color:
        #0f172a !important;

    font-family:
        'Poppins',
        sans-serif !important;

    font-size:
        14px;

    font-weight:
        800;

}


.seller-more-header span {

    display:
        block;

    margin-top:
        3px;

    color:
        #64748b !important;

    font-family:
        'Poppins',
        sans-serif !important;

    font-size:
        10px;

    font-weight:
        500;

}


.seller-more-header > i {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    width:
        20px;

    height:
        20px;

    color:
        #64748b !important;

    font-family:
        "Font Awesome 6 Free" !important;

    font-size:
        15px;

    font-weight:
        900 !important;

}


/* =========================================================
   MENU ITEMS
========================================================= */

.seller-more-item {

    width:
        100%;

    min-height:
        47px;

    display:
        flex;

    align-items:
        center;

    gap:
        11px;

    margin:
        0;

    padding:
        7px 9px;

    border:
        0 !important;

    border-radius:
        12px;

    background:
        transparent !important;

    color:
        #334155 !important;

    text-decoration:
        none !important;

    cursor:
        pointer;

    font-family:
        'Poppins',
        sans-serif !important;

    font-size:
        13px;

    font-weight:
        600;

    line-height:
        1;

    text-align:
        left;

    appearance:
        none;

    -webkit-appearance:
        none;

    box-shadow:
        none !important;

    outline:
        none;

}


.seller-more-item:hover {

    background:
        #f1f5f9 !important;

    color:
        #0f172a !important;

}


/* =========================================================
   MENU ICON BOX
========================================================= */

.seller-more-icon {

    width:
        34px;

    height:
        34px;

    min-width:
        34px;

    min-height:
        34px;

    flex:
        0 0 34px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    border-radius:
        10px;

    background:
        #f1f5f9 !important;

    color:
        #475569 !important;

}


.seller-more-icon i {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    width:
        16px;

    height:
        16px;

    color:
        inherit !important;

    font-family:
        "Font Awesome 6 Free" !important;

    font-size:
        14px;

    font-weight:
        900 !important;

}


/* =========================================================
   MENU LABEL
========================================================= */

.seller-more-label {

    flex:
        1 1 auto;

    min-width:
        0;

    color:
        inherit !important;

    font-family:
        'Poppins',
        sans-serif !important;

    font-size:
        13px;

    font-weight:
        600;

    white-space:
        nowrap;

    overflow:
        hidden;

    text-overflow:
        ellipsis;

}


/* =========================================================
   ARROW
========================================================= */

.seller-more-arrow {

    flex:
        0 0 auto;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    width:
        12px;

    height:
        12px;

    margin-left:
        auto;

    color:
        #94a3b8 !important;

    font-family:
        "Font Awesome 6 Free" !important;

    font-size:
        10px;

    font-weight:
        900 !important;

}


/* =========================================================
   DIVIDER
========================================================= */

.seller-more-divider {

    height:
        1px;

    margin:
        8px 5px;

    background:
        #e2e8f0 !important;

}


/* =========================================================
   LOGOUT
========================================================= */

.seller-logout-form {

    display:
        block;

    width:
        100%;

    margin:
        0;

    padding:
        0;

}


.seller-logout-item {

    color:
        #b91c1c !important;

}


.seller-logout-item
.seller-more-icon {

    color:
        #b91c1c !important;

    background:
        #fef2f2 !important;

}


.seller-logout-item:hover {

    color:
        #991b1b !important;

    background:
        #fef2f2 !important;

}


/* =========================================================
   RESPONSIVE — 1250
========================================================= */

@media (max-width: 1250px) {

    .seller-topbar-inner {

        gap:
            10px;

        padding-left:
            14px;

        padding-right:
            14px;

    }

    .seller-brand {

        min-width:
            160px;

    }

    .seller-nav-link {

        padding-left:
            10px;

        padding-right:
            10px;

    }

}


/* =========================================================
   RESPONSIVE — 1050
========================================================= */

@media (max-width: 1050px) {

    .seller-brand-text {

        display:
            none;

    }

    .seller-brand {

        min-width:
            auto;

    }

    .seller-quick-add span {

        display:
            none;

    }

    .seller-quick-add {

        width:
            43px;

        min-width:
            43px;

        padding:
            0;

    }

}


/* =========================================================
   RESPONSIVE — 760
========================================================= */

@media (max-width: 760px) {

    .seller-global-topbar {

        height:
            68px;

        min-height:
            68px;

    }

    .seller-topbar-inner {

        height:
            68px;

        min-height:
            68px;

        gap:
            8px;

        padding:
            8px 10px;

    }

    .seller-brand {

        height:
            52px;

    }

    .seller-brand-icon {

        width:
            40px;

        height:
            40px;

        min-width:
            40px;

        min-height:
            40px;

        flex-basis:
            40px;

        border-radius:
            11px;

    }

    .seller-brand-icon i {

        font-size:
            17px;

    }

    .seller-main-nav {

        height:
            52px;

        gap:
            3px;

    }

    .seller-nav-link {

        height:
            42px;

        min-height:
            42px;

        padding:
            0 10px;

        border-radius:
            10px;

    }

    .seller-nav-icon {

        width:
            17px;

        height:
            17px;

        flex-basis:
            17px;

    }

    .seller-nav-icon i {

        width:
            17px;

        height:
            17px;

        font-size:
            13px;

    }

    .seller-nav-text {

        font-size:
            11px;

    }

    .seller-more-button,
    .seller-quick-add {

        width:
            40px;

        height:
            40px;

        min-width:
            40px;

        min-height:
            40px;

    }

    .seller-more-menu {

        position:
            fixed;

        top:
            74px;

        right:
            10px;

        width:
            min(
                300px,
                calc(100vw - 20px)
            );

    }

}


/* =========================================================
   RESPONSIVE — 500
========================================================= */

@media (max-width: 500px) {

    .seller-topbar-inner {

        gap:
            6px;

        padding-left:
            8px;

        padding-right:
            8px;

    }

    .seller-brand-icon {

        width:
            38px;

        height:
            38px;

        min-width:
            38px;

        min-height:
            38px;

        flex-basis:
            38px;

    }

    .seller-main-nav {

        gap:
            2px;

    }

    .seller-nav-link {

        padding:
            0 8px;

    }

    .seller-nav-link.active::after {

        left:
            12px;

        right:
            12px;

    }

}


/* =========================================================
   REDUCE MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .seller-global-topbar *,
    .seller-global-topbar *::before,
    .seller-global-topbar *::after {

        transition:
            none !important;

        animation:
            none !important;

    }

}

</style>

<script>

(function () {

    'use strict';


    /* =====================================================
       INITIALIZE ONLY ONCE
    ===================================================== */

    const topbars =
        document.querySelectorAll(
            '[data-seller-global-topbar]'
        );


    if (!topbars.length) {
        return;
    }


    topbars.forEach(function (topbar) {

        if (
            topbar.dataset.initialized === 'true'
        ) {

            return;

        }

        topbar.dataset.initialized =
            'true';


        const button =
            topbar.querySelector(
                '[data-seller-more-button]'
            );

        const menu =
            topbar.querySelector(
                '[data-seller-more-menu]'
            );


        if (
            !button ||
            !menu
        ) {

            return;

        }


        function openMenu() {

            menu.classList.add(
                'show'
            );

            button.classList.add(
                'open'
            );

            button.setAttribute(
                'aria-expanded',
                'true'
            );

            menu.setAttribute(
                'aria-hidden',
                'false'
            );

        }


        function closeMenu() {

            menu.classList.remove(
                'show'
            );

            button.classList.remove(
                'open'
            );

            button.setAttribute(
                'aria-expanded',
                'false'
            );

            menu.setAttribute(
                'aria-hidden',
                'true'
            );

        }


        button.addEventListener(
            'click',
            function (event) {

                event.preventDefault();

                event.stopPropagation();

                if (
                    menu.classList.contains(
                        'show'
                    )
                ) {

                    closeMenu();

                } else {

                    openMenu();

                }

            }
        );


        menu.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

            }
        );


        document.addEventListener(
            'click',
            function (event) {

                if (
                    !topbar.contains(
                        event.target
                    )
                ) {

                    closeMenu();

                }

            }
        );


        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Escape' &&
                    menu.classList.contains('show')
                ) {

                    closeMenu();

                    button.focus();

                }

            }
        );


        menu.querySelectorAll(
            'a'
        ).forEach(
            function (link) {

                link.addEventListener(
                    'click',
                    function () {

                        closeMenu();

                    }
                );

            }
        );


        const logoutForm =
            menu.querySelector(
                '.seller-logout-form'
            );


        if (logoutForm) {

            logoutForm.addEventListener(
                'submit',
                function () {

                    closeMenu();

                }
            );

        }

    });

})();

</script>
