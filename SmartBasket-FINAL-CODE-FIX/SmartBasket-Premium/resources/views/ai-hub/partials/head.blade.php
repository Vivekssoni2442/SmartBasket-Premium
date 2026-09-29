<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<meta
    name="csrf-token"
    content="{{ csrf_token() }}"
>

<meta
    name="theme-color"
    content="#07101d"
>


{{-- =========================================================
     PAGE TITLE
========================================================= --}}

<title>
    {{ $title ?? 'AI HUB' }} | Smart Basket
</title>


{{-- =========================================================
     BOOTSTRAP
========================================================= --}}

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>


{{-- =========================================================
     FONT AWESOME
========================================================= --}}

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
>


{{-- =========================================================
     SMART BASKET PREMIUM THEME
========================================================= --}}

<link
    rel="stylesheet"
    href="{{ asset('css/premium-dark-theme.css') }}"
>


{{-- =========================================================
     AI HUB GLOBAL DASHBOARD
========================================================= --}}

<link
    rel="stylesheet"
    href="{{ asset('css/ai-hub-dashboard.css') }}"
>


{{-- =========================================================
     AI HUB GLOBAL FLOATING SIDEBAR
     
     IMPORTANT:
     Ye CSS AI HUB ke har page par popup/floating button
     ko same design me rakhega.
========================================================= --}}

{{-- =========================================================
    PAGE-SAFE BASE STYLE
========================================================= --}}

<style>

    html,
    body {
        margin: 0;
        padding: 0;
        min-height: 100%;
    }


    body {

        overflow-x: hidden;

        font-family:
            'Poppins',
            'Inter',
            Arial,
            sans-serif;

    }


    /*
     * AI HUB pages ko floating AI button ke liye
     * bottom/right space milta rahe.
     */

    .ai-hub-main {

        position: relative;

        min-height: 100vh;

    }


    /*
     * Product links par default underline remove.
     */

    .ai-product-grid a {

        text-decoration: none;

    }


    /*
     * AI HUB buttons/links accessible focus state.
     */

    .ai-hub-fab:focus-visible,
    .ai-hub-close:focus-visible,
    .ai-hub-drawer-nav a:focus-visible,
    .ai-hub-overview:focus-visible {

        outline:
            2px solid
            rgba(111,168,255,.85);

        outline-offset: 3px;

    }


    /*
     * Mobile safety
     */

    @media (max-width: 760px) {

        .ai-hub-main {

            padding-bottom: 90px;

        }

    }

</style>