<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Smart Basket')
    </title>


    {{-- =========================================================
         THEME — APPLY BEFORE PAGE PAINT
    ========================================================== --}}

    <script>
        (function () {

            const html = document.documentElement;

            const keys = [
                'sb-theme',
                'smartbasket-theme',
                'theme'
            ];

            let theme = null;

            for (const key of keys) {

                const value = localStorage.getItem(key);

                if (value === 'light' || value === 'dark') {
                    theme = value;
                    break;
                }

            }

            @auth
                if (!theme) {
                    theme = @json(auth()->user()->theme ?? null);
                }
            @endauth

            if (theme !== 'light' && theme !== 'dark') {
                theme = 'dark';
            }

            html.setAttribute('data-theme', theme);

            window.SB_THEME = theme;

        })();
    </script>


    {{-- BOOTSTRAP --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- FONT AWESOME --}}

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >


    {{-- AI CAMERA CSS --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/ai-camera.css') }}"
    >


    {{-- =========================================================
         CUSTOMER PREMIUM TASKBAR CSS
         Taskbar itself is loaded from customer/sidebar.blade.php
    ========================================================== --}}

    <style>

        /* =========================================================
           SMART BASKET CUSTOMER SYSTEM
        ========================================================== */

        :root {

            --sb-bg: #f5f7fb;
            --sb-surface: #ffffff;
            --sb-card: #ffffff;
            --sb-card-2: #f8fafc;

            --sb-border: #e3e9f2;

            --sb-text: #102033;
            --sb-text-secondary: #607086;
            --sb-muted: #8b98aa;

            --sb-primary: #1d6fe8;
            --sb-primary-hover: #1457bd;

            --sb-success: #198754;
            --sb-danger: #d15b6d;

            --sb-shadow: rgba(18,38,63,.10);

            --sb-topbar:
                rgba(255,255,255,.92);
        }


        html[data-theme="dark"] {

            --sb-bg: #07101d;
            --sb-surface: #0d1929;
            --sb-card: #122238;
            --sb-card-2: #182b43;

            --sb-border: #293d58;

            --sb-text: #f3f7fc;
            --sb-text-secondary: #b8c6d8;
            --sb-muted: #8fa1b8;

            --sb-primary: #6fa8ff;
            --sb-primary-hover: #94beff;

            --sb-success: #46c98a;
            --sb-danger: #ee7d91;

            --sb-shadow: rgba(0,0,0,.30);

            --sb-topbar:
                rgba(7,16,29,.94);
        }


        /* =========================================================
           RESET
        ========================================================== */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            width: 100%;
        }


        html {
            background: var(--sb-bg) !important;
            color: var(--sb-text) !important;
        }


        body {

            min-height: 100vh;
            width: 100%;

            overflow-x: hidden;

            font-family:
                Poppins,
                Arial,
                sans-serif;

            background:
                var(--sb-bg) !important;

            color:
                var(--sb-text) !important;

            transition:
                background-color .25s ease,
                color .25s ease;
        }


        a {
            text-decoration: none !important;
        }


        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        label {
            color: var(--sb-text) !important;
        }


        p {
            color: var(--sb-text-secondary) !important;
        }


        .text-muted {
            color: var(--sb-muted) !important;
        }


        /* =========================================================
           CUSTOMER APP
        ========================================================== */

        .sb-app {

            min-height: 100vh;
            width: 100%;

            display: flex;

            background:
                var(--sb-bg);
        }


        /* =========================================================
           MAIN CONTENT
           Customer sidebar is fixed by customer/sidebar.blade.php
        ========================================================== */

        .sb-main {

            width: calc(100% - 280px);

            min-height: 100vh;

            margin-left: 280px;

            display: flex;

            flex-direction: column;

            background:
                var(--sb-bg);

            transition:
                margin-left .25s ease,
                width .25s ease,
                background-color .25s ease;
        }


        /* =========================================================
           TOPBAR
        ========================================================== */

        .sb-topbar {

            position: sticky;

            top: 0;

            z-index: 4000;

            width: 100%;

            min-height: 65px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            padding:
                10px 25px;

            background:
                var(--sb-topbar);

            border-bottom:
                1px solid var(--sb-border);

            backdrop-filter:
                blur(20px);

            -webkit-backdrop-filter:
                blur(20px);
        }


        /* =========================================================
           MOBILE TASKBAR BUTTON
        ========================================================== */

        .sb-mobile-menu {

            display: none;

            width: 40px;

            height: 40px;

            border:
                1px solid var(--sb-border);

            border-radius: 10px;

            background:
                var(--sb-card);

            color:
                var(--sb-text);

            cursor: pointer;

            align-items: center;

            justify-content: center;
        }


        .sb-topbar-title {

            color:
                var(--sb-text);

            font-size: 13px;

            font-weight: 800;
        }


        .sb-topbar-actions {

            display: flex;

            align-items: center;

            gap: 7px;
        }


        .sb-topbar-btn {

            width: 39px;

            height: 39px;

            display: grid;

            place-items: center;

            border:
                1px solid var(--sb-border);

            border-radius: 50%;

            color:
                var(--sb-text-secondary);

            background:
                var(--sb-card);

            transition:
                all .2s ease;
        }


        .sb-topbar-btn:hover {

            color:
                var(--sb-primary);

            border-color:
                var(--sb-primary);

            transform:
                translateY(-1px);
        }


        /* =========================================================
           PAGE
        ========================================================== */

        .sb-page {

            width: 100%;

            max-width: none;

            margin: 0;

            padding:
                25px 25px 70px;
        }


        /* =========================================================
           GLOBAL CARDS
        ========================================================== */

        .sb-card {

            border:
                1px solid var(--sb-border);

            border-radius: 18px;

            background:
                var(--sb-card);

            box-shadow:
                0 10px 30px var(--sb-shadow);
        }


        /* =========================================================
           FORMS
        ========================================================== */

        .form-control,
        .form-select {

            min-height: 43px;

            color:
                var(--sb-text) !important;

            background:
                var(--sb-card-2) !important;

            border:
                1px solid var(--sb-border) !important;

            border-radius: 9px;

            font-size: 12px;
        }


        .form-control::placeholder {

            color:
                var(--sb-muted) !important;
        }


        .form-control:focus,
        .form-select:focus {

            color:
                var(--sb-text) !important;

            background:
                var(--sb-card-2) !important;

            border-color:
                var(--sb-primary) !important;

            box-shadow:
                0 0 0 .18rem
                rgba(29,111,232,.12) !important;
        }


        .form-select option {

            color:
                var(--sb-text);

            background:
                var(--sb-card);
        }


        .btn-primary {

            color: #fff !important;

            background:
                var(--sb-primary) !important;

            border-color:
                var(--sb-primary) !important;
        }


        .btn-primary:hover {

            color: #fff !important;

            background:
                var(--sb-primary-hover) !important;

            border-color:
                var(--sb-primary-hover) !important;
        }


        /* =========================================================
           THEME TRANSITION
        ========================================================== */

        html.sb-theme-transition,
        html.sb-theme-transition * {

            transition:
                background-color .25s ease !important,
                color .25s ease !important,
                border-color .25s ease !important,
                box-shadow .25s ease !important;
        }


        /* =========================================================
           CUSTOMER TASKBAR OVERRIDE
           Makes the premium sidebar fit correctly
        ========================================================== */

        .customer-sidebar {

            z-index: 5000 !important;
        }


        .customer-mobile-toggle {

            z-index: 5100 !important;
        }


        /* =========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 1100px) {

            .sb-main {

                width:
                    calc(100% - 250px);

                margin-left:
                    250px;
            }

        }


        @media (max-width: 900px) {

            .sb-main {

                width: 100%;

                margin-left: 0;

                min-height: 100vh;
            }


            .sb-mobile-menu {

                display: flex;
            }


            .sb-page {

                width: 100%;

                padding:
                    16px 12px 60px;
            }


            .sb-topbar {

                width: 100%;

                padding:
                    10px 12px;
            }


            /*
             * Premium customer sidebar handles
             * its own mobile open/close system.
             */
            .customer-sidebar {

                z-index: 5000 !important;
            }

        }


        @media (max-width: 500px) {

            .sb-topbar-title {

                font-size: 11px;
            }


            .sb-topbar-actions {

                gap: 4px;
            }


            .sb-topbar-btn {

                width: 36px;

                height: 36px;
            }

        }

    </style>

    @stack('styles')

