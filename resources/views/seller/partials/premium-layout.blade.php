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

        /*
        |--------------------------------------------------------------------------
        | SMART BASKET THEME - BEFORE PAGE RENDER
        |--------------------------------------------------------------------------
        | Theme ko page render hone se pehle apply karenge.
        | Isse light/dark flash nahi hoga.
        */

        (function () {

            try {

                const savedDatabaseTheme =
                    @json($seller->theme ?? 'dark');

                const localTheme =
                    localStorage.getItem('smartbasket_seller_theme');

                let theme =
                    localTheme ||
                    savedDatabaseTheme ||
                    'dark';


                if (
                    theme !== 'dark' &&
                    theme !== 'light' &&
                    theme !== 'auto' &&
                    theme !== 'system'
                ) {

                    theme = 'dark';

                }


                let finalTheme =
                    theme;


                if (
                    theme === 'auto' ||
                    theme === 'system'
                ) {

                    finalTheme =
                        window.matchMedia(
                            '(prefers-color-scheme: dark)'
                        ).matches
                            ? 'dark'
                            : 'light';

                }


                document.documentElement.setAttribute(
                    'data-theme',
                    finalTheme
                );


                document.documentElement.setAttribute(
                    'data-sb-theme',
                    finalTheme
                );


                document.documentElement.setAttribute(
                    'data-seller-theme',
                    theme
                );


            } catch (error) {

                document.documentElement.setAttribute(
                    'data-theme',
                    'dark'
                );

            }

        })();

    </script>


    <style>

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

                let sellerTheme =
                    @json($seller->theme ?? 'dark');


                const localTheme =
                    localStorage.getItem(
                        'smartbasket_seller_theme'
                    );


                /*
                |--------------------------------------------------------------------------
                | LOCAL THEME HAS PRIORITY
                |--------------------------------------------------------------------------
                */

                if (localTheme) {

                    sellerTheme =
                        localTheme;

                }


                /*
                |--------------------------------------------------------------------------
                | VALIDATE THEME
                |--------------------------------------------------------------------------
                */

                if (
                    sellerTheme !== 'dark' &&
                    sellerTheme !== 'light' &&
                    sellerTheme !== 'auto' &&
                    sellerTheme !== 'system'
                ) {

                    sellerTheme =
                        'dark';

                }


                /*
                |--------------------------------------------------------------------------
                | SYSTEM THEME
                |--------------------------------------------------------------------------
                */

                function getSystemTheme() {

                    return window.matchMedia(
                        '(prefers-color-scheme: dark)'
                    ).matches
                        ? 'dark'
                        : 'light';

                }


                /*
                |--------------------------------------------------------------------------
                | APPLY THEME
                |--------------------------------------------------------------------------
                */

                function applySellerTheme(
                    selectedTheme,
                    saveLocal = true
                ) {

                    let finalTheme =
                        selectedTheme;


                    if (
                        selectedTheme === 'auto' ||
                        selectedTheme === 'system'
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


                    /*
                    |--------------------------------------------------------------
                    | HTML ATTRIBUTES
                    |--------------------------------------------------------------
                    */

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
                        selectedTheme
                    );


                    /*
                    |--------------------------------------------------------------
                    | LOCAL STORAGE
                    |--------------------------------------------------------------
                    */

                    if (saveLocal) {

                        localStorage.setItem(
                            'smartbasket_seller_theme',
                            selectedTheme
                        );

                    }


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
                | APPLY CURRENT THEME
                |--------------------------------------------------------------------------
                */

                applySellerTheme(
                    sellerTheme,
                    false
                );


                /*
                |--------------------------------------------------------------------------
                | SYSTEM THEME CHANGE
                |--------------------------------------------------------------------------
                */

                const mediaQuery =
                    window.matchMedia(
                        '(prefers-color-scheme: dark)'
                    );


                function systemThemeChanged() {

                    if (
                        sellerTheme === 'auto' ||
                        sellerTheme === 'system'
                    ) {

                        applySellerTheme(
                            sellerTheme,
                            false
                        );

                    }

                }


                if (
                    mediaQuery.addEventListener
                ) {

                    mediaQuery.addEventListener(
                        'change',
                        systemThemeChanged
                    );

                } else {

                    mediaQuery.addListener(
                        systemThemeChanged
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | GLOBAL THEME EVENT
                |--------------------------------------------------------------------------
                */

                window.addEventListener(
                    'smartbasket-theme-changed',
                    function (event) {

                        if (
                            event.detail &&
                            event.detail.theme
                        ) {

                            sellerTheme =
                                event.detail.theme;


                            applySellerTheme(
                                sellerTheme,
                                true
                            );

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | OTHER TABS / WINDOWS
                |--------------------------------------------------------------------------
                */

                window.addEventListener(
                    'storage',
                    function (event) {

                        if (
                            event.key ===
                            'smartbasket_seller_theme' &&
                            event.newValue
                        ) {

                            sellerTheme =
                                event.newValue;


                            applySellerTheme(
                                sellerTheme,
                                false
                            );

                        }

                    }
                );

            }
        );

    </script>


    @stack('scripts')

</body>

</html>