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

            --sb-sidebar:
                rgba(255,255,255,.97);

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

            --sb-sidebar:
                rgba(9,19,33,.98);

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
        }


        html {
            background: var(--sb-bg) !important;
            color: var(--sb-text) !important;
        }


        body {

            min-height: 100vh;

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

            display: flex;

            background:
                var(--sb-bg);
        }


        /* =========================================================
           SIDEBAR
        ========================================================== */

        .sb-sidebar {

            position: fixed;

            left: 0;

            top: 0;

            bottom: 0;

            z-index: 5000;

            width: 250px;

            display: flex;

            flex-direction: column;

            padding: 20px 14px;

            background:
                var(--sb-sidebar);

            border-right:
                1px solid var(--sb-border);

            box-shadow:
                12px 0 40px var(--sb-shadow);

            backdrop-filter:
                blur(20px);

            -webkit-backdrop-filter:
                blur(20px);

            overflow-y: auto;

            transition:
                transform .25s ease,
                background-color .25s ease;
        }


        .sb-sidebar::-webkit-scrollbar {
            width: 5px;
        }


        .sb-sidebar::-webkit-scrollbar-thumb {

            background:
                var(--sb-border);

            border-radius: 10px;
        }


        /* BRAND */

        .sb-sidebar-brand {

            display: flex;

            align-items: center;

            gap: 11px;

            padding:
                5px 9px 20px;

            margin-bottom: 8px;

            border-bottom:
                1px solid var(--sb-border);

            color:
                var(--sb-text) !important;
        }


        .sb-sidebar-logo {

            width: 42px;

            height: 42px;

            display: grid;

            place-items: center;

            flex-shrink: 0;

            border-radius: 13px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    #1d6fe8,
                    #3e91ff
                );

            box-shadow:
                0 9px 22px
                rgba(29,111,232,.25);
        }


        .sb-sidebar-brand strong {

            display: block;

            color:
                var(--sb-primary);

            font-size: 13px;

            font-weight: 900;

            letter-spacing: .08em;
        }


        .sb-sidebar-brand small {

            display: block;

            margin-top: 2px;

            color:
                var(--sb-muted);

            font-size: 8px;

            font-weight: 700;

            letter-spacing: .12em;
        }


        /* SECTION */

        .sb-sidebar-section {

            margin:
                17px 7px 7px;

            color:
                var(--sb-muted);

            font-size: 8px;

            font-weight: 900;

            letter-spacing: .16em;

            text-transform: uppercase;
        }


        /* LINKS */

        .sb-sidebar-link {

            min-height: 45px;

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 4px;

            padding:
                0 12px;

            border-radius: 12px;

            color:
                var(--sb-text-secondary) !important;

            font-size: 11px;

            font-weight: 700;

            transition:
                all .2s ease;
        }


        .sb-sidebar-link i {

            width: 19px;

            text-align: center;

            font-size: 14px;
        }


        .sb-sidebar-link:hover {

            color:
                var(--sb-primary) !important;

            background:
                var(--sb-card-2);

            transform:
                translateX(3px);
        }


        .sb-sidebar-link.active {

            color:
                #fff !important;

            background:
                linear-gradient(
                    135deg,
                    #1d6fe8,
                    #347fe9
                );

            box-shadow:
                0 8px 22px
                rgba(29,111,232,.20);
        }


        .sb-sidebar-link.active i {
            color: #fff;
        }


        /* AI */

        .sb-sidebar-ai {

            color: #fff !important;

            background:
                linear-gradient(
                    135deg,
                    #172a46,
                    #0b172a
                );

            border:
                1px solid
                rgba(111,168,255,.18);
        }


        .sb-sidebar-ai:hover {

            color: #fff !important;

            transform:
                translateX(3px);

            box-shadow:
                0 10px 28px
                rgba(29,111,232,.22);
        }


        .sb-sidebar-ai i {

            color:
                #8bb9ff;
        }


        /* BOTTOM */

        .sb-sidebar-bottom {

            margin-top: auto;

            padding-top: 14px;

            border-top:
                1px solid var(--sb-border);
        }


        .sb-sidebar-user {

            display: flex;

            align-items: center;

            gap: 10px;

            margin-bottom: 8px;

            padding: 9px;

            border-radius: 12px;

            background:
                var(--sb-card-2);
        }


        .sb-user-avatar {

            width: 34px;

            height: 34px;

            display: grid;

            place-items: center;

            flex-shrink: 0;

            border-radius: 50%;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    #1d6fe8,
                    #8b5cf6
                );
        }


        .sb-user-info {

            min-width: 0;
        }


        .sb-user-info strong {

            display: block;

            overflow: hidden;

            color:
                var(--sb-text);

            font-size: 10px;

            white-space: nowrap;

            text-overflow: ellipsis;
        }


        .sb-user-info small {

            display: block;

            margin-top: 2px;

            color:
                var(--sb-muted);

            font-size: 8px;
        }


        /* =========================================================
           CONTENT
        ========================================================== */

        .sb-main {

            width: calc(100% - 250px);

            min-height: 100vh;

            margin-left: 250px;
        }


        /* =========================================================
           TOPBAR
        ========================================================== */

        .sb-topbar {

            position: sticky;

            top: 0;

            z-index: 4000;

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
        }


        /* =========================================================
           PAGE
        ========================================================== */

        .sb-page {

            width: 100%;

            max-width: 1500px;

            margin: 0 auto;

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
           MOBILE
        ========================================================== */

        @media (max-width: 900px) {

            .sb-sidebar {

                transform:
                    translateX(-100%);
            }


            .sb-sidebar.open {

                transform:
                    translateX(0);
            }


            .sb-main {

                width: 100%;

                margin-left: 0;
            }


            .sb-mobile-menu {

                display: grid;

                place-items: center;
            }


            .sb-page {

                padding:
                    16px 12px 60px;
            }


            .sb-topbar {

                padding:
                    10px 12px;
            }

        }


        @media (max-width: 500px) {

            .sb-topbar-title {
                font-size: 11px;
            }

        }

    </style>

    @stack('styles')

</head>


<body>

<div class="sb-app">


    {{-- =========================================================
         COMMON SIDEBAR
    ========================================================== --}}

    <x-site-menu />
    @include('customer.sidebar')


    {{-- =========================================================
         MAIN
    ========================================================== --}}

    <div class="sb-main">


        {{-- TOPBAR --}}

        <header class="sb-topbar">

            <div class="d-flex align-items-center gap-2">

                <button
                    type="button"
                    class="sb-mobile-menu"
                    id="sbMobileMenu"
                >

                    <i class="fa-solid fa-bars"></i>

                </button>


                <span class="sb-topbar-title">

                    @yield('page_title', 'Smart Basket')

                </span>

            </div>


            <div class="sb-topbar-actions">

                <a
                    href="{{ route('wishlist') }}"
                    class="sb-topbar-btn"
                    title="Wishlist"
                >

                    <i class="fa-regular fa-heart"></i>

                </a>


                <a
                    href="{{ route('cart.index') }}"
                    class="sb-topbar-btn"
                    title="Cart"
                >

                    <i class="fa-solid fa-cart-shopping"></i>

                </a>


                <a
                    href="{{ route('profile') }}"
                    class="sb-topbar-btn"
                    title="Profile"
                >

                    <i class="fa-solid fa-user"></i>

                </a>

            </div>

        </header>


        @yield('content')

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


<script>

(function () {

    const html = document.documentElement;


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


    let theme = getTheme();


    if (!theme) {

        @auth

            theme =
                @json(auth()->user()->theme ?? 'dark');

        @else

            theme = 'dark';

        @endauth

    }


    applyTheme(theme);


    /* STORAGE SYNC */

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


    /* CUSTOM THEME EVENT */

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


    /* GLOBAL FUNCTION */

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


    /* WHEN USER RETURNS TO PAGE */

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


/* =========================================================
   MOBILE SIDEBAR
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const button =
            document.getElementById('sbMobileMenu');

        const sidebar =
            document.getElementById('sbSidebar');


        if (!button || !sidebar) {
            return;
        }


        button.addEventListener(
            'click',
            function () {

                sidebar.classList.toggle('open');

            }
        );


        document.addEventListener(
            'click',
            function (event) {

                if (
                    window.innerWidth <= 900 &&
                    sidebar.classList.contains('open') &&
                    !sidebar.contains(event.target) &&
                    !button.contains(event.target)
                ) {

                    sidebar.classList.remove('open');

                }

            }
        );

    }
);

</script>


@stack('scripts')

</body>

</html>