</head>


<body>


<div class="sb-app">


    {{-- =========================================================
         COMMON CUSTOMER TASKBAR
         This is the SAME taskbar on customer pages
    ========================================================== --}}

    @include('customer.sidebar')


    {{-- =========================================================
         MAIN CUSTOMER CONTENT
    ========================================================== --}}

    <div class="sb-main">


        {{-- =====================================================
             TOPBAR
        ====================================================== --}}

        <header class="sb-topbar">

            <div class="d-flex align-items-center gap-2">

                {{-- Mobile taskbar button --}}

                <button
                    type="button"
                    class="sb-mobile-menu"
                    id="sbMobileMenu"
                    aria-label="Open customer menu"
                >

                    <i class="fa-solid fa-bars"></i>

                </button>


                <span class="sb-topbar-title">

                    @yield(
                        'page_title',
                        'Smart Basket'
                    )

                </span>

            </div>


            {{-- =================================================
                 TOPBAR ACTIONS
            ================================================== --}}

            <div class="sb-topbar-actions">


                {{-- Wishlist --}}

                <a
                    href="{{ route('wishlist') }}"
                    class="sb-topbar-btn"
                    title="Wishlist"
                    aria-label="Wishlist"
                >

                    <i class="fa-regular fa-heart"></i>

                </a>


                {{-- Cart --}}

                <a
                    href="{{ route('cart.index') }}"
                    class="sb-topbar-btn"
                    title="Cart"
                    aria-label="Cart"
                >

                    <i class="fa-solid fa-cart-shopping"></i>

                </a>


                {{-- Profile --}}

                <a
                    href="{{ route('profile') }}"
                    class="sb-topbar-btn"
                    title="Profile"
                    aria-label="Profile"
                >

                    <i class="fa-solid fa-user"></i>

                </a>

            </div>

        </header>


        {{-- =====================================================
             PAGE CONTENT
        ====================================================== --}}

        @yield('content')


    </div>

