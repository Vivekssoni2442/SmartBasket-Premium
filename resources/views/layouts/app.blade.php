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
         THEME CSS
    ====================================================== --}}

    <link rel="stylesheet"
          href="{{ asset('css/premium-dark-theme.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    {{-- =====================================================
         THEME APPLY BEFORE PAGE RENDER
         Prevents white flash
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
                savedTheme || databaseTheme || 'system';


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

                    finalTheme = getSystemTheme();

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
                        ) || databaseTheme;

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
                            event.newValue || 'system'
                        );

                    }

                }
            );


            /* =================================================
               GLOBAL SMART BASKET THEME FUNCTION
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
                        ) || databaseTheme || 'system'
                    );

                }

            };

        })();

    </script>

</head>


<body>

    <div class="sb-page">

        @yield('content')

    </div>


    @stack('scripts')


    {{-- =====================================================
         BOOTSTRAP
    ====================================================== --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


</body>

</html>