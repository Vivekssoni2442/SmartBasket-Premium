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
        @yield('title', 'Seller Partner Program') | SMART BASKET
    </title>


    {{-- =========================================================
         FONT
    ========================================================== --}}

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- =========================================================
         FONT AWESOME
    ========================================================== --}}

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >


    {{-- =========================================================
         SMART BASKET GLOBAL THEME
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >


    {{-- =========================================================
         SELLER PREMIUM CSS
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/seller-premium.css') }}"
    >


    <script>
        window.SellerThemeManager = (function () {
            const STORAGE_KEY = 'smartbasket_seller_theme';

            function normalize(theme) {
                return theme === 'dark' || theme === 'light' || theme === 'system'
                    ? theme
                    : 'light';
            }

            function getSystemTheme() {
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            function resolve(theme) {
                const normalized = normalize(theme);
                return normalized === 'system' ? getSystemTheme() : normalized;
            }

            function apply(theme, persist = true) {
                const selected = normalize(theme);
                const finalTheme = resolve(selected);

                document.documentElement.setAttribute('data-theme', finalTheme);
                document.documentElement.setAttribute('data-sb-theme', finalTheme);
                document.documentElement.setAttribute('data-seller-theme', selected);

                if (persist) {
                    localStorage.setItem(STORAGE_KEY, selected);
                }

                return selected;
            }

            function setTheme(theme) {
                apply(theme, true);
            }

            function initialize(savedTheme) {
                const preferred = normalize(savedTheme || 'light');
                apply(preferred, true);

                const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

                const handler = function () {
                    if (normalize(localStorage.getItem(STORAGE_KEY) || preferred) === 'system') {
                        apply('system', false);
                    }
                };

                if (mediaQuery.addEventListener) {
                    mediaQuery.addEventListener('change', handler);
                } else {
                    mediaQuery.addListener(handler);
                }
            }

            return {
                normalize,
                resolve,
                apply,
                setTheme,
                initialize,
                getSystemTheme,
            };
        })();

        (function () {
            try {
                const savedDatabaseTheme = @json($seller->theme ?? 'light');
                const initialTheme = savedDatabaseTheme || 'light';
                window.SellerThemeManager.apply(initialTheme, false);
            } catch (error) {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>


    <style>
        :root {
            --sb-bg: #f8fafc;
            --sb-bg-secondary: #eef2ff;
            --sb-card: rgba(255,255,255,0.9);
            --sb-card-hover: rgba(241,245,249,0.92);
            --sb-text: #111827;
            --sb-text-secondary: #475569;
            --sb-border: rgba(148,163,184,0.35);
            --sb-primary: #2563eb;
            --sb-primary-hover: #1d4ed8;
            --sb-shadow: 0 20px 45px rgba(15,23,42,0.08);
            --sb-input-bg: #ffffff;
            --sb-input-border: #dfe7f1;
            --sb-success: #16a34a;
            --sb-danger: #dc2626;
        }

        html[data-theme="dark"],
        html[data-sb-theme="dark"],
        html[data-seller-theme="dark"] {
            --sb-bg: #0b1120;
            --sb-bg-secondary: #111827;
            --sb-card: rgba(17,24,39,0.9);
            --sb-card-hover: rgba(31,41,55,0.92);
            --sb-text: #f8fafc;
            --sb-text-secondary: #cbd5e1;
            --sb-border: rgba(148,163,184,0.22);
            --sb-primary: #60a5fa;
            --sb-primary-hover: #93c5fd;
            --sb-shadow: 0 24px 60px rgba(2,6,23,0.45);
            --sb-input-bg: rgba(2,6,23,0.7);
            --sb-input-border: rgba(148,163,184,0.25);
        }

        * {
            box-sizing: border-box;
        }


        html {

            scroll-behavior: smooth;

            background:
                var(--sb-bg) !important;

            color:
                var(--sb-text) !important;

        }


        body {

            margin: 0;

            min-height: 100vh;

            font-family:
                'Poppins',
                sans-serif;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    color-mix(
                        in srgb,
                        var(--sb-primary) 7%,
                        transparent
                    ),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 90%,
                    color-mix(
                        in srgb,
                        var(--sb-primary) 7%,
                        transparent
                    ),
                    transparent 30%
                ),
                var(--sb-bg) !important;

            color:
                var(--sb-text) !important;

            overflow-x: hidden;

            transition:
                background-color .25s ease,
                color .25s ease;

        }


        a {

            text-decoration: none;

            color:
                var(--sb-primary);

        }


        a:hover {

            color:
                var(--sb-primary-hover);

        }


        button,
        input,
        select,
        textarea {

            font-family:
                inherit;

        }


        .seller-layout-content {

            width: 100%;

            min-height: 100vh;

            background:
                transparent !important;

            color:
                var(--sb-text) !important;

        }


        /*
        |--------------------------------------------------------------------------
        | THEME TRANSITION
        |--------------------------------------------------------------------------
        */

        html.theme-transition,
        html.theme-transition body,
        html.theme-transition .seller-layout-content,
        html.theme-transition .seller-menu,
        html.theme-transition .seller-sidebar,
        html.theme-transition .sidebar,
        html.theme-transition .seller-settings-page {

            transition:
                background-color .25s ease,
                color .25s ease,
                border-color .25s ease,
                box-shadow .25s ease !important;

        }


        @media(max-width:768px) {

            .seller-layout-content {

                padding-bottom: 20px;

            }

        }

    </style>


    @stack('styles')

</head>


<body>


    {{-- =========================================================
         SELLER MENU
    ========================================================== --}}

    @include('seller.partials.seller-menu')


    {{-- =========================================================
         PAGE CONTENT
    ========================================================== --}}

    <div class="seller-layout-content">

        @yield('content')

    </div>


    {{-- =========================================================
         GLOBAL SMART BASKET THEME SYSTEM
    ========================================================== --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {


                const html =
                    document.documentElement;


                /*
                |--------------------------------------------------------------------------
                | GET SAVED THEME
                |--------------------------------------------------------------------------
                */

                let sellerTheme = @json($seller->theme ?? 'light');
                const localTheme = localStorage.getItem('smartbasket_seller_theme');

                if (localTheme) {
                    sellerTheme = localTheme;
                }

                if (!['dark', 'light', 'system'].includes(sellerTheme)) {
                    sellerTheme = 'light';
                }

                function applySellerTheme(selectedTheme, saveLocal = true) {
                    const normalized = selectedTheme === 'dark' || selectedTheme === 'light' || selectedTheme === 'system'
                        ? selectedTheme
                        : 'light';

                    const finalTheme = normalized === 'system'
                        ? window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
                        : normalized;

                    html.setAttribute('data-theme', finalTheme);
                    html.setAttribute('data-sb-theme', finalTheme);
                    html.setAttribute('data-seller-theme', normalized);

                    if (saveLocal) {
                        localStorage.setItem('smartbasket_seller_theme', normalized);
                    }

                    html.classList.add('theme-transition');
                    setTimeout(() => html.classList.remove('theme-transition'), 280);
                }

                applySellerTheme(sellerTheme, false);

                if (window.matchMedia) {
                    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
                    const systemThemeChanged = function () {
                        if (localStorage.getItem('smartbasket_seller_theme') === 'system' || sellerTheme === 'system') {
                            applySellerTheme('system', false);
                        }
                    };

                    if (mediaQuery.addEventListener) {
                        mediaQuery.addEventListener('change', systemThemeChanged);
                    } else {
                        mediaQuery.addListener(systemThemeChanged);
                    }
                }

                window.addEventListener('smartbasket-theme-changed', function (event) {
                    if (event.detail && event.detail.theme) {
                        sellerTheme = event.detail.theme;
                        applySellerTheme(sellerTheme, true);
                    }
                });

                window.addEventListener('storage', function (event) {
                    if (event.key === 'smartbasket_seller_theme' && event.newValue) {
                        sellerTheme = event.newValue;
                        applySellerTheme(sellerTheme, false);
                    }
                });

            }
        );

    </script>


    @stack('scripts')

</body>

</html>