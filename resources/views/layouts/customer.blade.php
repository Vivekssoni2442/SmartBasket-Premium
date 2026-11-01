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

    <link rel="stylesheet" href="{{ asset('css/customer-page-title.css') }}?v=20261019-purple-blue-4">

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

            display: block;

            background:
                var(--sb-bg);
        }


        /* =========================================================
           MAIN CONTENT
           Customer sidebar is fixed by customer/sidebar.blade.php
        ========================================================== */

        .sb-main {

            width: 100%;

            min-width: 0;

            box-sizing: border-box;

            min-height: 100vh;

            margin-left: 0;

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

        .sb-mobile-menu {

            display: none !important;
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
                100%;

                margin-left:
                    0;
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

    <x-products-customer-taskbar :include-robot="false" />
    <x-ai-hub-sidebar :without-menu="true" />


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

    <script src="{{ asset('js/customer-page-title.js') }}?v=20261019-purple-blue-4" defer></script>

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


<div class="customer-global-smart-ai">
    <x-smart-ai-robot />
</div>

@if(session('customer_login_welcome'))
    <div class="sb-login-welcome" role="dialog" aria-modal="true" aria-label="Welcome to Smart Basket">
        <div class="sb-login-welcome__glow"></div>
        <div class="sb-login-welcome__card">
            <div class="sb-login-welcome__halo" aria-hidden="true"><div class="sb-login-welcome__orbit"><i class="fa-solid fa-basket-shopping"></i></div><span class="sb-welcome-star sb-welcome-star--one">✦</span><span class="sb-welcome-star sb-welcome-star--two">✧</span></div>
            <div class="sb-login-welcome__eyebrow">A LITTLE MORE JOY IN EVERY BASKET</div>
            <h2>Welcome to<br><span>Smart Basket</span></h2>
            <p>{{ auth()->check() ? 'We’re happy to have you here, ' . auth()->user()->name . '.' : 'Your smarter shopping journey starts now.' }}</p>
            <button type="button" class="sb-login-welcome__voice" id="sbWelcomeVoice"><i class="fa-solid fa-volume-high"></i><span>Hear the welcome</span></button>
            <div class="sb-login-welcome__bar"><i></i></div>
            <div class="sb-login-welcome__caption" id="sbWelcomeCaption" aria-live="polite">A smarter way to shop, made for you.</div>
        </div>
    </div>
    <style>
        .sb-login-welcome{position:fixed;inset:0;z-index:20000;display:flex;align-items:center;justify-content:center;padding:22px;background:radial-gradient(ellipse at center,rgba(24,38,75,.78),rgba(3,8,20,.91));backdrop-filter:blur(14px);animation:sbWelcomeFade .5s ease both}
        .sb-login-welcome__glow{position:absolute;left:50%;top:50%;width:min(82vw,720px);aspect-ratio:1;transform:translate(-50%,-50%);border-radius:50%;background:radial-gradient(circle,rgba(109,91,255,.28),rgba(37,203,255,.1) 42%,transparent 70%);animation:sbWelcomeAura 3.4s ease-in-out infinite}
        .sb-login-welcome__card{position:relative;isolation:isolate;overflow:hidden;width:min(100%,500px);padding:40px 32px 28px;text-align:center;border:1px solid rgba(255,255,255,.2);border-radius:30px;background:linear-gradient(150deg,rgba(26,35,69,.98),rgba(10,17,37,.98));box-shadow:0 40px 120px rgba(0,0,0,.56),inset 0 1px rgba(255,255,255,.14);animation:sbWelcomeCenter .85s cubic-bezier(.18,.86,.25,1) both}
        .sb-login-welcome__card:before{content:"";position:absolute;z-index:-1;inset:0;background:linear-gradient(125deg,transparent 20%,rgba(255,255,255,.075) 48%,transparent 68%);transform:translateX(-110%);animation:sbWelcomeShine 1.3s .3s ease-out both}
        .sb-login-welcome__halo{position:relative;display:grid;place-items:center;width:110px;height:110px;margin:0 auto 24px;border:1px solid rgba(128,157,255,.35);border-radius:50%;background:radial-gradient(circle,rgba(95,129,255,.2),rgba(95,129,255,.03) 68%);animation:sbWelcomeIcon .8s .2s both}
        .sb-login-welcome__halo:before,.sb-login-welcome__halo:after{content:"";position:absolute;inset:8px;border:1px solid rgba(119,216,255,.26);border-radius:50%;animation:sbWelcomeRing 2.4s ease-out infinite}.sb-login-welcome__halo:after{animation-delay:1.2s}
        .sb-login-welcome__orbit{position:relative;z-index:1;display:grid;place-items:center;width:66px;height:66px;border-radius:21px;background:linear-gradient(145deg,#9a7bff,#42d8f3);color:#fff;font-size:27px;box-shadow:0 12px 38px rgba(82,123,255,.42);animation:sbWelcomeFloat 2.5s ease-in-out infinite}
        .sb-welcome-star{position:absolute;color:#a9ecff;text-shadow:0 0 14px #69ccff;animation:sbWelcomeTwinkle 1.8s ease-in-out infinite}.sb-welcome-star--one{right:-4px;top:16px;font-size:19px}.sb-welcome-star--two{left:2px;bottom:12px;font-size:16px;animation-delay:.7s}
        .sb-login-welcome__eyebrow{color:#aebeff;font:750 9px/1.5 system-ui,sans-serif;letter-spacing:.2em}.sb-login-welcome h2{margin:12px 0 11px;color:#fff;font:800 clamp(32px,7vw,44px)/1.05 system-ui,sans-serif;letter-spacing:-.05em}.sb-login-welcome h2 span{background:linear-gradient(90deg,#b3a2ff,#69e5ff);-webkit-background-clip:text;background-clip:text;color:transparent}.sb-login-welcome p{min-height:23px;margin:0;color:#bcc8e0;font:400 13px/1.6 system-ui,sans-serif}
        .sb-login-welcome__voice{display:inline-flex;align-items:center;gap:9px;margin-top:20px;padding:10px 15px;border:1px solid rgba(142,183,255,.32);border-radius:999px;background:rgba(107,145,255,.12);color:#d8e7ff;font:650 11px system-ui,sans-serif;cursor:pointer;transition:background .2s,transform .2s}.sb-login-welcome__voice:hover{transform:translateY(-2px);background:rgba(107,145,255,.22)}.sb-login-welcome__voice i{color:#82e5ff}
        .sb-login-welcome__bar{height:2px;max-width:180px;margin:23px auto 12px;overflow:hidden;border-radius:9px;background:rgba(255,255,255,.12)}.sb-login-welcome__bar i{display:block;width:0;height:100%;border-radius:inherit;background:linear-gradient(90deg,#a28aff,#57e1ff);animation:sbWelcomeProgress 4.4s linear forwards}.sb-login-welcome__caption{color:#8292b5;font:500 10px/1.4 system-ui,sans-serif;letter-spacing:.03em}
        @keyframes sbWelcomeFade{from{opacity:0}to{opacity:1}}@keyframes sbWelcomeCenter{0%{opacity:0;transform:translateY(24px) scale(.92)}70%{transform:translateY(-3px) scale(1.01)}100%{opacity:1;transform:translateY(0) scale(1)}}@keyframes sbWelcomeIcon{from{opacity:0;transform:scale(.6) rotate(-12deg)}to{opacity:1;transform:scale(1) rotate(0)}}@keyframes sbWelcomeAura{50%{opacity:.68;scale:1.09}}@keyframes sbWelcomeRing{0%{transform:scale(.78);opacity:.7}100%{transform:scale(1.32);opacity:0}}@keyframes sbWelcomeFloat{50%{transform:translateY(-4px)}}@keyframes sbWelcomeTwinkle{50%{opacity:.45;transform:scale(.8) rotate(25deg)}}@keyframes sbWelcomeShine{to{transform:translateX(110%)}}@keyframes sbWelcomeProgress{to{width:100%}}
        @media(max-width:480px){.sb-login-welcome__card{padding:34px 22px 25px;border-radius:25px}.sb-login-welcome__halo{width:96px;height:96px}.sb-login-welcome__orbit{width:59px;height:59px}}
        @media(prefers-reduced-motion:reduce){.sb-login-welcome,.sb-login-welcome *{animation-duration:.01ms!important;animation-iteration-count:1!important;scroll-behavior:auto!important}}
    </style>
    <script>
    (() => {
        const overlay = document.querySelector('.sb-login-welcome');
        const button = document.getElementById('sbWelcomeVoice');
        if (!overlay || !button) return;
        const text = 'Welcome to Smart Basket. A smarter way to shop, made just for you.';
        const speakWelcome = () => {
            if (!('speechSynthesis' in window) || !('SpeechSynthesisUtterance' in window)) {
                button.hidden = true;
                return;
            }
            window.speechSynthesis.cancel();
            const greeting = new SpeechSynthesisUtterance(text);
            const voices = window.speechSynthesis.getVoices();
            greeting.voice = voices.find(voice => /^en-IN$/i.test(voice.lang)) || voices.find(voice => /^en-/i.test(voice.lang)) || null;
            greeting.lang = greeting.voice?.lang || 'en-IN';
            greeting.rate = 0.92;
            greeting.pitch = 1.08;
            greeting.volume = 0.9;
            greeting.onstart = () => { button.querySelector('span').textContent = 'Playing welcome'; };
            greeting.onend = () => { button.querySelector('span').textContent = 'Hear the welcome again'; };
            greeting.onerror = () => { button.querySelector('span').textContent = 'Tap to hear welcome'; };
            window.speechSynthesis.speak(greeting);
        };
        button.addEventListener('click', speakWelcome);
        window.setTimeout(() => { speakWelcome(); }, 500);
        window.setTimeout(() => {
            overlay.style.transition = 'opacity .55s ease';
            overlay.style.opacity = '0';
            window.setTimeout(() => {
                window.speechSynthesis?.cancel();
                overlay.remove();
            }, 600);
        }, 5000);
    })();
    </script>
@endif


@stack('scripts')


</body>

</html>
