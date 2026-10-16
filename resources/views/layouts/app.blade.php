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
        href="{{ asset('css/smartbasket-theme.css') }}"
    >
    <link rel="stylesheet" href="{{ asset('css/customer-page-title.css') }}">

    {{-- Font Awesome 6.5.2 matches the icon classes used by the shared
         customer Taskbar and AI HUB navigation. --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
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

    @php
        $isAiHubPage = request()->routeIs(
            'ai-hub', 'overview', 'ai-camera', 'budget-shopping', 'gift-finder',
            'trending-products', 'compare-products', 'ai.chat.page',
            'ai-camera-assistant', 'ai-camera-assistant.history',
            'ai-camera-assistant.virtual-try-on', 'ai-camera-assistant*'
        );
    @endphp

    {{-- Keep the shared AI Hub controls outside page wrappers so page-level
         stacking contexts and clipping cannot trap the Smart AI panel. --}}
    @if($isAiHubPage)
        @include('ai-hub.partials.navigation')
    @endif

    <div class="sb-page">

        @unless($isAiHubPage)
            @include('ai-hub.partials.navigation')
        @endunless

        {{-- =================================================
             PAGE CONTENT
        ================================================== --}}

        @yield('content')

    </div>


    {{-- =====================================================
         BOOTSTRAP
    ====================================================== --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


    @stack('scripts')


</body>

</html>
