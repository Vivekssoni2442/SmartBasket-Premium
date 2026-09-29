{{-- ============================================================
     SMART BASKET — COMMON CUSTOMER TOP TASKBAR
     ============================================================ --}}

@php
    $currentRoute = request()->route()?->getName();

    $user = auth()->user();

    $userName = $user?->name ?? 'Customer';

    $initial =
        strtoupper(
            substr(
                trim($userName),
                0,
                1
            )
        );
@endphp


<style>

    /* =========================================================
       TOP TASKBAR
    ========================================================= */

    .sb-top-taskbar {
        position: fixed;

        top: 0;
        left: 0;
        right: 0;

        z-index: 99990;

        height: 72px;

        display: flex;
        align-items: center;

        padding: 0 24px;

        background:
            color-mix(
                in srgb,
                var(--surface, #091322) 92%,
                transparent
            );

        border-bottom:
            1px solid
            color-mix(
                in srgb,
                var(--border, #21364f) 80%,
                transparent
            );

        box-shadow:
            0 12px 40px rgba(0,0,0,.18);

        backdrop-filter:
            blur(22px);

        -webkit-backdrop-filter:
            blur(22px);
    }


    /* =========================================================
       INNER
    ========================================================= */

    .sb-top-taskbar-inner {

        width: 100%;
        max-width: 1600px;

        margin: auto;

        display: flex;
        align-items: center;

        gap: 10px;
    }


    /* =========================================================
       LOGO
    ========================================================= */

    .sb-top-logo {

        display: flex;
        align-items: center;

        gap: 10px;

        min-width: 190px;

        color:
            var(--text, #fff);

        text-decoration: none !important;
    }


    .sb-top-logo-icon {

        width: 43px;
        height: 43px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                #00c6ff,
                #287bff,
                #8b35ff,
                #ff20c8
            );

        box-shadow:
            0 8px 25px
            rgba(80,100,255,.30);

        font-size: 19px;
    }


    .sb-top-logo-text strong {

        display: block;

        font-size: 15px;

        font-weight: 950;

        line-height: 1.1;
    }


    .sb-top-logo-text small {

        display: block;

        margin-top: 3px;

        color:
            var(--muted, #9aacbf);

        font-size: 8px;

        font-weight: 700;

        letter-spacing: .08em;
    }


    /* =========================================================
       NAVIGATION
    ========================================================= */

    .sb-top-nav {

        display: flex;
        align-items: center;

        gap: 5px;

        flex: 1;

        justify-content: center;
    }


    .sb-top-nav-btn {

        position: relative;

        height: 45px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 7px;

        padding: 0 13px;

        border-radius: 12px;

        color:
            var(--muted, #9aacbf);

        background: transparent;

        border:
            1px solid transparent;

        font-size: 11px;

        font-weight: 850;

        text-decoration: none !important;

        cursor: pointer;

        transition:
            .22s ease;
    }


    .sb-top-nav-btn i {

        font-size: 14px;
    }


    .sb-top-nav-btn:hover {

        color:
            var(--text, #fff);

        background:
            rgba(255,255,255,.07);

        border-color:
            rgba(255,255,255,.08);

        transform:
            translateY(-1px);
    }


    .sb-top-nav-btn.active {

        color: #fff;

        background:
            linear-gradient(
                135deg,
                rgba(37,99,235,.25),
                rgba(124,58,237,.22)
            );

        border-color:
            rgba(110,130,255,.25);

        box-shadow:
            inset 0 1px 0
            rgba(255,255,255,.08);
    }


    /* =========================================================
       SMART AI
    ========================================================= */

    .sb-top-ai {

        color: #fff !important;

        background:
            linear-gradient(
                135deg,
                rgba(0,198,255,.15),
                rgba(124,58,237,.20),
                rgba(255,32,200,.12)
            ) !important;

        border-color:
            rgba(120,150,255,.28) !important;

        box-shadow:
            0 7px 24px
            rgba(80,90,255,.15);
    }


    .sb-top-ai:hover {

        transform:
            translateY(-2px)
            scale(1.02);

        box-shadow:
            0 10px 30px
            rgba(80,90,255,.25);
    }


    .sb-ai-icon {

        width: 24px;
        height: 24px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background:
            linear-gradient(
                135deg,
                #00c6ff,
                #7c3aed,
                #ff20c8
            );

        box-shadow:
            0 0 15px
            rgba(80,150,255,.35);

        font-size: 11px;
    }


    /* =========================================================
       RIGHT SIDE
    ========================================================= */

    .sb-top-right {

        display: flex;
        align-items: center;

        gap: 7px;

        min-width: 220px;

        justify-content: flex-end;
    }


    /* =========================================================
       CART
    ========================================================= */

    .sb-top-cart {

        position: relative;
    }


    .sb-top-cart-badge {

        position: absolute;

        top: 2px;
        right: 1px;

        min-width: 16px;
        height: 16px;

        padding: 0 4px;

        display: none;

        align-items: center;
        justify-content: center;

        border-radius: 999px;

        background:
            #ff405d;

        color: #fff;

        border:
            2px solid
            var(--surface, #091322);

        font-size: 8px;

        font-weight: 950;
    }


    /* =========================================================
       PROFILE
    ========================================================= */

    .sb-profile-btn {

        height: 45px;

        display: flex;
        align-items: center;

        gap: 8px;

        padding: 4px 10px 4px 5px;

        border-radius: 13px;

        border:
            1px solid
            rgba(255,255,255,.08);

        background:
            rgba(255,255,255,.045);

        color:
            var(--text, #fff);

        text-decoration: none !important;

        transition:
            .22s ease;
    }


    .sb-profile-btn:hover {

        background:
            rgba(255,255,255,.09);

        border-color:
            rgba(255,255,255,.14);

        color:
            var(--text, #fff);

        transform:
            translateY(-1px);
    }


    .sb-profile-avatar {

        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                #287bff,
                #8b35ff
            );

        font-size: 12px;

        font-weight: 950;
    }


    .sb-profile-info {

        max-width: 90px;

        overflow: hidden;
    }


    .sb-profile-info strong {

        display: block;

        overflow: hidden;

        text-overflow: ellipsis;

        white-space: nowrap;

        font-size: 10px;
    }


    .sb-profile-info small {

        display: block;

        margin-top: 2px;

        color:
            var(--muted, #9aacbf);

        font-size: 7px;
    }


    /* =========================================================
       THREE DOTS
    ========================================================= */

    .sb-top-more {

        width: 45px;
        height: 45px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        border:
            1px solid transparent;

        background: transparent;

        color:
            var(--muted, #9aacbf);

        cursor: pointer;

        transition:
            .22s ease;
    }


    .sb-top-more:hover,
    .sb-top-more.open {

        color:
            var(--text, #fff);

        background:
            rgba(255,255,255,.08);

        border-color:
            rgba(255,255,255,.08);
    }


    .sb-dots {

        display: flex;

        gap: 3px;
    }


    .sb-dots span {

        width: 4px;
        height: 4px;

        border-radius: 50%;

        background:
            currentColor;
    }


    /* =========================================================
       DROPDOWN
    ========================================================= */

    .sb-top-menu {

        position: fixed;

        top: 82px;
        right: 24px;

        width: 245px;

        padding: 8px;

        border-radius: 17px;

        background:
            color-mix(
                in srgb,
                var(--surface, #091322) 97%,
                transparent
            );

        border:
            1px solid
            var(--border, #21364f);

        box-shadow:
            0 25px 70px
            rgba(0,0,0,.35);

        backdrop-filter:
            blur(25px);

        -webkit-backdrop-filter:
            blur(25px);

        opacity: 0;

        visibility: hidden;

        pointer-events: none;

        transform:
            translateY(-8px)
            scale(.97);

        transition:
            .18s ease;
    }


    .sb-top-menu.open {

        opacity: 1;

        visibility: visible;

        pointer-events: auto;

        transform:
            translateY(0)
            scale(1);
    }


    .sb-top-menu-title {

        padding:
            9px 11px 7px;

        color:
            var(--muted, #9aacbf);

        font-size: 8px;

        font-weight: 950;

        letter-spacing: .13em;

        text-transform: uppercase;
    }


    .sb-top-menu-item {

        width: 100%;

        min-height: 43px;

        display: flex;
        align-items: center;

        gap: 10px;

        padding:
            7px 10px;

        border: 0;

        border-radius: 11px;

        background: transparent;

        color:
            var(--text, #fff);

        text-decoration: none !important;

        font-size: 11px;

        font-weight: 750;

        cursor: pointer;

        transition:
            .18s ease;
    }


    .sb-top-menu-item:hover {

        background:
            rgba(255,255,255,.08);

        color:
            var(--text, #fff);
    }


    .sb-top-menu-icon {

        width: 30px;
        height: 30px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background:
            rgba(255,255,255,.06);

        font-size: 12px;
    }


    /* =========================================================
       ROBOT
    ========================================================= */

    .sb-smart-ai-robot-host {

        position: relative;
    }


    /*
     * Existing Smart AI Robot launcher hidden.
     * Taskbar button triggers it.
     */

    .sb-smart-ai-robot-host
    > [data-smart-ai]
    > .smart-ai__launch {

        opacity: 0 !important;

        visibility: hidden !important;

        pointer-events: none !important;

        position: fixed !important;

        width: 1px !important;
        height: 1px !important;

        min-width: 1px !important;
        min-height: 1px !important;

        overflow: hidden !important;

        clip:
            rect(0,0,0,0) !important;
    }


    .sb-smart-ai-robot-host
    [data-smart-ai-panel] {

        z-index:
            999999 !important;
    }


    /* =========================================================
       PAGE OFFSET
    ========================================================= */

    body {

        padding-top:
            72px !important;
    }


    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 950px) {

        .sb-top-logo {

            min-width: auto;
        }

        .sb-top-logo-text {

            display: none;
        }

        .sb-top-right {

            min-width: auto;
        }

        .sb-profile-info {

            display: none;
        }

    }


    @media (max-width: 720px) {

        .sb-top-taskbar {

            height: 64px;

            padding:
                0 9px;
        }

        body {

            padding-top:
                64px !important;
        }

        .sb-top-taskbar-inner {

            gap: 4px;
        }

        .sb-top-nav {

            gap: 2px;
        }

        .sb-top-nav-btn {

            width: 42px;
            height: 44px;

            padding: 0;

            border-radius: 11px;
        }

        .sb-top-nav-btn span {

            display: none;
        }

        .sb-top-nav-btn i {

            font-size: 15px;
        }

        .sb-top-logo-icon {

            width: 40px;
            height: 40px;
        }

        .sb-top-right {

            gap: 3px;
        }

        .sb-profile-btn {

            width: 42px;
            height: 44px;

            padding: 4px;

            justify-content: center;
        }

        .sb-top-cart {

            display: block;
        }

        .sb-top-more {

            width: 42px;
            height: 44px;
        }

        .sb-top-menu {

            top: 73px;

            right: 9px;

            width:
                min(
                    245px,
                    calc(100vw - 18px)
                );
        }

    }


    @media (max-width: 450px) {

        .sb-top-nav-btn:nth-child(2) {

            display: none;
        }

        .sb-top-ai {

            display: inline-flex !important;
        }

        .sb-top-right {

            margin-left: auto;
        }

    }

</style>


{{-- ============================================================
     TOP TASKBAR
     ============================================================ --}}

<header
    class="sb-top-taskbar"
    id="sbTopTaskbar"
>

    <div class="sb-top-taskbar-inner">


        {{-- ====================================================
             LOGO
        ==================================================== --}}

        <a
            href="{{ route('products.index') }}"
            class="sb-top-logo"
        >

            <span class="sb-top-logo-icon">
                <i class="fa-solid fa-basket-shopping"></i>
            </span>

            <span class="sb-top-logo-text">

                <strong>
                    Smart Basket
                </strong>

                <small>
                    SMART SHOPPING
                </small>

            </span>

        </a>


        {{-- ====================================================
             MAIN NAVIGATION
        ==================================================== --}}

        <nav class="sb-top-nav">


            {{-- HOME --}}

            <a
                href="{{ route('products.index') }}"
                class="sb-top-nav-btn
                    {{ $currentRoute === 'products.index' ? 'active' : '' }}"
            >

                <i class="fa-solid fa-house"></i>

                <span>
                    Home
                </span>

            </a>


            {{-- PRODUCTS --}}

            <a
                href="{{ route('products.index') }}"
                class="sb-top-nav-btn"
            >

                <i class="fa-solid fa-bag-shopping"></i>

                <span>
                    Products
                </span>

            </a>


            {{-- ORDERS --}}

            @if(Route::has('orders.index'))

                <a
                    href="{{ route('orders.index') }}"
                    class="sb-top-nav-btn
                        {{ $currentRoute === 'orders.index' ? 'active' : '' }}"
                >

                    <i class="fa-solid fa-box"></i>

                    <span>
                        Orders
                    </span>

                </a>

            @endif


            {{-- CART --}}

            <a
                href="{{ route('cart.index') }}"
                class="sb-top-nav-btn sb-top-cart
                    {{ $currentRoute === 'cart.index' ? 'active' : '' }}"
            >

                <i class="fa-solid fa-cart-shopping"></i>

                <span>
                    Cart
                </span>

                <span
                    id="sbTopCartBadge"
                    class="sb-top-cart-badge"
                >
                    0
                </span>

            </a>


            {{-- SMART AI --}}

            <button
                type="button"
                id="sbTopSmartAI"
                class="sb-top-nav-btn sb-top-ai"
                title="Open Smart AI"
            >

                <span class="sb-ai-icon">
                    ✦
                </span>

                <span>
                    Smart AI
                </span>

            </button>


        </nav>


        {{-- ====================================================
             RIGHT SIDE
        ==================================================== --}}

        <div class="sb-top-right">


            {{-- PROFILE --}}

            @if(Route::has('profile'))

                <a
                    href="{{ route('profile') }}"
                    class="sb-profile-btn"
                    title="Profile"
                >

                    <span class="sb-profile-avatar">

                        {{ $initial }}

                    </span>


                    <span class="sb-profile-info">

                        <strong>
                            {{ $userName }}
                        </strong>

                        <small>
                            My Profile
                        </small>

                    </span>

                </a>

            @elseif(Route::has('settings'))

                <a
                    href="{{ route('settings') }}"
                    class="sb-profile-btn"
                    title="Settings"
                >

                    <span class="sb-profile-avatar">
                        <i class="fa-solid fa-user"></i>
                    </span>

                    <span class="sb-profile-info">

                        <strong>
                            {{ $userName }}
                        </strong>

                        <small>
                            Account
                        </small>

                    </span>

                </a>

            @endif


            {{-- THREE DOTS --}}

            <button
                type="button"
                id="sbTopMore"
                class="sb-top-more"
                aria-label="More options"
                aria-expanded="false"
            >

                <span class="sb-dots">

                    <span></span>
                    <span></span>
                    <span></span>

                </span>

            </button>

        </div>

    </div>

</header>


{{-- ============================================================
     THREE DOT MENU
     ============================================================ --}}

<div
    id="sbTopMenu"
    class="sb-top-menu"
    aria-hidden="true"
>

    <div class="sb-top-menu-title">
        Smart Basket
    </div>


    {{-- PROFILE --}}

    @if(Route::has('profile'))

        <a
            href="{{ route('profile') }}"
            class="sb-top-menu-item"
        >

            <span class="sb-top-menu-icon">
                <i class="fa-solid fa-user"></i>
            </span>

            Profile

        </a>

    @endif


    {{-- SETTINGS --}}

    @if(Route::has('settings'))

        <a
            href="{{ route('settings') }}"
            class="sb-top-menu-item"
        >

            <span class="sb-top-menu-icon">
                <i class="fa-solid fa-gear"></i>
            </span>

            Settings

        </a>

    @endif


    {{-- ORDERS --}}

    @if(Route::has('orders.index'))

        <a
            href="{{ route('orders.index') }}"
            class="sb-top-menu-item"
        >

            <span class="sb-top-menu-icon">
                <i class="fa-solid fa-box"></i>
            </span>

            My Orders

        </a>

    @endif


    {{-- CART --}}

    <a
        href="{{ route('cart.index') }}"
        class="sb-top-menu-item"
    >

        <span class="sb-top-menu-icon">
            <i class="fa-solid fa-cart-shopping"></i>
        </span>

        My Cart

    </a>


    {{-- PRODUCTS --}}

    <a
        href="{{ route('products.index') }}"
        class="sb-top-menu-item"
    >

        <span class="sb-top-menu-icon">
            <i class="fa-solid fa-bag-shopping"></i>
        </span>

        Products

    </a>

</div>


{{-- ============================================================
     EXISTING SMART AI ROBOT
     ============================================================ --}}

<div
    class="sb-smart-ai-robot-host"
    aria-hidden="false"
>

    <x-smart-ai-robot />

</div>


<script>

(() => {

    'use strict';


    /* =========================================================
       PREVENT DOUBLE LOAD
    ========================================================= */

    if (window.__SB_TOP_TASKBAR_LOADED) {
        return;
    }

    window.__SB_TOP_TASKBAR_LOADED = true;


    /* =========================================================
       ELEMENTS
    ========================================================= */

    const aiButton =
        document.getElementById(
            'sbTopSmartAI'
        );

    const moreButton =
        document.getElementById(
            'sbTopMore'
        );

    const menu =
        document.getElementById(
            'sbTopMenu'
        );

    const cartBadge =
        document.getElementById(
            'sbTopCartBadge'
        );


    /* =========================================================
       SMART AI
    ========================================================= */

    function openSmartAI() {

        const launcher =
            document.querySelector(
                '[data-smart-ai-open]'
            );

        if (!launcher) {

            console.warn(
                'Smart AI Robot launcher not found.'
            );

            return;
        }

        launcher.click();

    }


    if (aiButton) {

        aiButton.addEventListener(
            'click',
            openSmartAI
        );

    }


    /* =========================================================
       THREE DOT MENU
    ========================================================= */

    function openMenu() {

        if (!menu) {
            return;
        }

        menu.classList.add(
            'open'
        );

        moreButton?.classList.add(
            'open'
        );

        moreButton?.setAttribute(
            'aria-expanded',
            'true'
        );

        menu.setAttribute(
            'aria-hidden',
            'false'
        );

    }


    function closeMenu() {

        if (!menu) {
            return;
        }

        menu.classList.remove(
            'open'
        );

        moreButton?.classList.remove(
            'open'
        );

        moreButton?.setAttribute(
            'aria-expanded',
            'false'
        );

        menu.setAttribute(
            'aria-hidden',
            'true'
        );

    }


    function toggleMenu() {

        if (
            menu?.classList.contains(
                'open'
            )
        ) {

            closeMenu();

        } else {

            openMenu();

        }

    }


    moreButton?.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

            toggleMenu();

        }
    );


    /* =========================================================
       OUTSIDE CLICK
    ========================================================= */

    document.addEventListener(
        'click',
        function (event) {

            if (!menu) {
                return;
            }

            if (
                menu.contains(event.target) ||
                moreButton?.contains(event.target)
            ) {
                return;
            }

            closeMenu();

        }
    );


    /* =========================================================
       ESCAPE
    ========================================================= */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape'
            ) {

                closeMenu();

            }

        }
    );


    /* =========================================================
       CART BADGE
    ========================================================= */

    function updateCartBadge(count) {

        if (!cartBadge) {
            return;
        }

        const value =
            Number(count) || 0;

        if (value > 0) {

            cartBadge.textContent =
                value > 99
                    ? '99+'
                    : value;

            cartBadge.style.display =
                'flex';

        } else {

            cartBadge.style.display =
                'none';

        }

    }


    /* =========================================================
       CART EVENTS
    ========================================================= */

    window.addEventListener(
        'smartbasket:cart-updated',
        function (event) {

            updateCartBadge(
                event.detail?.count ?? 0
            );

        }
    );


    window.addEventListener(
        'cart:updated',
        function (event) {

            updateCartBadge(
                event.detail?.count ?? 0
            );

        }
    );


    /* =========================================================
       GLOBAL API
    ========================================================= */

    window.SmartBasketTaskbar = {

        openAI:
            openSmartAI,

        openMenu:
            openMenu,

        closeMenu:
            closeMenu,

        updateCart:
            updateCartBadge

    };


})();

</script>