{{-- =========================================================
     SMART BASKET - CUSTOMER GLOBAL MENU
     Common 3-dot menu for customer pages
     ========================================================= --}}

<style>
    .sb-customer-menu {
        position: fixed;
        top: 18px;
        right: 20px;
        z-index: 99999;
        font-family: inherit;
    }

    .sb-menu-trigger {
        width: 48px;
        height: 48px;
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 50%;
        background: rgba(15,23,42,.92);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 8px 25px rgba(0,0,0,.35);
        backdrop-filter: blur(15px);
        transition: .25s ease;
    }

    .sb-menu-trigger:hover {
        transform: scale(1.08);
        border-color: #fbbf24;
        color: #fbbf24;
    }

    .sb-menu-trigger i {
        font-size: 20px;
    }

    .sb-customer-dropdown {
        position: absolute;
        top: 58px;
        right: 0;
        width: 245px;
        padding: 10px;
        border-radius: 18px;
        background: rgba(15,23,42,.98);
        border: 1px solid rgba(255,255,255,.12);
        box-shadow: 0 20px 50px rgba(0,0,0,.45);
        backdrop-filter: blur(20px);

        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px) scale(.97);
        transition: .2s ease;
    }

    .sb-customer-dropdown.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    .sb-menu-title {
        padding: 10px 12px 8px;
        color: #fbbf24;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
    }

    .sb-menu-item {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 12px;
        margin: 2px 0;
        border-radius: 12px;
        color: #e2e8f0 !important;
        text-decoration: none !important;
        font-size: 14px;
        font-weight: 600;
        transition: .2s ease;
    }

    .sb-menu-item:hover {
        background: rgba(255,255,255,.09);
        color: #fbbf24 !important;
        transform: translateX(3px);
    }

    .sb-menu-item i {
        width: 20px;
        text-align: center;
        font-size: 15px;
    }

    .sb-menu-divider {
        height: 1px;
        background: rgba(255,255,255,.1);
        margin: 7px 5px;
    }

    .sb-menu-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99998;
        background: rgba(0,0,0,.25);
    }

    .sb-menu-backdrop.show {
        display: block;
    }

    @media(max-width:576px) {

        .sb-customer-menu {
            top: 12px;
            right: 12px;
        }

        .sb-customer-dropdown {
            width: 225px;
        }

    }
</style>

<div class="sb-menu-backdrop" id="sbCustomerMenuBackdrop"></div>

<div class="sb-customer-menu">

    <button
        type="button"
        class="sb-menu-trigger"
        id="sbCustomerMenuTrigger"
        aria-label="Open customer menu"
        aria-expanded="false"
    >
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>

    <div class="sb-customer-dropdown" id="sbCustomerDropdown">

        <div class="sb-menu-title">
            <i class="fa-solid fa-basket-shopping me-1"></i>
            Smart Basket
        </div>

        {{-- HOME / PRODUCTS --}}
        <a
            href="{{ route('products.index') }}"
            class="sb-menu-item"
        >
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>

        {{-- MY ORDERS --}}
        <a
            href="{{ route('orders.index') }}"
            class="sb-menu-item"
        >
            <i class="fa-solid fa-box"></i>
            <span>My Orders</span>
        </a>

        {{-- PROFILE --}}
        <a
            href="{{ route('profile') }}"
            class="sb-menu-item"
        >
            <i class="fa-solid fa-user"></i>
            <span>Profile</span>
        </a>

        {{-- SETTINGS --}}
        @if(Route::has('settings'))
            <a
                href="{{ route('settings') }}"
                class="sb-menu-item"
            >
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
            </a>
        @endif

        {{-- CART --}}
        <a
            href="{{ route('cart.index') }}"
            class="sb-menu-item"
        >
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Cart</span>
        </a>

        <div class="sb-menu-divider"></div>

        {{-- PRODUCTS --}}
        <a
            href="{{ route('products.index') }}"
            class="sb-menu-item"
        >
            <i class="fa-solid fa-store"></i>
            <span>All Products</span>
        </a>

        {{-- AI HUB --}}
        @if(Route::has('ai.hub'))
            <a
                href="{{ route('ai.hub') }}"
                class="sb-menu-item"
            >
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <span>AI Hub</span>
            </a>
        @elseif(Route::has('ai-hub'))
            <a
                href="{{ route('ai-hub') }}"
                class="sb-menu-item"
            >
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <span>AI Hub</span>
            </a>
        @endif

    </div>

</div>

<script>
(function () {

    const trigger = document.getElementById('sbCustomerMenuTrigger');
    const dropdown = document.getElementById('sbCustomerDropdown');
    const backdrop = document.getElementById('sbCustomerMenuBackdrop');

    if (!trigger || !dropdown || !backdrop) {
        return;
    }

    function openMenu() {
        dropdown.classList.add('show');
        backdrop.classList.add('show');
        trigger.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
        dropdown.classList.remove('show');
        backdrop.classList.remove('show');
        trigger.setAttribute('aria-expanded', 'false');
    }

    trigger.addEventListener('click', function (event) {

        event.stopPropagation();

        if (dropdown.classList.contains('show')) {
            closeMenu();
        } else {
            openMenu();
        }

    });

    dropdown.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    backdrop.addEventListener('click', function () {
        closeMenu();
    });

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeMenu();
        }

    });

})();
</script>