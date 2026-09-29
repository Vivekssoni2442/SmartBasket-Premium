<link rel="stylesheet" href="{{ asset('css/customer-premium.css') }}">

<!-- CUSTOMER SIDEBAR OVERLAY -->
<div
    class="customer-sidebar-overlay"
    data-customer-sidebar-close
></div>


<!-- =========================================================
     CUSTOMER TASKBAR / SIDEBAR
========================================================= -->

<aside
    class="customer-sidebar"
    data-customer-sidebar
    aria-label="Customer navigation"
>

    <!-- HEADER -->

    <div class="customer-sidebar-head">

        <a
            href="{{ route('dashboard') }}"
            class="customer-brand"
        >

            <span class="customer-brand-mark">
                <i class="fa-solid fa-basket-shopping"></i>
            </span>

            <span>
                <strong>SMART</strong> BASKET
                <small>PREMIUM SHOPPING</small>
            </span>

        </a>


        <button
            type="button"
            class="customer-sidebar-close"
            data-customer-sidebar-close
            aria-label="Close navigation"
        >

            <i class="fa-solid fa-xmark"></i>

        </button>

    </div>


    <!-- =====================================================
         NAVIGATION
    ===================================================== -->

    <nav
        class="customer-nav"
        aria-label="Customer pages"
    >


        <!-- SHOP -->

        <span class="customer-nav-label">
            Shop
        </span>


        <a
            href="{{ route('dashboard') }}"
            class="{{ request()->routeIs('dashboard') ? 'is-active' : '' }}"
        >

            <i class="fa-solid fa-house"></i>

            <span>Home</span>

        </a>


        <a
            href="{{ route('products.index') }}"
            class="{{ request()->routeIs('products.*') ? 'is-active' : '' }}"
        >

            <i class="fa-solid fa-store"></i>

            <span>Products</span>

        </a>


        <a
            href="{{ route('cart.index') }}"
            class="{{ request()->routeIs('cart.*') ? 'is-active' : '' }}"
        >

            <i class="fa-solid fa-cart-shopping"></i>

            <span>Cart</span>

        </a>


        <a
            href="{{ route('wishlist') }}"
            class="{{ request()->routeIs('wishlist*') ? 'is-active' : '' }}"
        >

            <i class="fa-solid fa-heart"></i>

            <span>Wishlist</span>

        </a>


        <a
            href="{{ route('orders.index') }}"
            class="{{ request()->routeIs('orders.*') ? 'is-active' : '' }}"
        >

            <i class="fa-solid fa-box"></i>

            <span>My Orders</span>

        </a>


        <!-- =================================================
             SMART TOOLS
        ================================================== -->

        <span class="customer-nav-label">
            Smart Tools
        </span>


        <!-- AI PANEL -->

        <div class="customer-ai-panel">

            <span class="customer-ai-badge">

                <i class="fa-solid fa-sparkles"></i>

                SMART AI

            </span>


            <strong>
                Your shopping assistant
            </strong>


            <small>
                Discover, compare and choose
                with confidence.
            </small>


            <a href="{{ route('ai-hub') }}">

                <i class="fa-solid fa-wand-magic-sparkles"></i>

                Open AI HUB

                <i class="fa-solid fa-arrow-up-right-from-square"></i>

            </a>

        </div>


        <a href="{{ route('ai-camera-assistant') }}">

            <i class="fa-solid fa-camera-retro"></i>

            <span>AI Camera</span>

        </a>


        <a href="{{ route('budget-shopping') }}">

            <i class="fa-solid fa-wallet"></i>

            <span>Budget Shopping</span>

        </a>


        <a href="{{ route('gift-finder') }}">

            <i class="fa-solid fa-gift"></i>

            <span>Gift Finder</span>

        </a>


        <a href="{{ route('trending-products') }}">

            <i class="fa-solid fa-fire"></i>

            <span>Trending Products</span>

        </a>


        <a href="{{ route('compare-products') }}">

            <i class="fa-solid fa-scale-balanced"></i>

            <span>Compare Products</span>

        </a>


        <!-- =================================================
             ACCOUNT
        ================================================== -->

        <span class="customer-nav-label">
            Account
        </span>


        <a
            href="{{ route('profile') }}"
            class="{{ request()->routeIs('profile*') ? 'is-active' : '' }}"
        >

            <i class="fa-solid fa-user"></i>

            <span>Profile</span>

        </a>


        <a
            href="{{ route('settings') }}"
            class="{{ request()->routeIs('settings*') ? 'is-active' : '' }}"
        >

            <i class="fa-solid fa-gear"></i>

            <span>Settings</span>

        </a>


        <!-- SECURITY -->

        <a
            href="{{ route('security.verify.page') }}"
            class="{{ request()->routeIs('security.*') ? 'is-active' : '' }}"
        >

            <i class="fa-solid fa-shield-halved"></i>

            <span>Security</span>

        </a>


    </nav>


    <!-- =====================================================
         USER / LOGOUT
    ===================================================== -->

    <div class="customer-sidebar-foot">

        @auth

            <div class="customer-user-chip">

                <span>
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>


                <div>

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <small>
                        {{ auth()->user()->email }}
                    </small>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button type="submit">

                    <i class="fa-solid fa-arrow-right-from-bracket"></i>

                    Logout

                </button>

            </form>

        @else

            <a
                href="{{ route('login') }}"
                class="customer-login-link"
            >

                <i class="fa-solid fa-right-to-bracket"></i>

                Login

            </a>

        @endauth

    </div>

</aside>


<!-- =========================================================
     MOBILE TASKBAR BUTTON
========================================================= -->

<button
    type="button"
    class="customer-mobile-toggle"
    data-customer-sidebar-open
    aria-label="Open customer navigation"
>

    <i class="fa-solid fa-bars"></i>

</button>


<!-- =========================================================
     TASKBAR JAVASCRIPT
========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const sidebar =
        document.querySelector(
            '[data-customer-sidebar]'
        );


    const openButton =
        document.querySelector(
            '[data-customer-sidebar-open]'
        );


    const closeButtons =
        document.querySelectorAll(
            '[data-customer-sidebar-close]'
        );


    if (!sidebar || !openButton) {
        return;
    }


    function setSidebarOpen(value) {

        sidebar.classList.toggle(
            'is-open',
            value
        );


        document.body.classList.toggle(
            'customer-nav-open',
            value
        );

    }


    /* OPEN */

    openButton.addEventListener(
        'click',
        function () {

            setSidebarOpen(true);

        }
    );


    /* CLOSE */

    closeButtons.forEach(
        function (button) {

            button.addEventListener(
                'click',
                function () {

                    setSidebarOpen(false);

                }
            );

        }
    );


    /* ESC KEY */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                setSidebarOpen(false);

            }

        }
    );


    /* CLOSE AFTER NAVIGATION ON MOBILE */

    sidebar
        .querySelectorAll('a')
        .forEach(
            function (link) {

                link.addEventListener(
                    'click',
                    function () {

                        if (
                            window.innerWidth <= 900
                        ) {

                            setSidebarOpen(false);

                        }

                    }
                );

            }
        );

});

</script>