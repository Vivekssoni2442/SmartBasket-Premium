<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Basket — Customer Settings</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >

    @php
        $currentTheme = $theme ?? $user->dark_mode ?? session('customer_theme', 'dark');

        if (!in_array($currentTheme, ['light', 'dark', 'system'], true)) {
            $currentTheme = 'dark';
        }

        $currentLanguage =
            $language
            ?? $user->language
            ?? session('customer_language', 'en');

        $languages =
            is_array($languages ?? null)
                ? $languages
                : config('locales', []);

        $notifications =
            $notifications
            ?? $user->notifications
            ?? session('customer_notifications', 'enabled');

        if (!in_array($notifications, ['enabled', 'disabled'], true)) {
            $notifications = 'enabled';
        }

        $profileName =
            trim((string) ($user->name ?? 'Customer'))
            ?: 'Customer';

        $profileEmail =
            trim((string) ($user->email ?? ''));

        $languageMeta =
            $languages[$currentLanguage] ?? null;

        $languageNative =
            is_array($languageMeta)
                ? ($languageMeta['native'] ?? $currentLanguage)
                : $currentLanguage;

        $currentRoute =
            request()->route()?->getName();

        $ordersRoute =
            Route::has('orders.index')
                ? 'orders.index'
                : (
                    Route::has('orders')
                        ? 'orders'
                        : null
                );
    @endphp


    {{-- =========================================================
         INITIAL THEME
    ========================================================== --}}

    <script>
        (() => {

            const serverTheme = @json($currentTheme);

            const savedTheme =
                localStorage.getItem('sb-theme')
                || serverTheme
                || 'system';

            const getSystemTheme = () => {

                if (
                    window.matchMedia &&
                    window.matchMedia(
                        '(prefers-color-scheme: dark)'
                    ).matches
                ) {
                    return 'dark';
                }

                return 'light';
            };

            const actualTheme =
                savedTheme === 'system'
                    ? getSystemTheme()
                    : savedTheme;

            document.documentElement.dataset.sbTheme =
                actualTheme;

            document.documentElement.dataset.theme =
                actualTheme;

            document.documentElement.dataset.sbSelectedTheme =
                savedTheme;

        })();
    </script>


    <style>

        /* =========================================================
           CUSTOMER SETTINGS
        ========================================================== */

        :root {
            --settings-radius: 24px;
            --settings-transition: .28s ease;
        }


        /* =========================================================
           DARK
        ========================================================== */

        html[data-sb-theme="dark"] {

            --sb-bg: #020617;
            --sb-bg-secondary: #07111f;

            --sb-card: rgba(15, 23, 42, .82);
            --sb-card-solid: #0f172a;

            --sb-surface: rgba(30, 41, 59, .65);
            --sb-input: #0b1220;

            --sb-border: rgba(148, 163, 184, .13);

            --sb-text: #f8fafc;
            --sb-text-secondary: #94a3b8;
            --sb-muted: #64748b;

            --sb-primary: #38bdf8;
            --sb-primary-2: #6366f1;

            --sb-primary-soft: rgba(56, 189, 248, .12);

            --sb-shadow:
                0 25px 70px rgba(0, 0, 0, .38);
        }


        /* =========================================================
           LIGHT
        ========================================================== */

        html[data-sb-theme="light"] {

            --sb-bg: #f4f7fb;
            --sb-bg-secondary: #eaf0f8;

            --sb-card: rgba(255, 255, 255, .92);
            --sb-card-solid: #ffffff;

            --sb-surface: #f8fafc;
            --sb-input: #ffffff;

            --sb-border: rgba(15, 23, 42, .10);

            --sb-text: #0f172a;
            --sb-text-secondary: #64748b;
            --sb-muted: #94a3b8;

            --sb-primary: #2563eb;
            --sb-primary-2: #7c3aed;

            --sb-primary-soft: rgba(37, 99, 235, .10);

            --sb-shadow:
                0 20px 55px rgba(15, 23, 42, .10);
        }


        /* =========================================================
           BODY
        ========================================================== */

        html,
        body {
            min-height: 100%;
        }

        body {

            margin: 0;

            color: var(--sb-text);

            background:
                radial-gradient(
                    circle at 10% 10%,
                    var(--sb-primary-soft),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 20%,
                    rgba(99, 102, 241, .08),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    var(--sb-bg),
                    var(--sb-bg-secondary)
                );

            transition:
                background var(--settings-transition),
                color var(--settings-transition);
        }


        /* =========================================================
           PRODUCTS STYLE CUSTOMER TASKBAR
        ========================================================== */




        html[data-theme="dark"],
        html[data-sb-theme="dark"] {

            --sb-tbar-bg:
                rgba(5,11,22,.94);

            --sb-tbar-panel:
                #0b1728;

            --sb-tbar-text:
                #f7fbff;

            --sb-tbar-muted:
                #9aacbf;

            --sb-tbar-border:
                rgba(101,165,255,.20);

            --sb-tbar-blue:
                #65a5ff;

            --sb-tbar-blue2:
                #8b7cff;

            --sb-tbar-soft:
                rgba(37,99,235,.16);

            --sb-tbar-shadow:
                0 20px 60px rgba(0,0,0,.42);
        }






















































































        /* =========================================================
           MORE MENU
        ========================================================== */


























































        /* =========================================================
           AI HUB / SMART AI
        ========================================================== */

        .ai-hub-fab {
            z-index:
                99980 !important;
        }


        .ai-hub-drawer {
            z-index:
                99999 !important;
        }


        html[data-theme="light"] .ai-hub-drawer {

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.99),
                    rgba(242,246,252,.99)
                ) !important;

            color:
                #101828 !important;

            border-right-color:
                rgba(37,99,235,.14) !important;

            box-shadow:
                24px 0 70px
                rgba(15,23,42,.20) !important;
        }


        html[data-theme="light"]
        .ai-hub-drawer-header strong,

        html[data-theme="light"]
        .ai-hub-tool-text strong {

            color:
                #101828 !important;
        }


        html[data-theme="light"]
        .ai-hub-drawer-header small,

        html[data-theme="light"]
        .ai-hub-tool-text small {

            color:
                #667085 !important;
        }


        html[data-theme="light"] .ai-hub-fab {

            background:
                linear-gradient(
                    145deg,
                    #fff,
                    #eef4ff
                ) !important;

            color:
                #172033 !important;

            border-color:
                rgba(37,99,235,.25) !important;
        }


        html[data-theme="dark"] .ai-hub-drawer {

            background:
                linear-gradient(
                    145deg,
                    #09111f,
                    #020711
                ) !important;
        }


        html[data-theme="dark"] .ai-hub-fab {

            background:
                linear-gradient(
                    145deg,
                    #1e293b,
                    #050a14
                ) !important;
        }








        /* =========================================================
           SETTINGS PAGE
        ========================================================== */

        .settings-page {

            width:
                100%;

            max-width:
                none;

            min-height:
                100vh;

            padding:
                30px 22px 100px;
        }


        .settings-wrapper {

            width:
                100%;

            max-width:
                none;

            margin:
                0;
        }


        /* =========================================================
           HEADER
        ========================================================== */

        .settings-header {

            position:
                relative;

            overflow:
                hidden;

            padding:
                34px 36px;

            margin-bottom:
                24px;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                30px;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-card),
                    var(--sb-surface)
                );

            box-shadow:
                var(--sb-shadow);

            backdrop-filter:
                blur(22px);
        }


        .settings-header::after {

            content:
                "";

            position:
                absolute;

            width:
                180px;

            height:
                180px;

            right:
                -70px;

            top:
                -80px;

            border-radius:
                50%;

            background:
                var(--sb-primary-soft);

            filter:
                blur(5px);
        }


        .settings-header-top {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                18px;

            margin-bottom:
                20px;

            position:
                relative;

            z-index:
                3;
        }


        .settings-header-actions {

            display:
                flex;

            align-items:
                center;

            gap:
                10px;

            flex-wrap:
                wrap;
        }


        .settings-chip {

            display:
                inline-flex;

            align-items:
                center;

            gap:
                8px;

            padding:
                9px 13px;

            border-radius:
                999px;

            background:
                var(--sb-primary-soft);

            border:
                1px solid
                var(--sb-border);

            color:
                var(--sb-primary);

            font-size:
                12px;

            font-weight:
                800;
        }


        .brand-text {

            color:
                var(--sb-primary);

            font-size:
                12px;

            font-weight:
                800;

            letter-spacing:
                3px;
        }


        .settings-title {

            position:
                relative;

            z-index:
                2;

            margin:
                8px 0 0;

            font-size:
                clamp(30px,5vw,46px);

            font-weight:
                900;

            letter-spacing:
                -1.5px;

            color:
                var(--sb-text);
        }


        .settings-title span {

            color:
                var(--sb-primary);
        }


        .settings-subtitle {

            position:
                relative;

            z-index:
                2;

            margin:
                8px 0 0;

            color:
                var(--sb-text-secondary);
        }


        /* =========================================================
           ACCOUNT STRIP
        ========================================================== */

        .settings-account-strip {

            display:
                grid;

            grid-template-columns:
                1.25fr
                repeat(3,minmax(150px,.75fr));

            gap:
                14px;

            margin:
                0 0 22px;
        }


        .account-card {

            min-height:
                105px;

            padding:
                18px;

            border-radius:
                20px;

            border:
                1px solid
                var(--sb-border);

            background:
                var(--sb-card);

            box-shadow:
                var(--sb-shadow);

            display:
                flex;

            align-items:
                center;

            gap:
                14px;

            backdrop-filter:
                blur(18px);
        }


        .account-card.main {

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary-soft),
                    var(--sb-card)
                );
        }


        .account-card-icon {

            width:
                46px;

            height:
                46px;

            border-radius:
                15px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            flex:
                0 0 46px;

            color:
                var(--sb-primary);

            background:
                var(--sb-surface);

            border:
                1px solid
                var(--sb-border);
        }


        .account-card small {

            display:
                block;

            color:
                var(--sb-text-secondary);

            font-size:
                11px;

            margin-bottom:
                4px;
        }


        .account-card strong {

            display:
                block;

            color:
                var(--sb-text);

            font-size:
                15px;

            font-weight:
                850;

            overflow:
                hidden;

            text-overflow:
                ellipsis;

            white-space:
                nowrap;
        }


        /* =========================================================
           QUICK GRID
        ========================================================== */

        .quick-grid {

            display:
                grid;

            grid-template-columns:
                repeat(4,minmax(0,1fr));

            gap:
                14px;

            margin-bottom:
                22px;
        }


        .quick-card {

            position:
                relative;

            overflow:
                hidden;

            min-height:
                118px;

            padding:
                20px;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                22px;

            background:
                var(--sb-card);

            color:
                var(--sb-text);

            text-decoration:
                none;

            box-shadow:
                var(--sb-shadow);

            transition:
                .25s ease;
        }


        .quick-card::after {

            content:
                "";

            position:
                absolute;

            width:
                100px;

            height:
                100px;

            right:
                -45px;

            bottom:
                -50px;

            border-radius:
                50%;

            background:
                var(--sb-primary-soft);

            filter:
                blur(6px);
        }


        .quick-card:hover {

            transform:
                translateY(-4px);

            border-color:
                var(--sb-primary);

            color:
                var(--sb-text);
        }


        .quick-icon {

            width:
                42px;

            height:
                42px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border-radius:
                14px;

            background:
                var(--sb-primary-soft);

            color:
                var(--sb-primary);

            margin-bottom:
                12px;
        }


        .quick-card strong {

            display:
                block;

            font-size:
                14px;

            font-weight:
                850;

            position:
                relative;

            z-index:
                2;
        }


        .quick-card span {

            display:
                block;

            color:
                var(--sb-text-secondary);

            font-size:
                11px;

            margin-top:
                4px;

            position:
                relative;

            z-index:
                2;
        }


        /* =========================================================
           CARDS
        ========================================================== */

        .settings-card {

            position:
                relative;

            overflow:
                hidden;

            padding:
                26px;

            margin-bottom:
                20px;

            border:
                1px solid
                var(--sb-border);

            border-radius:
                var(--settings-radius);

            background:
                var(--sb-card);

            box-shadow:
                var(--sb-shadow);

            backdrop-filter:
                blur(22px);

            transition:
                transform .25s ease,
                border-color .25s ease,
                background .25s ease;

            scroll-margin-top:
                100px;
        }


        .settings-card:hover {

            transform:
                translateY(-2px);

            border-color:
                var(--sb-primary-soft);
        }


        .settings-card-header {

            display:
                flex;

            align-items:
                flex-start;

            gap:
                15px;

            margin-bottom:
                23px;
        }


        .settings-icon {

            width:
                52px;

            height:
                52px;

            flex-shrink:
                0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border-radius:
                16px;

            color:
                var(--sb-primary);

            background:
                var(--sb-primary-soft);

            font-size:
                20px;

            box-shadow:
                0 10px 30px
                var(--sb-primary-soft);
        }


        .settings-card-title {

            margin:
                0;

            color:
                var(--sb-text);

            font-size:
                20px;

            font-weight:
                850;
        }


        .settings-card-description {

            margin:
                4px 0 0;

            color:
                var(--sb-text-secondary);

            font-size:
                12px;
        }


        /* =========================================================
           THEME
        ========================================================== */

        .theme-options {

            display:
                grid;

            grid-template-columns:
                repeat(3,1fr);

            gap:
                15px;
        }


        .theme-option {

            position:
                relative;
        }


        .theme-option input {

            position:
                absolute;

            opacity:
                0;

            pointer-events:
                none;
        }


        .theme-label {

            position:
                relative;

            overflow:
                hidden;

            min-height:
                160px;

            display:
                flex;

            flex-direction:
                column;

            align-items:
                center;

            justify-content:
                center;

            gap:
                9px;

            padding:
                20px;

            border-radius:
                20px;

            border:
                1px solid
                var(--sb-border);

            background:
                var(--sb-surface);

            color:
                var(--sb-text);

            cursor:
                pointer;

            transition:
                .28s ease;
        }


        .theme-label::before {

            content:
                "";

            position:
                absolute;

            width:
                100px;

            height:
                100px;

            border-radius:
                50%;

            background:
                var(--sb-primary-soft);

            filter:
                blur(18px);

            opacity:
                0;

            transition:
                .28s ease;
        }


        .theme-label i,
        .theme-label span,
        .theme-label small {

            position:
                relative;

            z-index:
                2;
        }


        .theme-label i {

            font-size:
                29px;

            color:
                var(--sb-primary);
        }


        .theme-label span {

            font-size:
                15px;

            font-weight:
                800;
        }


        .theme-label small {

            color:
                var(--sb-text-secondary);
        }


        .theme-label:hover {

            transform:
                translateY(-4px);

            border-color:
                var(--sb-primary);
        }


        .theme-label:hover::before {

            opacity:
                1;
        }


        .theme-option input:checked + .theme-label {

            border-color:
                var(--sb-primary);

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary-soft),
                    var(--sb-surface)
                );

            box-shadow:
                0 0 0 2px
                var(--sb-primary-soft),

                0 20px 45px
                var(--sb-primary-soft);

            transform:
                translateY(-4px);
        }


        /* =========================================================
           SETTING ROW
        ========================================================== */

        .setting-row {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                20px;

            min-height:
                78px;

            padding:
                18px 0;

            border-bottom:
                1px solid
                var(--sb-border);
        }


        .setting-row:last-child {

            border-bottom:
                0;
        }


        .setting-info {

            display:
                flex;

            align-items:
                center;

            gap:
                14px;
        }


        .setting-small-icon {

            width:
                44px;

            height:
                44px;

            flex-shrink:
                0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border-radius:
                14px;

            color:
                var(--sb-primary);

            background:
                var(--sb-surface);

            border:
                1px solid
                var(--sb-border);
        }


        .setting-name {

            color:
                var(--sb-text);

            font-weight:
                750;

            margin-bottom:
                3px;
        }


        .setting-description {

            color:
                var(--sb-text-secondary);

            font-size:
                12px;
        }


        .setting-row .btn {

            white-space:
                nowrap;
        }


        /* =========================================================
           BUTTON
        ========================================================== */

        .premium-btn {

            border-radius:
                999px !important;

            font-weight:
                750;

            transition:
                .25s ease;
        }


        .premium-btn:hover {

            transform:
                translateY(-2px);
        }


        /* =========================================================
           SELECT
        ========================================================== */

        .premium-select {

            min-width:
                210px;

            border-radius:
                14px !important;

            padding:
                11px 14px !important;

            background-color:
                var(--sb-input) !important;

            color:
                var(--sb-text) !important;

            border:
                1px solid
                var(--sb-border) !important;
        }


        .premium-select:focus {

            border-color:
                var(--sb-primary) !important;

            box-shadow:
                0 0 0 4px
                var(--sb-primary-soft) !important;
        }


        .premium-select option {

            background:
                var(--sb-card-solid);

            color:
                var(--sb-text);
        }


        /* =========================================================
           SWITCH
        ========================================================== */

        .premium-switch .form-check-input {

            width:
                54px;

            height:
                29px;

            cursor:
                pointer;

            background-color:
                var(--sb-muted);

            border:
                0;
        }


        .premium-switch .form-check-input:checked {

            background-color:
                var(--sb-primary);
        }


        /* =========================================================
           PREVIEW
        ========================================================== */

        .preview-box {

            padding:
                18px;

            border-radius:
                20px;

            background:
                var(--sb-surface);

            border:
                1px solid
                var(--sb-border);
        }


        .preview-top {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            margin-bottom:
                15px;

            color:
                var(--sb-text);
        }


        .preview-dot {

            width:
                10px;

            height:
                10px;

            border-radius:
                50%;

            background:
                #22c55e;

            box-shadow:
                0 0 15px
                rgba(34,197,94,.65);
        }


        .preview-content {

            padding:
                18px;

            border-radius:
                16px;

            background:
                var(--sb-card);

            border:
                1px solid
                var(--sb-border);

            color:
                var(--sb-text);
        }


        /* =========================================================
           SAVE
        ========================================================== */

        .save-area {

            position:
                sticky;

            bottom:
                12px;

            z-index:
                50;

            margin-top:
                25px;
        }


        .save-bar {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                20px;

            padding:
                16px 20px;

            border-radius:
                22px;

            background:
                var(--sb-tbar-bg);

            border:
                1px solid
                var(--sb-tbar-border);

            box-shadow:
                var(--sb-shadow);

            backdrop-filter:
                blur(25px);
        }


        .save-bar strong {

            color:
                var(--sb-text);
        }


        .save-btn {

            min-width:
                190px;

            height:
                50px;

            border:
                0 !important;

            border-radius:
                999px !important;

            font-weight:
                800;

            background:
                linear-gradient(
                    135deg,
                    var(--sb-primary),
                    var(--sb-primary-2)
                ) !important;

            color:
                white !important;

            box-shadow:
                0 12px 30px
                var(--sb-primary-soft);
        }


        .save-btn:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 18px 40px
                var(--sb-primary-soft);
        }


        /* =========================================================
           SUCCESS
        ========================================================== */

        .success-alert {

            border-radius:
                18px;

            color:
                var(--sb-text);

            border:
                1px solid
                rgba(34,197,94,.25);

            background:
                rgba(34,197,94,.10);

            box-shadow:
                var(--sb-shadow);
        }


        /* =========================================================
           DIRTY
        ========================================================== */

        .settings-page.is-dirty .save-btn {

            box-shadow:
                0 0 0 3px
                rgba(245,158,11,.12),

                0 15px 35px
                rgba(245,158,11,.18);
        }


        /* =========================================================
           RESPONSIVE
        ========================================================== */




        @media(max-width:1120px) {














            .settings-account-strip {

                grid-template-columns:
                    repeat(2,minmax(0,1fr));
            }

            .account-card.main {

                grid-column:
                    span 2;
            }

            .quick-grid {

                grid-template-columns:
                    repeat(2,minmax(0,1fr));
            }
        }


        @media(max-width:768px) {




















            .settings-page {

                padding:
                    18px 10px 85px;
            }

            .settings-header {

                padding:
                    24px 20px;
            }

            .settings-header-top {

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }

            .settings-account-strip {

                grid-template-columns:
                    1fr;
            }

            .account-card.main {

                grid-column:
                    auto;
            }

            .quick-grid {

                grid-template-columns:
                    1fr 1fr;
            }

            .theme-options {

                grid-template-columns:
                    1fr;
            }

            .theme-label {

                min-height:
                    100px;

                flex-direction:
                    row;

                justify-content:
                    flex-start;
            }

            .setting-row {

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }

            .setting-info {

                width:
                    100%;
            }

            .premium-select {

                width:
                    100%;
            }

            .premium-switch {

                margin-left:
                    58px;
            }

            .save-bar {

                flex-direction:
                    column;

                align-items:
                    stretch;
            }

            .save-btn {

                width:
                    100%;
            }
        }


        @media(max-width:480px) {

            .quick-grid {

                grid-template-columns:
                    1fr;
            }

            .settings-header {

                border-radius:
                    22px;
            }

            .settings-card {

                padding:
                    19px;

                border-radius:
                    20px;
            }
        }

        .settings-hero-actions {
            position: relative;
            z-index: 2;
            justify-content: flex-start;
            gap: 10px;
            margin-top: 14px;
        }

        .settings-hero-actions .settings-chip {
            padding: 8px 12px;
            border-color: rgba(255,255,255,.25);
            background: rgba(255,255,255,.12);
            color: #fff;
        }

        .settings-hero-actions .settings-chip i { color: #c8d7ff; }
        .settings-header-content .settings-title span { color: #c8d7ff !important; }

        @media(max-width:480px) {
            .settings-hero-actions { gap: 7px; }
            .settings-hero-actions .settings-chip { padding: 7px 9px; font-size: 11px; }
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/customer-page-title.css') }}">
</head>


<body>


{{-- =========================================================
     ONE CUSTOMER TASKBAR ONLY
========================================================= --}}

@auth

<x-products-customer-taskbar :include-robot="false" />

@endauth


{{-- =========================================================
     SMART AI HOST
========================================================= --}}

<div
    class="sb-products-smart-ai-host"
    aria-hidden="false"
>

    <x-smart-ai-robot />

</div>


{{-- =========================================================
     AI HUB
========================================================= --}}

<x-ai-hub-sidebar :without-menu="true" />


{{-- =========================================================
     SETTINGS CONTENT
========================================================= --}}

<div class="settings-page">

    <div class="settings-wrapper">


        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="settings-header-content">

            <x-customer-page-hero>
<h1 class="settings-title sb-customer-page-title">

                Customer
                <span>
                      Settings
                </span>

            </h1>
                <div class="settings-header-actions settings-hero-actions">
                    <span class="settings-chip"><i class="fa-solid fa-shield-heart"></i>Secure Account</span>
                    <span class="settings-chip"><i class="fa-solid fa-bolt"></i>Preferences Sync</span>
                </div>
</x-customer-page-hero>




        </div>


        {{-- =====================================================
             ACCOUNT OVERVIEW
        ====================================================== --}}

        <section
            class="settings-account-strip"
            aria-label="Account overview"
        >

            <div class="account-card main">

                <div class="account-card-icon">

                    <i class="fa-regular fa-user"></i>

                </div>

                <div>

                    <small>
                        Signed in as
                    </small>

                    <strong>
                        {{ $profileName }}
                    </strong>

                    @if($profileEmail)

                        <small>
                            {{ $profileEmail }}
                        </small>

                    @endif

                </div>

            </div>


            <div class="account-card">

                <div class="account-card-icon">

                    <i class="fa-solid fa-language"></i>

                </div>

                <div>

                    <small>
                        Language
                    </small>

                    <strong>
                        {{ $languageNative }}
                    </strong>

                </div>

            </div>


            <div class="account-card">

                <div class="account-card-icon">

                    <i class="fa-solid fa-bell"></i>

                </div>

                <div>

                    <small>
                        Notifications
                    </small>

                    <strong>

                        {{
                            $notifications === 'enabled'
                                ? 'Enabled'
                                : 'Disabled'
                        }}

                    </strong>

                </div>

            </div>


            <div class="account-card">

                <div class="account-card-icon">

                    <i class="fa-solid fa-circle-half-stroke"></i>

                </div>

                <div>

                    <small>
                        Appearance
                    </small>

                    <strong>
                        {{ ucfirst($currentTheme) }}
                    </strong>

                </div>

            </div>

        </section>


        {{-- =====================================================
             QUICK ACTIONS
        ====================================================== --}}

        <section
            class="quick-grid"
            aria-label="Quick account actions"
        >

            @if(Route::has('profile'))

                <a
                    class="quick-card"
                    href="{{ route('profile') }}"
                >

                    <div class="quick-icon">

                        <i class="fa-regular fa-user"></i>

                    </div>

                    <strong>
                        My Profile
                    </strong>

                    <span>
                        Account details & profile
                    </span>

                </a>

            @endif


            @if(Route::has('orders.index'))

                <a
                    class="quick-card"
                    href="{{ route('orders.index') }}"
                >

                    <div class="quick-icon">

                        <i class="fa-solid fa-box"></i>

                    </div>

                    <strong>
                        My Orders
                    </strong>

                    <span>
                        Track your purchases
                    </span>

                </a>

            @endif


            @if(Route::has('wishlist'))

                <a
                    class="quick-card"
                    href="{{ route('wishlist') }}"
                >

                    <div class="quick-icon">

                        <i class="fa-regular fa-heart"></i>

                    </div>

                    <strong>
                        Wishlist
                    </strong>

                    <span>
                        Saved products
                    </span>

                </a>

            @endif


            @if(Route::has('cart.index'))

                <a
                    class="quick-card"
                    href="{{ route('cart.index') }}"
                >

                    <div class="quick-icon">

                        <i class="fa-solid fa-cart-shopping"></i>

                    </div>

                    <strong>
                        Shopping Cart
                    </strong>

                    <span>
                        Review your basket
                    </span>

                </a>

            @endif

        </section>


        {{-- =====================================================
             SUCCESS
        ====================================================== --}}

        @if(session('success'))

            <div class="alert success-alert mb-4">

                <i class="fa-solid fa-circle-check me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        {{-- =====================================================
             ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div class="alert alert-danger rounded-4 mb-4">

                <strong>
                    Please fix the following:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =====================================================
             SETTINGS FORM
        ====================================================== --}}

        <form
            method="POST"
            action="{{ route('settings.update') }}"
            id="customerSettingsForm"
        >

            @csrf

            @method('PUT')


            {{-- =================================================
                 APPEARANCE
            ================================================== --}}

            <div
                class="settings-card"
                id="appearanceSettings"
            >

                <div class="settings-card-header">

                    <div class="settings-icon">

                        <i class="fa-solid fa-palette"></i>

                    </div>


                    <div>

                        <h2 class="settings-card-title">
                            Appearance & Theme
                        </h2>

                        <p class="settings-card-description">
                            Choose your preferred Smart Basket interface.
                        </p>

                    </div>

                </div>


                <div class="theme-options">


                    {{-- LIGHT --}}

                    <div class="theme-option">

                        <input
                            type="radio"
                            name="dark_mode"
                            id="themeLight"
                            value="light"
                            {{ $currentTheme === 'light' ? 'checked' : '' }}
                        >

                        <label
                            for="themeLight"
                            class="theme-label"
                        >

                            <i class="fa-solid fa-sun"></i>

                            <span>
                                Light Mode
                            </span>

                            <small>
                                Clean & bright
                            </small>

                        </label>

                    </div>


                    {{-- DARK --}}

                    <div class="theme-option">

                        <input
                            type="radio"
                            name="dark_mode"
                            id="themeDark"
                            value="dark"
                            {{ $currentTheme === 'dark' ? 'checked' : '' }}
                        >

                        <label
                            for="themeDark"
                            class="theme-label"
                        >

                            <i class="fa-solid fa-moon"></i>

                            <span>
                                Dark Mode
                            </span>

                            <small>
                                Premium night UI
                            </small>

                        </label>

                    </div>


                    {{-- SYSTEM --}}

                    <div class="theme-option">

                        <input
                            type="radio"
                            name="dark_mode"
                            id="themeSystem"
                            value="system"
                            {{ $currentTheme === 'system' ? 'checked' : '' }}
                        >

                        <label
                            for="themeSystem"
                            class="theme-label"
                        >

                            <i class="fa-solid fa-desktop"></i>

                            <span>
                                System
                            </span>

                            <small>
                                Follow device theme
                            </small>

                        </label>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 GENERAL
            ================================================== --}}

            <div
                class="settings-card"
                id="generalSettings"
            >

                <div class="settings-card-header">

                    <div class="settings-icon">

                        <i class="fa-solid fa-sliders"></i>

                    </div>


                    <div>

                        <h2 class="settings-card-title">
                            General Preferences
                        </h2>

                        <p class="settings-card-description">
                            Manage language and notification preferences.
                        </p>

                    </div>

                </div>


                {{-- LANGUAGE --}}

                <div class="setting-row">

                    <div class="setting-info">

                        <div class="setting-small-icon">

                            <i class="fa-solid fa-language"></i>

                        </div>


                        <div>

                            <div class="setting-name">
                                Language
                            </div>

                            <div class="setting-description">
                                Select your preferred language.
                            </div>

                        </div>

                    </div>


                    <select
                        name="language"
                        class="form-select premium-select"
                        id="languageSelect"
                        aria-label="Preferred language"
                    >

                        @forelse($languages as $code => $meta)

                            @php

                                $meta =
                                    is_array($meta)
                                        ? $meta
                                        : [
                                            'name' =>
                                                (string) $meta,
                                            'native' =>
                                                (string) $meta
                                        ];

                                $label =
                                    $meta['native']
                                    ?? (
                                        $meta['name']
                                        ?? $code
                                    );

                                $name =
                                    $meta['name']
                                    ?? $code;

                            @endphp

                            <option
                                value="{{ $code }}"
                                {{ (string) $currentLanguage === (string) $code ? 'selected' : '' }}
                            >

                                {{ $label }}

                                {{
                                    $name !== $label
                                        ? ' — ' . $name
                                        : ''
                                }}

                            </option>

                        @empty

                            <option
                                value="en"
                                {{ $currentLanguage === 'en' ? 'selected' : '' }}
                            >
                                English
                            </option>

                            <option
                                value="hi"
                                {{ $currentLanguage === 'hi' ? 'selected' : '' }}
                            >
                                हिन्दी
                            </option>

                            <option
                                value="gu"
                                {{ $currentLanguage === 'gu' ? 'selected' : '' }}
                            >
                                ગુજરાતી
                            </option>

                        @endforelse

                    </select>

                </div>


                {{-- NOTIFICATIONS --}}

                <div class="setting-row">

                    <div class="setting-info">

                        <div class="setting-small-icon">

                            <i class="fa-solid fa-bell"></i>

                        </div>


                        <div>

                            <div class="setting-name">
                                Notifications
                            </div>

                            <div class="setting-description">
                                Receive order and account notifications.
                            </div>

                        </div>

                    </div>


                    <div class="form-check form-switch premium-switch">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="notificationSwitch"
                            {{ $notifications === 'enabled' ? 'checked' : '' }}
                        >


                        <input
                            type="hidden"
                            name="notifications"
                            id="notificationValue"
                            value="{{ $notifications === 'enabled' ? 'enabled' : 'disabled' }}"
                        >

                    </div>

                </div>

            </div>


            {{-- =================================================
                 LIVE PREVIEW
            ================================================== --}}

            <div
                class="settings-card"
                id="previewSettings"
            >

                <div class="settings-card-header">

                    <div class="settings-icon">

                        <i class="fa-solid fa-eye"></i>

                    </div>


                    <div>

                        <h2 class="settings-card-title">
                            Live Preview
                        </h2>

                        <p class="settings-card-description">
                            See how your selected theme looks instantly.
                        </p>

                    </div>

                </div>


                <div class="preview-box">

                    <div class="preview-top">

                        <strong>

                            <i class="fa-solid fa-basket-shopping me-2"></i>

                            Smart Basket

                        </strong>


                        <span class="preview-dot"></span>

                    </div>


                    <div class="preview-content">

                        <div class="d-flex justify-content-between align-items-center">

                            <span class="fw-bold">
                                Premium Product
                            </span>


                            <span
                                style="color:var(--sb-primary)"
                                class="fw-bold"
                            >
                                ₹999
                            </span>

                        </div>


                        <small
                            style="color:var(--sb-text-secondary)"
                        >

                            Your selected appearance is applied instantly.

                        </small>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 SECURITY
            ================================================== --}}

            <div
                class="settings-card"
                id="securitySettings"
            >

                <div class="settings-card-header">

                    <div class="settings-icon">

                        <i class="fa-solid fa-shield-halved"></i>

                    </div>


                    <div>

                        <h2 class="settings-card-title">
                            Security Center
                        </h2>

                        <p class="settings-card-description">
                            Manage your Smart Basket account protection.
                        </p>

                    </div>

                </div>


                <div class="setting-row">

                    <div class="setting-info">

                        <div class="setting-small-icon">

                            <i class="fa-solid fa-lock"></i>

                        </div>


                        <div>

                            <div class="setting-name">
                                Security PIN
                            </div>

                            <div class="setting-description">
                                Protect your account with a security PIN.
                            </div>

                        </div>

                    </div>


                    {{-- SECURITY MANAGE BUTTON --}}

                    @if(Route::has('security.manage.page'))

                        <a
                            href="{{ route('security.manage.page') }}"
                            class="btn btn-outline-primary premium-btn px-4"
                        >

                            <i class="fa-solid fa-shield me-2"></i>

                            Manage

                        </a>

                    @else

                        <button
                            type="button"
                            class="btn btn-outline-secondary premium-btn px-4"
                            disabled
                        >

                            <i class="fa-solid fa-lock me-2"></i>

                            Manage

                        </button>

                    @endif

                </div>

            </div>


            {{-- =================================================
                 SAVE
            ================================================== --}}

            <div class="save-area">

                <div class="save-bar">

                    <div>

                        <strong>

                            <i class="fa-solid fa-gear me-2"></i>

                            Settings

                        </strong>


                        <div
                            class="small"
                            style="color:var(--sb-text-secondary)"
                        >

                            Your preferences are saved to your account.

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="btn save-btn"
                        id="saveSettingsButton"
                    >

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Save Settings

                    </button>

                </div>

            </div>

        </form>

        {{-- Read-only, database-backed About information --}}
        <section class="settings-card" id="aboutSmartBasket" aria-labelledby="aboutSmartBasketTitle">
            <div class="settings-card-header">
                <div class="settings-icon"><i class="fa-solid fa-circle-info"></i></div>
                <div>
                    <h2 class="settings-card-title" id="aboutSmartBasketTitle">{{ $aboutContent?->title ?: 'About Smart Basket' }}</h2>
                    <p class="settings-card-description">Learn more about our store and what we offer.</p>
                </div>
            </div>

            @php
                $aboutSections = [
                    'About Smart Basket' => $aboutContent?->introduction,
                    'Our mission' => $aboutContent?->mission,
                    'Our vision' => $aboutContent?->vision,
                    'Our services' => $aboutContent?->services,
                    'Additional information' => $aboutContent?->additional_information,
                ];
                $hasAboutContent = collect($aboutSections)->contains(fn ($content) => filled($content));
            @endphp

            @if($hasAboutContent)
                @foreach($aboutSections as $heading => $content)
                    @if(filled($content))
                        <div style="padding:14px 0;border-bottom:1px solid var(--sb-border);">
                            <h3 style="margin:0 0 7px;color:var(--sb-text);font-size:15px;font-weight:800;">{{ $heading }}</h3>
                            <div style="color:var(--sb-text-secondary);line-height:1.75;white-space:normal;">{!! nl2br(e($content)) !!}</div>
                        </div>
                    @endif
                @endforeach
            @else
                <p style="margin:0;color:var(--sb-text-secondary);">About information will be available here soon.</p>
            @endif
        </section>

    </div>

