<!DOCTYPE html>

<html lang="en" data-theme="light" data-sb-theme="light" data-seller-theme="light">

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
    @yield('title', 'Seller Panel') | SMART BASKET
</title>

{{-- =========================================================
     FONTS
========================================================== --}}

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
    rel="stylesheet"
>

{{-- =========================================================
     FONT AWESOME
========================================================== --}}

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
>

{{-- =========================================================
     GLOBAL SELLER CSS
========================================================== --}}

<link
    rel="stylesheet"
    href="{{ asset('css/premium-dark-theme.css') }}"
>

<link
    rel="stylesheet"
    href="{{ asset('css/seller-premium.css') }}"
>

{{-- =========================================================
     THEME MANAGER
========================================================== --}}

<script>

    window.SellerThemeManager = (function () {

        const STORAGE_KEY = 'smartbasket_seller_theme';

        function normalize(theme) {

            return (
                theme === 'dark' ||
                theme === 'light' ||
                theme === 'system'
            )
                ? theme
                : 'light';

        }

        function getSystemTheme() {

            if (!window.matchMedia) {
                return 'light';
            }

            return window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches
                ? 'dark'
                : 'light';

        }

        function resolve(theme) {

            const normalized = normalize(theme);

            return normalized === 'system'
                ? getSystemTheme()
                : normalized;

        }

        function apply(theme, persist = true) {

            const selected = normalize(theme);

            const finalTheme = resolve(selected);

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
                selected
            );

            if (persist) {

                try {

                    localStorage.setItem(
                        STORAGE_KEY,
                        selected
                    );

                } catch (error) {}

            }

            return selected;

        }

        function setTheme(theme) {

            return apply(theme, true);

        }

        function initialize(savedTheme) {

            const preferred =
                normalize(
                    savedTheme || 'light'
                );

            apply(
                preferred,
                true
            );

            if (!window.matchMedia) {
                return;
            }

            const mediaQuery =
                window.matchMedia(
                    '(prefers-color-scheme: dark)'
                );

            const handler = function () {

                let current = preferred;

                try {

                    current =
                        normalize(
                            localStorage.getItem(
                                STORAGE_KEY
                            ) || preferred
                        );

                } catch (error) {}

                if (current === 'system') {

                    apply(
                        'system',
                        false
                    );

                }

            };

            if (mediaQuery.addEventListener) {

                mediaQuery.addEventListener(
                    'change',
                    handler
                );

            } else if (mediaQuery.addListener) {

                mediaQuery.addListener(
                    handler
                );

            }

        }

        return {
            normalize,
            resolve,
            apply,
            setTheme,
            initialize,
            getSystemTheme
        };

    })();


    /* =========================================================
       DATABASE THEME
    ========================================================= */

    (function () {

        try {

            const databaseTheme =
                @json($seller->theme ?? 'light');

            window.SellerThemeManager.apply(
                databaseTheme,
                false
            );

        } catch (error) {

            window.SellerThemeManager.apply(
                'light',
                false
            );

        }

    })();

</script>

{{-- =========================================================
     SELLER LAYOUT MASTER CSS
========================================================== --}}