</div>


{{-- =========================================================
     BOOTSTRAP JS
========================================================== --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


{{-- =========================================================
     THEME SYSTEM
========================================================== --}}

<script>

(function () {

    const html =
        document.documentElement;


    function normalizeTheme(theme) {

        if (
            theme === 'light' ||
            theme === 'dark'
        ) {

            return theme;

        }


        if (
            theme === 'auto' ||
            theme === 'system'
        ) {

            return window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches
                ? 'dark'
                : 'light';

        }


        return 'dark';

    }


    function getTheme() {

        const keys = [
            'sb-theme',
            'smartbasket-theme',
            'theme'
        ];


        for (const key of keys) {

            const value =
                localStorage.getItem(key);


            if (
                value === 'light' ||
                value === 'dark'
            ) {

                return value;

            }

        }


        return null;

    }


    function applyTheme(theme) {

        const finalTheme =
            normalizeTheme(theme);


        html.classList.add(
            'sb-theme-transition'
        );


        html.setAttribute(
            'data-theme',
            finalTheme
        );


        window.SB_THEME =
            finalTheme;


        localStorage.setItem(
            'sb-theme',
            finalTheme
        );


        setTimeout(function () {

            html.classList.remove(
                'sb-theme-transition'
            );

        }, 300);

    }


    let theme =
        getTheme();


    if (!theme) {

        @auth

            theme =
                @json(
                    auth()->user()->theme ?? 'dark'
                );

        @else

            theme = 'dark';

        @endauth

    }


    applyTheme(theme);


    /* =====================================================
       STORAGE SYNC
    ====================================================== */

    window.addEventListener(
        'storage',
        function (event) {

            if (
                event.key === 'sb-theme' &&
                event.newValue
            ) {

                applyTheme(
                    event.newValue
                );

            }

        }
    );


    /* =====================================================
       CUSTOM THEME EVENT
    ====================================================== */

    window.addEventListener(
        'sbThemeChanged',
        function (event) {

            if (
                event.detail &&
                event.detail.theme
            ) {

                applyTheme(
                    event.detail.theme
                );

            }

        }
    );


    /* =====================================================
       GLOBAL THEME FUNCTION
    ====================================================== */

    window.setSmartBasketTheme =
        function (theme) {

            const finalTheme =
                normalizeTheme(theme);


            applyTheme(finalTheme);


            window.dispatchEvent(
                new CustomEvent(
                    'sbThemeChanged',
                    {
                        detail: {
                            theme: finalTheme
                        }
                    }
                )
            );

        };


    /* =====================================================
       WHEN USER RETURNS TO PAGE
    ====================================================== */

    window.addEventListener(
        'focus',
        function () {

            const latest =
                getTheme();


            if (!latest) {
                return;
            }


            if (
                latest !==
                html.getAttribute('data-theme')
            ) {

                applyTheme(latest);

            }

        }
    );

})();

</script>


{{-- =========================================================
     MOBILE CUSTOMER TASKBAR BRIDGE
========================================================== --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const oldButton =
            document.getElementById('sbMobileMenu');

        const customerSidebar =
            document.querySelector(
                '[data-customer-sidebar]'
            );

        const customerOpen =
            document.querySelector(
                '[data-customer-sidebar-open]'
            );


        /*
         * The premium customer sidebar has
         * its own mobile button.
         *
         * This bridge makes the TOPBAR hamburger
         * open the SAME taskbar.
         */

        if (
            oldButton &&
            customerSidebar &&
            customerOpen
        ) {

            oldButton.addEventListener(
                'click',
                function () {

                    customerOpen.click();

                }
            );

        }

    }
);

</script>


@stack('scripts')


</body>

</html>