</div>


{{-- =========================================================
     SETTINGS JAVASCRIPT
========================================================= --}}

<script>

    /* =========================================================
       THEME
    ========================================================== */

    function getSystemTheme() {

        if (
            window.matchMedia &&
            window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches
        ) {

            return 'dark';

        }

        return 'light';
    }


    function applyCustomerTheme(
        selectedTheme,
        saveLocal = true
    ) {

        let actualTheme =
            selectedTheme;


        if (selectedTheme === 'system') {

            actualTheme =
                getSystemTheme();

        }


        if (
            !['light', 'dark'].includes(actualTheme)
        ) {

            actualTheme =
                'light';

        }


        document.documentElement.dataset.sbTheme =
            actualTheme;

        document.documentElement.dataset.theme =
            actualTheme;

        document.body.dataset.sbTheme =
            actualTheme;

        document.documentElement.dataset.sbSelectedTheme =
            selectedTheme;


        if (saveLocal) {

            localStorage.setItem(
                'sb-theme',
                selectedTheme
            );

        }

    }


    /* =========================================================
       THEME RADIO
    ========================================================== */

    const themeInputs =
        document.querySelectorAll(
            'input[name="dark_mode"]'
        );


    themeInputs.forEach(
        input => {

            input.addEventListener(
                'change',
                function () {

                    if (!this.checked) {
                        return;
                    }

                    applyCustomerTheme(
                        this.value,
                        true
                    );

                }
            );

        }
    );


    /* =========================================================
       INITIAL THEME
    ========================================================== */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const serverTheme =
                @json($currentTheme);

            const localTheme =
                localStorage.getItem(
                    'sb-theme'
                );

            const selectedTheme =
                localTheme &&
                ['light', 'dark', 'system']
                    .includes(localTheme)
                    ? localTheme
                    : serverTheme;


            const selectedRadio =
                document.querySelector(
                    'input[name="dark_mode"][value="' +
                    selectedTheme +
                    '"]'
                );


            if (selectedRadio) {

                selectedRadio.checked =
                    true;

            }


            applyCustomerTheme(
                selectedTheme,
                false
            );

        }
    );


    /* =========================================================
       SYSTEM THEME CHANGE
    ========================================================== */

    if (window.matchMedia) {

        const systemMedia =
            window.matchMedia(
                '(prefers-color-scheme: dark)'
            );


        const updateSystemTheme =
            () => {

                const systemRadio =
                    document.getElementById(
                        'themeSystem'
                    );


                if (
                    systemRadio &&
                    systemRadio.checked
                ) {

                    applyCustomerTheme(
                        'system',
                        false
                    );

                }

            };


        if (systemMedia.addEventListener) {

            systemMedia.addEventListener(
                'change',
                updateSystemTheme
            );

        } else {

            systemMedia.addListener(
                updateSystemTheme
            );

        }

    }


    /* =========================================================
       NOTIFICATION SWITCH
    ========================================================== */

    const notificationSwitch =
        document.getElementById(
            'notificationSwitch'
        );


    const notificationValue =
        document.getElementById(
            'notificationValue'
        );


    if (
        notificationSwitch &&
        notificationValue
    ) {

        notificationSwitch.addEventListener(
            'change',
            function () {

                notificationValue.value =
                    this.checked
                        ? 'enabled'
                        : 'disabled';

            }
        );

    }


    /* =========================================================
       DIRTY STATE
    ========================================================== */

    const form =
        document.getElementById(
            'customerSettingsForm'
        );

    const settingsPage =
        document.querySelector(
            '.settings-page'
        );

    const saveButton =
        document.getElementById(
            'saveSettingsButton'
        );


    function markSettingsDirty() {

        if (settingsPage) {

            settingsPage.classList.add(
                'is-dirty'
            );

        }

    }


    document
        .querySelectorAll(
            '#customerSettingsForm input, #customerSettingsForm select'
        )
        .forEach(
            control => {

                control.addEventListener(
                    'change',
                    markSettingsDirty
                );

            }
        );


    window.addEventListener(
        'pageshow',
        function () {

            if (settingsPage) {

                settingsPage.classList.remove(
                    'is-dirty'
                );

            }

        }
    );


    /* =========================================================
       SAVE FORM
    ========================================================== */

    if (form) {

        form.addEventListener(
            'submit',
            function () {

                const selectedTheme =
                    document.querySelector(
                        'input[name="dark_mode"]:checked'
                    );


                if (selectedTheme) {

                    localStorage.setItem(
                        'sb-theme',
                        selectedTheme.value
                    );

                }


                if (saveButton) {

                    saveButton.innerHTML =
                        '<i class="fa-solid fa-spinner fa-spin me-2"></i> Saving...';

                    saveButton.disabled =
                        true;

                }

            }
        );

    }

</script>


{{-- =========================================================
     CUSTOMER TASKBAR JAVASCRIPT
========================================================= --}}




<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>
