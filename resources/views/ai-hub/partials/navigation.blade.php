@if($showSiteMenu ?? true)
    <x-site-menu />
@endif

{{-- =========================================================
     SMART BASKET — GLOBAL AI HUB
     ONE BUTTON + ONE DRAWER
========================================================= --}}

<link
    rel="stylesheet"
    href="{{ asset('css/ai-hub-sidebar.css') }}"
>

{{-- =========================================================
     FLOATING AI HUB BUTTON
========================================================= --}}

<button
    type="button"
    class="ai-hub-fab"
    data-ai-hub-open
    aria-label="Open AI Hub"
    aria-expanded="false"
>
    <span>🤖</span>
    <small>AI HUB</small>
</button>


{{-- =========================================================
     OVERLAY
========================================================= --}}

<div
    class="ai-hub-overlay"
    data-ai-hub-close
></div>


{{-- =========================================================
     AI HUB DRAWER
========================================================= --}}

<aside
    class="ai-hub-drawer"
    data-ai-hub-drawer
    aria-hidden="true"
>

    {{-- HEADER --}}

    <header class="ai-hub-drawer-header">

        <div>
            <strong>🤖 AI HUB</strong>

            <small>
                Smart Shopping Assistant
            </small>
        </div>

        <button
            type="button"
            class="ai-hub-close"
            data-ai-hub-close
            aria-label="Close AI HUB"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>

    </header>


    {{-- =====================================================
         ALL AI TOOLS
    ====================================================== --}}

    <nav
        class="ai-hub-drawer-nav"
        aria-label="AI Shopping Tools"
    >

        {{-- AI CAMERA --}}

        @if(Route::has('ai-camera-assistant'))

            <a
                href="{{ route('ai-camera-assistant') }}"
                class="{{ request()->routeIs('ai-camera-assistant') ? 'active' : '' }}"
                data-ai-hub-link
            >
                <span class="ai-hub-tool-icon">📷</span>

                <span class="ai-hub-tool-text">
                    <strong>AI Camera Assistant</strong>
                    <small>Smart visual shopping</small>
                </span>

                <i class="fa-solid fa-chevron-right"></i>
            </a>

        @endif


        {{-- BUDGET SHOPPING --}}

        @if(Route::has('budget-shopping'))

            <a
                href="{{ route('budget-shopping') }}"
                class="{{ request()->routeIs('budget-shopping') ? 'active' : '' }}"
                data-ai-hub-link
            >
                <span class="ai-hub-tool-icon">💰</span>

                <span class="ai-hub-tool-text">
                    <strong>Budget Shopping</strong>
                    <small>Find products by budget</small>
                </span>

                <i class="fa-solid fa-chevron-right"></i>
            </a>

        @endif


        {{-- GIFT FINDER --}}

        @if(Route::has('gift-finder'))

            <a
                href="{{ route('gift-finder') }}"
                class="{{ request()->routeIs('gift-finder') ? 'active' : '' }}"
                data-ai-hub-link
            >
                <span class="ai-hub-tool-icon">🎁</span>

                <span class="ai-hub-tool-text">
                    <strong>AI Gift Finder</strong>
                    <small>Find the perfect gift</small>
                </span>

                <i class="fa-solid fa-chevron-right"></i>
            </a>

        @endif


        {{-- TRENDING PRODUCTS --}}

        @if(Route::has('trending-products'))

            <a
                href="{{ route('trending-products') }}"
                class="{{ request()->routeIs('trending-products') ? 'active' : '' }}"
                data-ai-hub-link
            >
                <span class="ai-hub-tool-icon">🌟</span>

                <span class="ai-hub-tool-text">
                    <strong>Trending Products</strong>
                    <small>Discover what's popular</small>
                </span>

                <i class="fa-solid fa-chevron-right"></i>
            </a>

        @endif


        {{-- COMPARE PRODUCTS --}}

        @if(Route::has('compare-products'))

            <a
                href="{{ route('compare-products') }}"
                class="{{ request()->routeIs('compare-products') ? 'active' : '' }}"
                data-ai-hub-link
            >
                <span class="ai-hub-tool-icon">⚖️</span>

                <span class="ai-hub-tool-text">
                    <strong>Compare Products</strong>
                    <small>Compare your choices</small>
                </span>

                <i class="fa-solid fa-chevron-right"></i>
            </a>

        @endif


        <div class="ai-hub-divider"></div>


        {{-- WISHLIST --}}

        @if(Route::has('wishlist'))

            <a
                href="{{ route('wishlist') }}"
                class="{{ request()->routeIs('wishlist*') ? 'active' : '' }}"
                data-ai-hub-link
            >
                <span class="ai-hub-tool-icon">❤️</span>

                <span class="ai-hub-tool-text">
                    <strong>Wishlist</strong>
                    <small>Your saved products</small>
                </span>

                <i class="fa-solid fa-chevron-right"></i>
            </a>

        @endif


        {{-- CART --}}

        @if(Route::has('cart.index'))

            <a
                href="{{ route('cart.index') }}"
                class="{{ request()->routeIs('cart.*') ? 'active' : '' }}"
                data-ai-hub-link
            >
                <span class="ai-hub-tool-icon">🛒</span>

                <span class="ai-hub-tool-text">
                    <strong>Cart</strong>
                    <small>Your shopping cart</small>
                </span>

                <i class="fa-solid fa-chevron-right"></i>
            </a>

        @endif


        {{-- PROFILE --}}

        @if(Route::has('profile'))

            <a
                href="{{ route('profile') }}"
                class="{{ request()->routeIs('profile*') ? 'active' : '' }}"
                data-ai-hub-link
            >
                <span class="ai-hub-tool-icon">👤</span>

                <span class="ai-hub-tool-text">
                    <strong>Profile</strong>
                    <small>Manage your account</small>
                </span>

                <i class="fa-solid fa-chevron-right"></i>
            </a>

        @endif

    </nav>


    {{-- OVERVIEW --}}

    @if(Route::has('overview'))

        <a
            href="{{ route('overview') }}"
            class="ai-hub-overview {{ request()->routeIs('overview') ? 'active' : '' }}"
        >
            <span>📊</span>

            <strong>
                AI HUB Overview
            </strong>

            <i class="fa-solid fa-arrow-right"></i>
        </a>

    @endif

</aside>


{{-- =========================================================
     GLOBAL JAVASCRIPT
========================================================= --}}

<script src="{{ asset('js/ai-hub-sidebar.js') }}"></script>
