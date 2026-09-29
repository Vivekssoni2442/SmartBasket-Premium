<aside
    class="sb-sidebar"
    id="sbSidebar"
>

    {{-- =========================================================
         BRAND
    ========================================================== --}}

    <a
        href="{{ route('products.index') }}"
        class="sb-sidebar-brand"
    >

        <span class="sb-sidebar-logo">

            <i class="fa-solid fa-basket-shopping"></i>

        </span>


        <span>

            <strong>SMART BASKET</strong>

            <small>CUSTOMER SHOPPING</small>

        </span>

    </a>


    {{-- =========================================================
         MAIN
    ========================================================== --}}

    <div class="sb-sidebar-section">
        Main
    </div>


    {{-- PRODUCTS --}}

    <a
        href="{{ route('products.index') }}"
        class="sb-sidebar-link {{ request()->routeIs('products.index') ? 'active' : '' }}"
    >

        <i class="fa-solid fa-store"></i>

        <span>
            Products
        </span>

    </a>


    {{-- WISHLIST --}}

    <a
        href="{{ route('wishlist') }}"
        class="sb-sidebar-link {{ request()->routeIs('wishlist*') ? 'active' : '' }}"
    >

        <i class="fa-regular fa-heart"></i>

        <span>
            Wishlist
        </span>

    </a>


    {{-- CART --}}

    <a
        href="{{ route('cart.index') }}"
        class="sb-sidebar-link {{ request()->routeIs('cart*') ? 'active' : '' }}"
    >

        <i class="fa-solid fa-cart-shopping"></i>

        <span>
            Cart
        </span>

    </a>


    {{-- ORDERS --}}

    <a
        href="{{ route('orders.index') }}"
        class="sb-sidebar-link {{ request()->routeIs('orders*') ? 'active' : '' }}"
    >

        <i class="fa-solid fa-box"></i>

        <span>
            My Orders
        </span>

    </a>


    {{-- =========================================================
         AI
    ========================================================== --}}

    <div class="sb-sidebar-section">
        Smart AI
    </div>


    {{-- AI HUB --}}

    <a
        href="{{ route('ai-hub') }}"
        class="sb-sidebar-link sb-sidebar-ai {{ request()->routeIs('ai-hub') ? 'active' : '' }}"
    >

        <i class="fa-solid fa-wand-magic-sparkles"></i>

        <span>
            AI Shopping Hub
        </span>

    </a>


    {{-- AI CAMERA --}}

    <a
        href="{{ route('ai-camera-assistant') }}"
        class="sb-sidebar-link {{ request()->routeIs('ai-camera-assistant') ? 'active' : '' }}"
    >

        <i class="fa-solid fa-camera-retro"></i>

        <span>
            AI Camera Assistant
        </span>

    </a>


    {{-- BUDGET --}}

    @if(Route::has('budget-shopping'))

        <a
            href="{{ route('budget-shopping') }}"
            class="sb-sidebar-link {{ request()->routeIs('budget-shopping') ? 'active' : '' }}"
        >

            <i class="fa-solid fa-wallet"></i>

            <span>
                Budget Shopping
            </span>

        </a>

    @endif


    {{-- GIFT FINDER --}}

    @if(Route::has('gift-finder'))

        <a
            href="{{ route('gift-finder') }}"
            class="sb-sidebar-link {{ request()->routeIs('gift-finder') ? 'active' : '' }}"
        >

            <i class="fa-solid fa-gift"></i>

            <span>
                AI Gift Finder
            </span>

        </a>

    @endif


    {{-- TRENDING --}}

    @if(Route::has('trending-products'))

        <a
            href="{{ route('trending-products') }}"
            class="sb-sidebar-link {{ request()->routeIs('trending-products') ? 'active' : '' }}"
        >

            <i class="fa-solid fa-fire"></i>

            <span>
                Trending Products
            </span>

        </a>

    @endif


    {{-- COMPARE --}}

    @if(Route::has('compare-products'))

        <a
            href="{{ route('compare-products') }}"
            class="sb-sidebar-link {{ request()->routeIs('compare-products') ? 'active' : '' }}"
        >

            <i class="fa-solid fa-scale-balanced"></i>

            <span>
                Compare Products
            </span>

        </a>

    @endif


    {{-- =========================================================
         ACCOUNT
    ========================================================== --}}

    <div class="sb-sidebar-section">
        Account
    </div>


    {{-- PROFILE --}}

    <a
        href="{{ route('profile') }}"
        class="sb-sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}"
    >

        <i class="fa-solid fa-user"></i>

        <span>
            Profile
        </span>

    </a>


    {{-- SETTINGS --}}

    @if(Route::has('settings'))

        <a
            href="{{ route('settings') }}"
            class="sb-sidebar-link {{ request()->routeIs('settings') ? 'active' : '' }}"
        >

            <i class="fa-solid fa-gear"></i>

            <span>
                Settings
            </span>

        </a>

    @endif


    {{-- =========================================================
         USER
    ========================================================== --}}

    <div class="sb-sidebar-bottom">

        @auth

            <div class="sb-sidebar-user">

                <span class="sb-user-avatar">

                    <i class="fa-solid fa-user"></i>

                </span>


                <div class="sb-user-info">

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <small>
                        Customer Account
                    </small>

                </div>

            </div>

        @endauth


        {{-- LOGOUT --}}

        @auth

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="sb-sidebar-link w-100 border-0"
                    style="background:transparent;"
                >

                    <i class="fa-solid fa-right-from-bracket"></i>

                    <span>
                        Logout
                    </span>

                </button>

            </form>

        @endauth

    </div>

</aside>