<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'SmartBasket Premium')
    </title>


    {{-- =====================================================
         SMART BASKET GLOBAL THEME
    ====================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >


    {{-- =====================================================
         GLOBAL APP ASSETS
    ====================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    {{-- =====================================================
         GLOBAL AI HUB CSS
         ONLY ONE COPY
    ====================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/ai-hub-sidebar.css') }}"
    >


    @stack('styles')


    {{-- =====================================================
         THEME BEFORE PAGE PAINT
    ====================================================== --}}

    <script>

        (function () {

            const savedTheme =
                localStorage.getItem('sb-theme');


            const databaseTheme =
                @auth
                    @json(auth()->user()->dark_mode ?? 'system')
                @else
                    'system'
                @endauth;


            const selectedTheme =
                savedTheme ||
                databaseTheme ||
                'system';


            function getSystemTheme() {

                return window.matchMedia(
                    '(prefers-color-scheme: dark)'
                ).matches
                    ? 'dark'
                    : 'light';

            }


            function applyTheme(theme) {

                let finalTheme = theme;


                if (
                    theme !== 'dark' &&
                    theme !== 'light'
                ) {

                    finalTheme =
                        getSystemTheme();

                }


                document.documentElement
                    .setAttribute(
                        'data-theme',
                        finalTheme
                    );


                document.documentElement
                    .setAttribute(
                        'data-sb-theme',
                        finalTheme
                    );


                document.documentElement
                    .style
                    .colorScheme = finalTheme;

            }


            applyTheme(selectedTheme);


            /* =================================================
               SYSTEM THEME CHANGE
            ================================================= */

            const mediaQuery =
                window.matchMedia(
                    '(prefers-color-scheme: dark)'
                );


            mediaQuery.addEventListener(
                'change',
                function () {

                    const current =
                        localStorage.getItem(
                            'sb-theme'
                        ) ||
                        databaseTheme;


                    if (
                        !current ||
                        current === 'system'
                    ) {

                        applyTheme('system');

                    }

                }
            );


            /* =================================================
               OTHER TABS
            ================================================= */

            window.addEventListener(
                'storage',
                function (event) {

                    if (
                        event.key === 'sb-theme'
                    ) {

                        applyTheme(
                            event.newValue ||
                            'system'
                        );

                    }

                }
            );


            /* =================================================
               GLOBAL SMART BASKET THEME API
            ================================================= */

            window.SmartBasketTheme = {

                set: function (theme) {

                    if (
                        ![
                            'light',
                            'dark',
                            'system'
                        ].includes(theme)
                    ) {

                        return;

                    }


                    localStorage.setItem(
                        'sb-theme',
                        theme
                    );


                    applyTheme(theme);

                },


                get: function () {

                    return (
                        localStorage.getItem(
                            'sb-theme'
                        ) ||
                        databaseTheme ||
                        'system'
                    );

                }

            };

        })();

    </script>

</head>


<body>


    {{-- =====================================================
         GLOBAL CUSTOMER PAGE
    ====================================================== --}}

    <div class="sb-page">

        {{-- =================================================
             GLOBAL AI HUB

             IMPORTANT:
             AI HUB YAHAN SIRF EK BAAR HOGA.
             Kisi individual page me dobara include nahi karna.
        ================================================== --}}

        @include('ai-hub.partials.navigation')


        {{-- =================================================
             PAGE CONTENT
        ================================================== --}}

        @yield('content')

    </div>


    {{-- =====================================================
         GLOBAL AI HUB JAVASCRIPT
         ONLY ONE COPY
    ====================================================== --}}

    <script
        src="{{ asset('js/ai-hub-sidebar.js') }}"
        defer>
    </script>


    {{-- =====================================================
         BOOTSTRAP
    ====================================================== --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


    @stack('scripts')


</body>

</html>