<style>

    :root {

        --seller-font:
            'Poppins',
            sans-serif;

        --seller-bg:
            #f8fafc;

        --seller-bg-secondary:
            #f1f5f9;

        --seller-card:
            #ffffff;

        --seller-text:
            #0f172a;

        --seller-text-secondary:
            #64748b;

        --seller-border:
            rgba(15, 23, 42, .08);

        --seller-primary:
            #16a34a;

        --seller-primary-dark:
            #15803d;

        --seller-danger:
            #dc2626;

        --seller-radius:
            16px;

        --seller-shadow:
            0 20px 50px rgba(15, 23, 42, .08);

    }


    html[data-theme="dark"] {

        --seller-bg:
            #070b12;

        --seller-bg-secondary:
            #0d131d;

        --seller-card:
            #111827;

        --seller-text:
            #f8fafc;

        --seller-text-secondary:
            #94a3b8;

        --seller-border:
            rgba(255, 255, 255, .08);

        --seller-shadow:
            0 20px 60px rgba(0, 0, 0, .35);

    }


    *,
    *::before,
    *::after {

        box-sizing:
            border-box;

    }


    html,
    body {

        width:
            100%;

        min-height:
            100%;

        margin:
            0;

        padding:
            0;

    }


    html {

        scroll-behavior:
            smooth;

        background:
            var(--seller-bg);

    }


    body {

        min-height:
            100vh;

        margin:
            0;

        padding:
            0;

        font-family:
            var(--seller-font);

        font-size:
            14px;

        line-height:
            1.5;

        color:
            var(--seller-text);

        background:
            var(--seller-bg);

        overflow-x:
            hidden;

        -webkit-font-smoothing:
            antialiased;

        -moz-osx-font-smoothing:
            grayscale;

    }


    body input,
    body textarea,
    body select,
    body button {

        font-family:
            var(--seller-font) !important;

    }


    body a {

        font-family:
            var(--seller-font);

    }


    /* =========================================================
       SINGLE GLOBAL TOPBAR HOLDER

       IMPORTANT:
       Every seller page receives the same topbar through
       premium-layout only.
    ========================================================= */

    .seller-layout-topbar {

        position:
            relative;

        z-index:
            99999;

        width:
            100%;

        margin:
            0;

        padding:
            0;

    }


    /*
     * DO NOT FORCE POPPINS ON ICON ELEMENTS.
     */

    .seller-layout-topbar
    i.fa-solid,
    .seller-layout-topbar
    i.fas {

        font-family:
            "Font Awesome 6 Free" !important;

        font-weight:
            900 !important;

        font-style:
            normal !important;

    }


    .seller-layout-topbar
    i.fa-regular,
    .seller-layout-topbar
    i.far {

        font-family:
            "Font Awesome 6 Free" !important;

        font-weight:
            400 !important;

        font-style:
            normal !important;

    }


    .seller-layout-topbar
    i.fa-brands,
    .seller-layout-topbar
    i.fab {

        font-family:
            "Font Awesome 6 Brands" !important;

        font-weight:
            400 !important;

        font-style:
            normal !important;

    }


    /* =========================================================
       PAGE CONTENT
    ========================================================= */

    .seller-layout-content {

        position:
            relative;

        width:
            100%;

        min-height:
            calc(100vh - 76px);

        margin:
            0;

        padding:
            0;

        color:
            var(--seller-text);

        background:
            transparent;

    }


    /*
     * PAGE CONTENT MUST NEVER CREATE ANOTHER TOPBAR.
     */

    .seller-layout-content
    > .seller-global-topbar {

        display:
            none !important;

    }


    img {

        max-width:
            100%;

    }


    button:focus-visible,
    a:focus-visible,
    input:focus-visible,
    textarea:focus-visible,
    select:focus-visible {

        outline:
            2px solid var(--seller-primary);

        outline-offset:
            3px;

    }


    html.theme-transition,
    html.theme-transition body,
    html.theme-transition .seller-layout-content,
    html.theme-transition .seller-layout-topbar {

        transition:
            background-color .25s ease,
            color .25s ease,
            border-color .25s ease,
            box-shadow .25s ease;

    }


    @media (max-width: 760px) {

        .seller-layout-content {

            min-height:
                calc(100vh - 68px);

        }

    }


    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {

            scroll-behavior:
                auto !important;

            animation:
                none !important;

            transition:
                none !important;

        }

    }

</style>

@stack('styles')


</head>

<body>


{{-- =========================================================
     ONE AND ONLY SELLER GLOBAL TASKBAR

     DO NOT PUT THIS INCLUDE INSIDE INDIVIDUAL PAGES.
========================================================== --}}

<div class="seller-layout-topbar">

    @include('seller.partials.topbar')

</div>


{{-- =========================================================
     PAGE CONTENT ONLY
========================================================== --}}

<main class="seller-layout-content">

    @yield('content')

</main>


{{-- =========================================================
     THEME SYNCHRONIZATION
========================================================== --}}

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const html =
                document.documentElement;

            let sellerTheme =
                @json($seller->theme ?? 'light');

            let localTheme = null;

            try {

                localTheme =
                    localStorage.getItem(
                        'smartbasket_seller_theme'
                    );

            } catch (error) {}

            if (localTheme) {

                sellerTheme =
                    localTheme;

            }

            if (
                ![
                    'dark',
                    'light',
                    'system'
                ].includes(sellerTheme)
            ) {

                sellerTheme =
                    'light';

            }

            function applySellerTheme(
                selectedTheme,
                saveLocal = true
            ) {

                const normalized =
                    [
                        'dark',
                        'light',
                        'system'
                    ].includes(selectedTheme)
                        ? selectedTheme
                        : 'light';

                const finalTheme =
                    normalized === 'system'
                        ? (
                            window.matchMedia &&
                            window.matchMedia(
                                '(prefers-color-scheme: dark)'
                            ).matches
                                ? 'dark'
                                : 'light'
                        )
                        : normalized;

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
                    normalized
                );

                if (saveLocal) {

                    try {

                        localStorage.setItem(
                            'smartbasket_seller_theme',
                            normalized
                        );

                    } catch (error) {}

                }

            }

            applySellerTheme(
                sellerTheme,
                false
            );


            /* SYSTEM THEME */

            if (window.matchMedia) {

                const mediaQuery =
                    window.matchMedia(
                        '(prefers-color-scheme: dark)'
                    );

                const systemThemeChanged =
                    function () {

                        let savedTheme = null;

                        try {

                            savedTheme =
                                localStorage.getItem(
                                    'smartbasket_seller_theme'
                                );

                        } catch (error) {}

                        if (
                            savedTheme === 'system'
                        ) {

                            applySellerTheme(
                                'system',
                                false
                            );

                        }

                    };

                if (
                    mediaQuery.addEventListener
                ) {

                    mediaQuery.addEventListener(
                        'change',
                        systemThemeChanged
                    );

                } else if (
                    mediaQuery.addListener
                ) {

                    mediaQuery.addListener(
                        systemThemeChanged
                    );

                }

            }


            /* CUSTOM THEME EVENT */

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


            /* STORAGE SYNC */

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
