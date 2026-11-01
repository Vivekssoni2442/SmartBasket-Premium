<!DOCTYPE html>
<html lang="en" class="admin-shell">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'SmartBasket Admin') — Admin Control Center
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        rel="stylesheet"
    >

    @php
        /*
        |--------------------------------------------------------------------------
        | Safe Admin Data
        |--------------------------------------------------------------------------
        */

        $adminDisplayName = trim((string) session('admin_name', 'Administrator'));

        if ($adminDisplayName === '') {
            $adminDisplayName = 'Administrator';
        }

        $adminInitials = collect(
            preg_split('/\s+/', $adminDisplayName, -1, PREG_SPLIT_NO_EMPTY)
        )
        ->take(2)
        ->map(function ($part) {
            return strtoupper(substr($part, 0, 1));
        })
        ->implode('');

        if ($adminInitials === '') {
            $adminInitials = 'A';
        }

        $currentAdminProfile = null;
        $adminAvatarUrl = null;

        try {
            if (session()->filled('admin_id')) {
                $currentAdminProfile = \App\Models\Admin::find(session('admin_id'));
            }

            if (filled($currentAdminProfile?->avatar)) {
                $adminAvatarPath = 'admin-avatars/' . basename($currentAdminProfile->avatar);
                $adminAvatarUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($adminAvatarPath);
            }
        } catch (\Throwable $e) {
            $currentAdminProfile = null;
            $adminAvatarUrl = null;
        }

        $adminBreadcrumbText = trim(strip_tags($__env->yieldContent('breadcrumbs')));
        $adminBreadcrumbLabels = collect(preg_split('/\s*\/\s*/', $adminBreadcrumbText))
            ->map(fn ($label) => trim(html_entity_decode($label)))
            ->filter()
            ->values();

        if ($adminBreadcrumbLabels->isEmpty()) {
            $adminRouteName = preg_replace('/^admin\./', '', (string) (request()->route()?->getName() ?? ''));
            $adminRouteParts = explode('.', $adminRouteName);

            if (in_array(end($adminRouteParts), ['index', 'show', 'edit', 'create', 'store', 'update', 'destroy'], true)) {
                array_pop($adminRouteParts);
            }

            $adminBreadcrumbLabels = collect([\Illuminate\Support\Str::headline(implode(' ', $adminRouteParts))])
                ->filter();
        }

        /*
        |--------------------------------------------------------------------------
        | Safe Pending KYC Count
        |--------------------------------------------------------------------------
        */

        $pendingCount = 0;

        try {

            $pendingCount = \App\Models\SellerProfile::whereIn(
                'verification_status',
                [
                    \App\Models\SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
                    \App\Models\SellerProfile::STATUS_UNDER_REVIEW,
                ]
            )->count();

        } catch (\Throwable $e) {

            $pendingCount = 0;

        }
    @endphp


    <style>

        /* =========================================================
           SMARTBASKET PREMIUM ADMIN CONTROL CENTER
           STABLE MASTER LAYOUT
        ========================================================= */

        :root {

            --gold: #f5b91b;
            --gold-light: #ffd866;
            --gold-dark: #b57b00;
            --gold-soft: rgba(245,185,27,.12);

            --navy: #07111f;
            --navy-2: #0b1728;
            --navy-3: #101d30;

            --bg: #f3f6fa;
            --surface: #ffffff;
            --surface-2: #f8fafc;

            --text: #101828;
            --text-2: #1d2939;
            --text-3: #344054;

            --muted: #667085;
            --muted-2: #98a2b3;

            --border: #e4e7ec;
            --border-soft: #edf0f4;

            --green: #12b76a;
            --green-soft: #ecfdf3;

            --red: #f04438;
            --red-soft: #fef3f2;

            --orange: #f79009;
            --orange-soft: #fffaeb;

            --blue: #2e90fa;
            --blue-soft: #eff8ff;

            --purple: #7f56d9;
            --purple-soft: #f9f5ff;

            --sidebar-width: 278px;
            --topbar-height: 76px;

            --radius-xl: 22px;
            --radius-lg: 18px;
            --radius-md: 14px;
            --radius-sm: 10px;

            --shadow-xs: 0 1px 2px rgba(16,24,40,.04);
            --shadow-sm: 0 8px 24px rgba(16,24,40,.055);
            --shadow-md: 0 18px 45px rgba(16,24,40,.09);
            --shadow-lg: 0 28px 80px rgba(16,24,40,.16);

            --transition: .24s cubic-bezier(.4,0,.2,1);
        }


        /* =========================================================
           RESET
        ========================================================= */

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {

            min-height: 100vh;

            color: var(--text);

            font-family: 'Inter', sans-serif;

            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(245,185,27,.10),
                    transparent 25%
                ),
                radial-gradient(
                    circle at 100% 0%,
                    rgba(127,86,217,.07),
                    transparent 22%
                ),
                linear-gradient(
                    135deg,
                    #f8fafc 0%,
                    #f3f6fa 55%,
                    #eef2f7 100%
                );

            overflow-x: hidden;
        }

        body::before {

            content: "";

            position: fixed;

            inset: 0;

            pointer-events: none;

            z-index: -1;

            opacity: .42;

            background-image:
                linear-gradient(
                    rgba(15,23,42,.018) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(15,23,42,.018) 1px,
                    transparent 1px
                );

            background-size: 42px 42px;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }

        button {
            outline: none;
        }

        a {
            color: inherit;
        }

        img {
            max-width: 100%;
        }

        ::selection {
            background: rgba(245,185,27,.25);
        }

        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-track {
            background: #eef1f5;
        }

        ::-webkit-scrollbar-thumb {
            background: #c6ccd5;
            border-radius: 99px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #aeb6c2;
        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .admin-sidebar {

            position: fixed;

            top: 0;
            left: 0;
            bottom: 0;

            width: var(--sidebar-width);

            color: #d9e2ef;

            background:
                radial-gradient(
                    circle at 80% -5%,
                    rgba(245,185,27,.13),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 10% 80%,
                    rgba(46,144,250,.07),
                    transparent 25%
                ),
                linear-gradient(
                    180deg,
                    #081322 0%,
                    #07111f 48%,
                    #050c16 100%
                );

            border-right: 1px solid rgba(255,255,255,.075);

            box-shadow: 15px 0 55px rgba(0,0,0,.16);

            z-index: 1200;

            overflow-y: auto;

            transition:
                transform var(--transition);
        }

        .admin-sidebar::before {

            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            right: -90px;
            top: 130px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(245,185,27,.07),
                    transparent 70%
                );

            pointer-events: none;
        }


        /* =========================================================
           BRAND
        ========================================================= */

        .admin-sidebar-header {

            height: var(--topbar-height);

            padding: 0 18px;

            display: flex;

            align-items: center;

            position: sticky;

            top: 0;

            background:
                rgba(7,17,31,.92);

            border-bottom:
                1px solid rgba(255,255,255,.07);

            backdrop-filter: blur(18px);

            z-index: 5;
        }

        .admin-brand {

            width: 100%;

            display: flex;

            align-items: center;

            gap: 11px;

            text-decoration: none;
        }

        .admin-logo {

            position: relative;

            width: 45px;
            height: 45px;

            flex-shrink: 0;

            display: grid;

            place-items: center;

            border-radius: 14px;

            background:
                linear-gradient(
                    145deg,
                    #ffe78b,
                    #f5b91b 62%,
                    #c98b00
                );

            color: #352600;

            font-size: 17px;

            box-shadow:
                0 9px 28px rgba(245,185,27,.20),
                inset 0 1px 0 rgba(255,255,255,.8);
        }

        .admin-logo::after {

            content: "";

            position: absolute;

            inset: 3px;

            border-radius: 11px;

            border:
                1px solid rgba(255,255,255,.35);
        }

        .admin-logo-text {

            color: #f8fafc;

            font-family: 'Poppins', sans-serif;

            font-size: 15px;

            line-height: 1;

            font-weight: 800;

            letter-spacing: .7px;
        }

        .admin-logo-text span {
            color: var(--gold);
        }

        .admin-logo-subtitle {

            margin-top: 5px;

            color: #748398;

            font-size: 7.5px;

            font-weight: 800;

            letter-spacing: 1.15px;
        }


        /* =========================================================
           SIDEBAR MENU
        ========================================================= */

        .admin-sidebar-menu {

            position: relative;

            padding: 13px 11px 30px;

            list-style: none;
        }

        .admin-sidebar-section {
            padding: 7px 0;
        }

        .admin-sidebar-section + .admin-sidebar-section {
            border-top:
                1px solid rgba(255,255,255,.045);
        }

        .admin-sidebar-section-title {

            padding:
                11px
                12px
                7px;

            display: flex;

            align-items: center;

            gap: 8px;

            color: #64748b;

            font-size: 8px;

            font-weight: 800;

            letter-spacing: 1.15px;

            text-transform: uppercase;
        }

        .admin-sidebar-section-title i {

            width: 15px;

            color: rgba(245,185,27,.72);

            font-size: 8px;
        }

        .admin-sidebar-item {
            margin: 2px 0;
        }

        .admin-sidebar-link {

            position: relative;

            min-height: 43px;

            padding: 9px 12px;

            display: flex;

            align-items: center;

            gap: 11px;

            border:
                1px solid transparent;

            border-radius: 12px;

            color: #8795a8;

            text-decoration: none;

            font-size: 10.5px;

            font-weight: 600;

            transition: all var(--transition);
        }

        .admin-sidebar-link i {

            width: 19px;

            text-align: center;

            color: #627186;

            font-size: 12.5px;

            transition: all var(--transition);
        }

        .admin-sidebar-link span {
            line-height: 1.2;
        }

        .admin-sidebar-link:hover {

            color: #f4f7fb;

            background:
                linear-gradient(
                    90deg,
                    rgba(255,255,255,.065),
                    rgba(255,255,255,.025)
                );

            border-color:
                rgba(255,255,255,.07);

            transform: translateX(2px);
        }

        .admin-sidebar-link:hover i {
            color: var(--gold);
        }

        .admin-sidebar-link.active {

            color: #ffe9a2;

            background:
                linear-gradient(
                    100deg,
                    rgba(245,185,27,.18),
                    rgba(245,185,27,.055)
                );

            border-color:
                rgba(245,185,27,.22);

            box-shadow:
                inset 0 1px 0 rgba(255,255,255,.035),
                0 9px 25px rgba(0,0,0,.13);
        }

        .admin-sidebar-link.active::before {

            content: "";

            position: absolute;

            left: -11px;

            top: 7px;
            bottom: 7px;

            width: 3px;

            border-radius:
                0 6px 6px 0;

            background:
                linear-gradient(
                    180deg,
                    #ffe17b,
                    #d99d00
                );

            box-shadow:
                0 0 12px rgba(245,185,27,.38);
        }

        .admin-sidebar-link.active i {
            color: var(--gold);
        }

        .admin-sidebar-badge {

            margin-left: auto;

            min-width: 23px;

            height: 19px;

            padding: 0 6px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            border-radius: 99px;

            background:
                rgba(240,68,56,.13);

            color: #ff8b82;

            border:
                1px solid rgba(240,68,56,.23);

            font-size: 7.5px;

            font-weight: 800;
        }


        /* =========================================================
           SIDEBAR FOOTER
        ========================================================= */

        .admin-sidebar-footer {

            margin: 8px 11px 20px;

            padding: 13px;

            border:
                1px solid rgba(255,255,255,.07);

            border-radius: 15px;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.055),
                    rgba(255,255,255,.018)
                );
        }

        .admin-sidebar-footer-top {

            display: flex;

            align-items: center;

            gap: 9px;
        }

        .admin-sidebar-footer-icon {

            width: 31px;
            height: 31px;

            display: grid;

            place-items: center;

            border-radius: 9px;

            background:
                rgba(245,185,27,.12);

            color: var(--gold);

            font-size: 11px;
        }

        .admin-sidebar-footer strong {

            display: block;

            color: #e9eef5;

            font-size: 9px;
        }

        .admin-sidebar-footer span {

            display: block;

            margin-top: 3px;

            color: #65758b;

            font-size: 7.5px;
        }

        .admin-sidebar-footer-status {

            margin-top: 11px;

            height: 5px;

            overflow: hidden;

            border-radius: 99px;

            background: rgba(255,255,255,.07);
        }

        .admin-sidebar-footer-status div {

            width: 96%;

            height: 100%;

            border-radius: inherit;

            background:
                linear-gradient(
                    90deg,
                    #f0b90b,
                    #ffe18a
                );
        }


        /* =========================================================
           MAIN
        ========================================================= */

        .admin-main {

            min-height: 100vh;

            margin-left: var(--sidebar-width);

            display: flex;

            flex-direction: column;
        }


        /* =========================================================
           TOPBAR
        ========================================================= */

        .admin-topbar {

            position: sticky;

            top: 0;

            min-height: var(--topbar-height);

            padding: 0 27px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            background:
                rgba(255,255,255,.80);

            border-bottom:
                1px solid rgba(228,231,236,.88);

            backdrop-filter: blur(22px);

            -webkit-backdrop-filter: blur(22px);

            z-index: 1000;
        }

        .admin-topbar-left,
        .admin-topbar-right {

            display: flex;

            align-items: center;
        }

        .admin-topbar-left {
            gap: 14px;
            min-width: 0;
        }

        .admin-topbar-right {
            gap: 9px;
        }


        /* =========================================================
           MOBILE
        ========================================================= */

        .admin-menu-toggle {

            width: 40px;
            height: 40px;

            display: none;

            place-items: center;

            border:
                1px solid var(--border);

            border-radius: 11px;

            background: #fff;

            color: #475467;

            cursor: pointer;

            transition: all var(--transition);
        }

        .admin-menu-toggle:hover {

            color: var(--gold-dark);

            border-color: #ecd47b;

            background: #fffdf7;

            transform: translateY(-1px);
        }


        /* =========================================================
           BREADCRUMBS
        ========================================================= */

        .admin-breadcrumbs {

            display: flex;

            align-items: center;

            gap: 9px;

            min-width: 0;

            color: #98a2b3;

            font-size: 10px;

            font-weight: 600;
        }

        .admin-breadcrumbs a {

            color: #a97600;

            text-decoration: none;

            white-space: nowrap;
        }

        .admin-breadcrumbs span {
            color: #c3c8d0;
        }


        /* =========================================================
           SEARCH
        ========================================================= */

        .admin-top-search {

            width: 245px;

            height: 40px;

            display: flex;

            align-items: center;

            gap: 9px;

            padding: 0 12px;

            border:
                1px solid var(--border);

            border-radius: 12px;

            background:
                linear-gradient(
                    180deg,
                    #ffffff,
                    #f8fafc
                );

            color: #98a2b3;

            box-shadow:
                inset 0 1px 0 rgba(255,255,255,.8);
        }

        .admin-top-search i {
            font-size: 11px;
        }

        .admin-top-search span {

            color: #98a2b3;

            font-size: 9px;

            font-weight: 600;
        }

        .admin-top-search kbd {

            margin-left: auto;

            padding: 3px 6px;

            border:
                1px solid #dfe3e8;

            border-radius: 5px;

            background: #fff;

            color: #98a2b3;

            font-size: 7px;

            font-weight: 700;
        }


        /* =========================================================
           TOP ICON
        ========================================================= */

        .admin-topbar-icon {

            position: relative;

            width: 40px;
            height: 40px;

            display: grid;

            place-items: center;

            border:
                1px solid var(--border);

            border-radius: 12px;

            background:
                linear-gradient(
                    180deg,
                    #ffffff,
                    #fafbfc
                );

            color: #667085;

            cursor: pointer;

            transition: all var(--transition);

            box-shadow:
                var(--shadow-xs);
        }

        .admin-topbar-icon:hover {

            color: var(--gold-dark);

            border-color: #ecd47b;

            background: #fffdf7;

            transform: translateY(-2px);

            box-shadow: var(--shadow-sm);
        }

        .admin-notification-badge {

            position: absolute;

            top: -4px;
            right: -4px;

            min-width: 17px;
            height: 17px;

            display: grid;

            place-items: center;

            border-radius: 50%;

            background: var(--red);

            color: #fff;

            border:
                2px solid #fff;

            font-size: 7px;

            font-weight: 800;

            box-shadow:
                0 3px 10px rgba(240,68,56,.28);
        }


        /* =========================================================
           NOTIFICATIONS
        ========================================================= */

        .admin-notification-wrap {
            position: relative;
        }

        .admin-notification-dropdown {

            position: absolute;

            top: calc(100% + 11px);

            right: 0;

            width: 330px;

            display: none;

            overflow: hidden;

            background: #fff;

            border:
                1px solid var(--border);

            border-radius: 17px;

            box-shadow: var(--shadow-lg);

            animation: dropdownIn .18s ease;

            z-index: 2000;
        }

        .admin-notification-dropdown.active {
            display: block;
        }

        .admin-notification-header {

            padding: 15px 16px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            background:
                linear-gradient(
                    135deg,
                    #fffdf7,
                    #ffffff
                );

            border-bottom:
                1px solid var(--border-soft);
        }

        .admin-notification-header strong {

            color: var(--text-2);

            font-size: 11px;
        }

        .admin-notification-header span {

            color: var(--muted);

            font-size: 8px;
        }

        .admin-notification-empty {

            padding: 34px 18px;

            text-align: center;

            color: var(--muted);
        }

        .admin-notification-empty i {

            width: 45px;
            height: 45px;

            margin: 0 auto 11px;

            display: grid;

            place-items: center;

            border-radius: 13px;

            background: var(--gold-soft);

            color: var(--gold-dark);
        }

        .admin-notification-empty strong {

            display: block;

            margin-bottom: 4px;

            color: var(--text-2);

            font-size: 10.5px;
        }

        .admin-notification-empty span {

            font-size: 8.5px;

            line-height: 1.55;
        }


        /* =========================================================
           PROFILE
        ========================================================= */

        .admin-topbar-item {
            position: relative;
        }

        .admin-profile-menu {

            position: relative;

            display: flex;

            align-items: center;

            gap: 9px;

            padding: 5px 8px 5px 5px;

            border:
                1px solid transparent;

            border-radius: 13px;

            cursor: pointer;

            transition: all var(--transition);
        }

        .admin-profile-menu:hover,
        .admin-profile-menu.open {

            background:
                rgba(255,255,255,.92);

            border-color: var(--border);

            box-shadow: var(--shadow-xs);
        }

        .admin-profile-avatar {

            width: 40px;
            height: 40px;

            display: grid;

            place-items: center;

            border-radius: 12px;

            background:
                linear-gradient(
                    145deg,
                    #ffe78b,
                    #f5b91b 65%,
                    #d79c00
                );

            color: #392900;

            font-size: 12px;

            font-weight: 800;

            box-shadow:
                0 7px 20px rgba(245,185,27,.18);
        }

        .admin-profile-info {

            display: flex;

            flex-direction: column;

            gap: 2px;
        }

        .admin-profile-name {

            max-width: 150px;

            overflow: hidden;

            text-overflow: ellipsis;

            white-space: nowrap;

            color: #1d2939;

            font-size: 10.5px;

            font-weight: 700;
        }

        .admin-profile-role {

            display: flex;

            align-items: center;

            gap: 5px;

            color: #98a2b3;

            font-size: 8px;

            font-weight: 600;
        }

        .admin-online-dot {

            width: 6px;
            height: 6px;

            border-radius: 50%;

            background: var(--green);

            box-shadow:
                0 0 0 3px rgba(18,183,106,.10);
        }

        .admin-profile-chevron {

            color: #98a2b3;

            font-size: 8px;

            transition: transform var(--transition);
        }

        .admin-profile-menu.open
        .admin-profile-chevron {

            transform: rotate(180deg);
        }


        /* =========================================================
           PROFILE DROPDOWN
        ========================================================= */

        .admin-profile-dropdown {

            position: absolute;

            top: calc(100% + 10px);

            right: 0;

            width: 275px;

            padding: 7px;

            display: none;

            flex-direction: column;

            gap: 2px;

            background:
                rgba(255,255,255,.98);

            border:
                1px solid var(--border);

            border-radius: 17px;

            box-shadow: var(--shadow-lg);

            animation: dropdownIn .18s ease;

            z-index: 2000;
        }

        .admin-profile-dropdown.active {
            display: flex;
        }

        @keyframes dropdownIn {

            from {
                opacity: 0;
                transform:
                    translateY(-7px)
                    scale(.98);
            }

            to {
                opacity: 1;
                transform:
                    translateY(0)
                    scale(1);
            }
        }

        .admin-profile-dropdown-header {

            padding: 14px;

            margin-bottom: 4px;

            border-radius: 12px;

            background:
                radial-gradient(
                    circle at 100% 0%,
                    rgba(245,185,27,.16),
                    transparent 42%
                ),
                linear-gradient(
                    135deg,
                    #fffaf0,
                    #ffffff
                );

            border:
                1px solid #f3e5b5;
        }

        .admin-profile-dropdown-header-row {

            display: flex;

            align-items: center;

            gap: 10px;
        }

        .admin-mini-avatar {

            width: 37px;
            height: 37px;

            flex-shrink: 0;

            display: grid;

            place-items: center;

            border-radius: 11px;

            background:
                linear-gradient(
                    145deg,
                    #ffe78b,
                    #f5b91b
                );

            color: #392900;

            font-size: 10px;

            font-weight: 800;
        }

        .admin-profile-dropdown-header strong {

            display: block;

            color: #1d2939;

            font-size: 10.5px;
        }

        .admin-profile-dropdown-header span {

            display: block;

            margin-top: 3px;

            color: #98a2b3;

            font-size: 8px;
        }

        .admin-profile-dropdown-item {

            width: 100%;

            padding: 10px 11px;

            display: flex;

            align-items: center;

            gap: 10px;

            border: 0;

            border-radius: 10px;

            background: transparent;

            color: #475467;

            text-decoration: none;

            text-align: left;

            font-size: 10px;

            font-weight: 600;

            cursor: pointer;

            transition: all var(--transition);
        }

        .admin-profile-dropdown-item i {

            width: 17px;

            color: #98a2b3;

            transition: color var(--transition);
        }

        .admin-profile-dropdown-item:hover {

            color: #8b6500;

            background:
                linear-gradient(
                    90deg,
                    #fff8e2,
                    #fffdf8
                );
        }

        .admin-profile-dropdown-item:hover i {
            color: #d39d00;
        }

        .admin-profile-divider {

            height: 1px;

            margin: 5px 4px;

            background: #eef0f3;
        }

        .admin-logout-form {
            margin: 0;
        }

        .admin-logout-form button {
            color: #475467;
        }

        .admin-logout-form button:hover {

            color: var(--red);

            background: var(--red-soft);
        }

        .admin-logout-form button:hover i {
            color: var(--red);
        }


        /* =========================================================
           CONTENT
        ========================================================= */

        .admin-content {

            width: 100%;

            max-width: 1920px;

            margin: 0 auto;

            flex: 1;

            padding: 30px;

            animation:
                contentIn .32s ease;
        }

        @keyframes contentIn {

            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        /* =========================================================
           PAGE HEADER
        ========================================================= */

        .admin-page-header {

            width: 100%;

            max-width: none;

            margin-bottom: 23px;

            display: flex;

            align-items: flex-end;

            justify-content: space-between;

            gap: 20px;
        }

        .admin-page-title {

            color: #101828;

            font-family: 'Poppins', sans-serif;

            font-size: 28px;

            line-height: 1.25;

            font-weight: 800;

            letter-spacing: -.7px;
        }

        .admin-page-title i {

            margin-right: 7px;

            color: #d09a00;
        }

        .admin-page-description,
        .admin-page-subtitle {

            margin-top: 6px;

            color: #667085;

            font-size: 10.5px;

            line-height: 1.65;
        }


        /* =========================================================
           PAGE ACTIONS
        ========================================================= */

        .admin-page-actions {

            display: flex;

            align-items: center;

            flex-wrap: wrap;

            gap: 8px;
        }


        /* =========================================================
           CARDS
        ========================================================= */

        .admin-card {

            position: relative;

            padding: 21px;

            overflow: hidden;

            background:
                rgba(255,255,255,.96);

            border:
                1px solid rgba(228,231,236,.9);

            border-radius: var(--radius-lg);

            box-shadow: var(--shadow-sm);

            transition:
                box-shadow var(--transition),
                border-color var(--transition),
                transform var(--transition);
        }

        .admin-card::before {

            content: "";

            position: absolute;

            top: 0;
            left: 0;

            width: 100%;

            height: 2px;

            opacity: 0;

            background:
                linear-gradient(
                    90deg,
                    #f5b91b,
                    #ffe38a,
                    transparent
                );

            transition: opacity var(--transition);
        }

        .admin-card:hover {

            border-color: #dfe4ec;

            box-shadow: var(--shadow-md);

            transform: translateY(-2px);
        }

        .admin-card:hover::before {
            opacity: 1;
        }

        .admin-card + .admin-card {
            margin-top: 18px;
        }

        .admin-card-title {

            margin-bottom: 15px;

            color: #1d2939;

            font-size: 13.5px;

            font-weight: 750;
        }

        .admin-card-subtitle {

            margin-top: -10px;

            margin-bottom: 15px;

            color: var(--muted);

            font-size: 9.5px;

            line-height: 1.5;
        }


        /* =========================================================
           STAT
        ========================================================= */

        .admin-stat-grid {

            display: grid;

            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(190px, 1fr)
                );

            gap: 14px;

            margin-bottom: 20px;
        }

        .admin-stat {

            position: relative;

            min-height: 145px;

            padding: 19px;

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    #ffffff,
                    #fafbfc
                );

            border:
                1px solid var(--border);

            border-radius: 17px;

            box-shadow: var(--shadow-xs);

            transition: all var(--transition);
        }

        .admin-stat:hover {

            transform: translateY(-5px);

            border-color: #ecd277;

            box-shadow: var(--shadow-md);
        }

        .admin-stat::before {

            content: "";

            position: absolute;

            top: 0;
            left: 0;

            width: 100%;

            height: 3px;

            background:
                linear-gradient(
                    90deg,
                    #f0b90b,
                    #ffe18a
                );
        }

        .admin-stat::after {

            content: "";

            position: absolute;

            width: 130px;
            height: 130px;

            right: -62px;
            bottom: -66px;

            border-radius: 50%;

            background:
                rgba(245,185,27,.065);
        }

        .admin-stat-icon {

            position: absolute;

            top: 17px;
            right: 17px;

            width: 43px;
            height: 43px;

            display: grid;

            place-items: center;

            border-radius: 13px;

            background:
                linear-gradient(
                    145deg,
                    #fff8df,
                    #fffdf5
                );

            border:
                1px solid #f3dfa0;

            color: #c79300;

            font-size: 14px;
        }

        .admin-stat-value {

            margin-top: 31px;

            color: #101828;

            font-family: 'Poppins', sans-serif;

            font-size: 25px;

            font-weight: 800;
        }

        .admin-stat-label {

            margin-top: 3px;

            color: #667085;

            font-size: 9.5px;

            font-weight: 600;
        }

        .admin-stat-meta {

            margin-top: 9px;

            display: inline-flex;

            align-items: center;

            gap: 5px;

            font-size: 8px;

            font-weight: 700;
        }

        .admin-stat-meta.up {
            color: #067647;
        }

        .admin-stat-meta.down {
            color: #b42318;
        }


        /* =========================================================
           GRID
        ========================================================= */

        .admin-grid-2 {

            display: grid;

            grid-template-columns:
                repeat(2,minmax(0,1fr));

            gap: 18px;
        }

        .admin-grid-3 {

            display: grid;

            grid-template-columns:
                repeat(3,minmax(0,1fr));

            gap: 18px;
        }

        .admin-grid-4 {

            display: grid;

            grid-template-columns:
                repeat(4,minmax(0,1fr));

            gap: 18px;
        }


        /* =========================================================
           TABLE
        ========================================================= */

        .admin-table-wrap {

            width: 100%;

            overflow-x: auto;

            border:
                1px solid var(--border);

            border-radius: 14px;

            background: #fff;
        }

        .admin-table {

            width: 100%;

            min-width: 720px;

            border-collapse: separate;

            border-spacing: 0;
        }

        .admin-table th {

            padding: 12px 13px;

            background:
                linear-gradient(
                    180deg,
                    #fafbfc,
                    #f6f8fa
                );

            border-bottom:
                1px solid var(--border);

            color: #667085;

            text-align: left;

            font-size: 8px;

            font-weight: 800;

            letter-spacing: .07em;

            text-transform: uppercase;
        }

        .admin-table td {

            padding: 13px;

            background: #fff;

            border-bottom:
                1px solid #f0f2f5;

            color: #475467;

            font-size: 10.5px;

            font-weight: 500;
        }

        .admin-table tbody tr {
            transition: background var(--transition);
        }

        .admin-table tbody tr:hover td {
            background: #fffdf7;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: 0;
        }


        /* =========================================================
           BUTTONS
        ========================================================= */

        .admin-btn {

            min-height: 40px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            padding: 8px 14px;

            border:
                1px solid transparent;

            border-radius: 10px;

            text-decoration: none;

            font-size: 10px;

            font-weight: 700;

            cursor: pointer;

            transition: all var(--transition);
        }

        .admin-btn:hover {
            transform: translateY(-2px);
        }

        .admin-btn-primary {

            background:
                linear-gradient(
                    135deg,
                    #ffe58a,
                    #f0b90b
                );

            border-color: #e7bd3c;

            color: #3b2c00;

            box-shadow:
                0 8px 22px
                rgba(240,185,11,.17);
        }

        .admin-btn-secondary {

            background: #fff;

            color: #475467;

            border-color: var(--border);
        }

        .admin-btn-danger {

            background: var(--red-soft);

            color: #b42318;

            border-color: #fecdca;
        }

        .admin-btn-success {

            background: var(--green-soft);

            color: #067647;

            border-color: #abefc6;
        }

        .admin-btn-small {

            min-height: 34px;

            padding: 6px 10px;

            font-size: 9px;

            border-radius: 8px;
        }


        /* =========================================================
           BADGES
        ========================================================= */

        .admin-badge {

            display: inline-flex;

            align-items: center;

            gap: 5px;

            padding: 5px 9px;

            border-radius: 999px;

            font-size: 7.5px;

            line-height: 1;

            font-weight: 800;

            letter-spacing: .035em;

            text-transform: uppercase;
        }

        .admin-badge-success {
            background: var(--green-soft);
            color: #067647;
            border: 1px solid #abefc6;
        }

        .admin-badge-warning {
            background: var(--orange-soft);
            color: #b54708;
            border: 1px solid #fedf89;
        }

        .admin-badge-danger {
            background: var(--red-soft);
            color: #b42318;
            border: 1px solid #fecdca;
        }

        .admin-badge-info {
            background: var(--blue-soft);
            color: #175cd3;
            border: 1px solid #b2ddff;
        }

        .admin-badge-neutral {
            background: #f2f4f7;
            color: #475467;
            border: 1px solid #e4e7ec;
        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .admin-alert {

            display: flex;

            align-items: flex-start;

            gap: 10px;

            padding: 12px 14px;

            margin-bottom: 16px;

            border-radius: 11px;

            font-size: 10px;

            font-weight: 600;

            transition:
                opacity .22s ease,
                transform .22s ease;
        }

        .admin-alert-icon {
            flex-shrink: 0;
        }

        .admin-alert-close {

            margin-left: auto;

            width: 25px;
            height: 25px;

            display: grid;

            place-items: center;

            border: 0;

            border-radius: 6px;

            background: transparent;

            cursor: pointer;
        }

        .admin-alert-success {
            background: var(--green-soft);
            border: 1px solid #abefc6;
            color: #067647;
        }

        .admin-alert-danger {
            background: var(--red-soft);
            border: 1px solid #fecdca;
            color: #b42318;
        }

        .admin-alert-warning {
            background: var(--orange-soft);
            border: 1px solid #fedf89;
            color: #b54708;
        }

        .admin-alert-info {
            background: var(--blue-soft);
            border: 1px solid #b2ddff;
            color: #175cd3;
        }


        /* =========================================================
           FORMS
        ========================================================= */

        .admin-content input:not([type="checkbox"]):not([type="radio"]):not([type="file"]),
        .admin-content select,
        .admin-content textarea {

            width: 100%;

            min-height: 42px;

            padding: 9px 12px;

            background: #fff;

            border:
                1px solid #dfe3eb;

            border-radius: 10px;

            color: #344054;

            outline: none;

            font-size: 10.5px;

            transition: all var(--transition);
        }

        .admin-content textarea {

            min-height: 105px;

            resize: vertical;
        }

        .admin-content input:focus,
        .admin-content select:focus,
        .admin-content textarea:focus {

            border-color: #e3bd42;

            box-shadow:
                0 0 0 3px
                rgba(240,185,11,.09);
        }

        .admin-content input::placeholder,
        .admin-content textarea::placeholder {
            color: #a5adba;
        }

        .admin-content label {

            display: block;

            margin-bottom: 6px;

            color: #344054;

            font-size: 9.5px;

            font-weight: 700;
        }

        .admin-form-group {
            margin-bottom: 15px;
        }

        .admin-form-help {

            margin-top: 5px;

            color: #98a2b3;

            font-size: 8px;

            line-height: 1.5;
        }


        /* =========================================================
           EMPTY
        ========================================================= */

        .admin-empty-state {

            padding: 45px 20px;

            text-align: center;

            color: var(--muted);
        }

        .admin-empty-state-icon {

            width: 52px;
            height: 52px;

            margin: 0 auto 12px;

            display: grid;

            place-items: center;

            border-radius: 15px;

            background: var(--gold-soft);

            border: 1px solid #f5e3a2;

            color: var(--gold-dark);

            font-size: 17px;
        }

        .admin-empty-state strong {

            display: block;

            margin-bottom: 5px;

            color: var(--text-2);

            font-size: 11px;
        }

        .admin-empty-state span {

            font-size: 9px;

            line-height: 1.6;
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .admin-footer {

            padding:
                15px
                30px
                22px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            color: #98a2b3;

            font-size: 8px;
        }

        .admin-footer strong {
            color: #667085;
        }

        .admin-footer-right {

            display: flex;

            align-items: center;

            gap: 6px;
        }

        .admin-footer-dot {

            width: 6px;
            height: 6px;

            border-radius: 50%;

            background: var(--green);

            box-shadow:
                0 0 0 3px rgba(18,183,106,.08);
        }


        /* =========================================================
           SIDEBAR OVERLAY
        ========================================================= */

        .admin-sidebar-overlay {

            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(2,8,23,.58);

            backdrop-filter: blur(4px);

            z-index: 1100;
        }

        .admin-sidebar-overlay.active {
            display: block;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media(max-width:1200px) {

            :root {
                --sidebar-width: 250px;
            }

            .admin-content {
                padding: 24px;
            }

            .admin-topbar {
                padding: 0 21px;
            }

            .admin-top-search {
                width: 195px;
            }

            .admin-grid-4 {
                grid-template-columns:
                    repeat(2,minmax(0,1fr));
            }
        }


        @media(max-width:1000px) {

            .admin-top-search {
                display: none;
            }

            .admin-profile-info {
                display: none;
            }

            .admin-grid-3 {
                grid-template-columns:
                    repeat(2,minmax(0,1fr));
            }
        }


        @media(max-width:768px) {

            .admin-sidebar {

                width: 278px;

                transform:
                    translateX(-100%);
            }

            .admin-sidebar.mobile-open {

                transform:
                    translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-menu-toggle {
                display: grid;
            }

            .admin-topbar {

                min-height: 66px;

                padding: 0 14px;
            }

            .admin-content {
                padding: 19px 14px;
            }

            .admin-page-header {

                align-items: flex-start;

                flex-direction: column;

                margin-bottom: 18px;
            }

            .admin-page-title {
                font-size: 23px;
            }

            .admin-breadcrumbs {
                display: none;
            }

            .admin-stat-grid {

                grid-template-columns:
                    repeat(2,minmax(0,1fr));
            }

            .admin-grid-2,
            .admin-grid-3,
            .admin-grid-4 {

                grid-template-columns: 1fr;
            }

            .admin-card {
                padding: 16px;
            }

            .admin-notification-dropdown {
                right: -45px;
            }

            .admin-footer {

                padding:
                    15px
                    14px
                    20px;

                flex-direction: column;

                align-items: flex-start;
            }
        }


        @media(max-width:480px) {

            .admin-topbar {
                padding: 0 10px;
            }

            .admin-content {
                padding: 15px 10px;
            }

            .admin-stat-grid {
                grid-template-columns: 1fr;
            }

            .admin-page-title {
                font-size: 21px;
            }

            .admin-page-actions {
                width: 100%;
            }

            .admin-page-actions .admin-btn {
                flex: 1;
            }

            .admin-profile-dropdown {

                right: -5px;

                width: 235px;
            }

            .admin-notification-dropdown {

                width: 285px;

                right: -80px;
            }
        }



    </style>

    @yield('extra-css')

    <style id="smart-basket-admin-design-system">
        /* Admin-only premium identity. This layout is never used by customers or sellers. */
        html.admin-shell {
            color-scheme: dark;
            --admin-blue: #1D4ED8;
            --admin-blue-dark: #2563EB;
            --admin-navy: #0B1020;
            --admin-surface: #151C2F;
            --admin-surface-raised: #1A2439;
            --admin-cyan: #22D3EE;
            --admin-violet: #8B5CF6;
            --admin-success: #10B981;
            --admin-warning: #F59E0B;
            --admin-danger: #F43F5E;
            --admin-text: #F8FAFC;
            --admin-text-muted: #94A3B8;
            --admin-border: #263249;
            /* Compatibility tokens used by the existing Admin page templates. */
            --admin-gold: #60A5FA;
            --primary-gold: #60A5FA;
            --text-primary: #F8FAFC;
            --text-secondary: #94A3B8;
            --card-bg: #151C2F;
            --border-color: #263249;
            --primary-gold: #60A5FA;
            --gold: #60A5FA;
            --gold-light: #93C5FD;
            --gold-dark: #1D4ED8;
            --gold-soft: rgba(59,130,246,.14);
            --navy: #0B1020;
            --navy-2: #11182A;
            --navy-3: #151C2F;
            --bg: #0B1020;
            --surface: #151C2F;
            --surface-2: #1A2439;
            --text: #F8FAFC;
            --text-2: #E2E8F0;
            --text-3: #CBD5E1;
            --muted: #94A3B8;
            --muted-2: #718096;
            --border: #263249;
            --border-soft: #202B40;
            --green: #10B981;
            --green-soft: rgba(16,185,129,.13);
            --red: #F43F5E;
            --red-soft: rgba(244,63,94,.13);
            --orange: #F59E0B;
            --orange-soft: rgba(245,158,11,.13);
            --blue: #22D3EE;
            --blue-soft: rgba(34,211,238,.12);
            --purple: #8B5CF6;
            --purple-soft: rgba(37,99,235,.14);
            --sidebar-width: 278px;
            --topbar-height: 72px;
            --radius-xl: 20px;
            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 9px;
            --shadow-xs: 0 1px 2px rgba(0,0,0,.18);
            --shadow-sm: 0 8px 24px rgba(0,0,0,.20);
            --shadow-md: 0 18px 45px rgba(0,0,0,.26);
            --shadow-lg: 0 28px 80px rgba(0,0,0,.38);
            --transition: .2s ease;
        }

        body.admin-layout {
            min-height: 100vh;
            color: var(--admin-text);
            background: radial-gradient(ellipse at 80% -10%, rgba(29,78,216,.18), transparent 38%),
                        radial-gradient(ellipse at 12% 30%, rgba(34,211,238,.055), transparent 30%),
                        var(--admin-navy);
            color-scheme: dark;
        }

        body.admin-layout::before {
            opacity: .18;
            background-image: linear-gradient(rgba(148,163,184,.035) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(148,163,184,.035) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        body.admin-layout :focus-visible {
            outline: 3px solid rgba(34,211,238,.8);
            outline-offset: 2px;
        }

        body.admin-layout ::selection { background: rgba(59,130,246,.38); color: #fff; }
        body.admin-layout ::-webkit-scrollbar-track { background: #101729; }
        body.admin-layout ::-webkit-scrollbar-thumb { background: #35435D; }
        body.admin-layout ::-webkit-scrollbar-thumb:hover { background: #4B5B78; }

        body.admin-layout .admin-sidebar {
            color: #E2E8F0;
            background: radial-gradient(circle at 85% 0%, rgba(29,78,216,.20), transparent 28%),
                        linear-gradient(180deg, #10182B 0%, #0B1020 60%, #090E1B 100%);
            border-right: 1px solid var(--admin-border);
            box-shadow: 14px 0 48px rgba(0,0,0,.25);
        }
        body.admin-layout .admin-sidebar::before { background: radial-gradient(circle, rgba(34,211,238,.08), transparent 70%); }
        body.admin-layout .admin-sidebar-header { background: rgba(11,16,32,.94); border-bottom-color: var(--admin-border); }
        body.admin-layout .admin-logo {
            color: #fff;
            background: linear-gradient(140deg, #3B82F6, #1D4ED8 65%, #1E40AF);
            box-shadow: 0 8px 24px rgba(29,78,216,.34), inset 0 1px rgba(255,255,255,.20);
        }
        body.admin-layout .admin-sidebar-section-title { color: #64748B; }
        body.admin-layout .admin-sidebar-link { color: #AAB7CA; border-radius: 10px; transition: color .18s ease, background .18s ease, transform .18s ease; }
        body.admin-layout .admin-sidebar-link:hover { color: #F8FAFC; background: rgba(148,163,184,.09); transform: translateX(2px); }
        body.admin-layout .admin-sidebar-link.active,
        body.admin-layout .admin-sidebar-link[aria-current="page"] {
            color: #fff; background: linear-gradient(105deg, rgba(37,99,235,.34), rgba(29,78,216,.16));
            box-shadow: inset 3px 0 #60A5FA, inset 0 0 0 1px rgba(59,130,246,.13);
        }
        body.admin-layout .admin-sidebar-link.active i { color: #93C5FD; }
        body.admin-layout .admin-sidebar-badge { color: #CFFAFE; background: rgba(34,211,238,.13); border-color: rgba(34,211,238,.24); }
        body.admin-layout .admin-sidebar-footer { border-top-color: var(--admin-border); }
        body.admin-layout .admin-sidebar-footer-icon { background: rgba(59,130,246,.18); color: #93C5FD; }

        body.admin-layout .admin-main { background: transparent; }
        body.admin-layout .admin-topbar {
            min-height: var(--topbar-height); color: var(--admin-text);
            background: rgba(11,16,32,.86); border-bottom: 1px solid rgba(38,50,73,.9);
            box-shadow: 0 8px 30px rgba(0,0,0,.12); backdrop-filter: blur(18px);
        }
        body.admin-layout .admin-topbar-title, body.admin-layout .admin-topbar h1 { color: #F8FAFC; }
        body.admin-layout .admin-topbar-breadcrumb, body.admin-layout .admin-breadcrumb { color: #94A3B8; }
        body.admin-layout .admin-top-search { color: #F8FAFC; background: #121B2E; border-color: var(--admin-border); }
        body.admin-layout .admin-top-search::placeholder { color: #718096; }
        body.admin-layout .admin-topbar-icon, body.admin-layout .admin-topbar-item { color: #AAB7CA; background: transparent; }
        body.admin-layout .admin-topbar-icon:hover, body.admin-layout .admin-topbar-item:hover { color: #fff; background: rgba(148,163,184,.10); }
        body.admin-layout .admin-profile-dropdown, body.admin-layout .admin-notifications-dropdown { color: #E2E8F0; background: #151C2F; border: 1px solid var(--admin-border); box-shadow: var(--shadow-lg); }
        body.admin-layout .admin-content { color: #E2E8F0; background: transparent; }
        body.admin-layout .admin-content h1, body.admin-layout .admin-content h2, body.admin-layout .admin-content h3, body.admin-layout .admin-content h4 { color: #F8FAFC; }
        body.admin-layout .admin-page-title { color: #F8FAFC; letter-spacing: -.025em; }
        body.admin-layout .admin-page-description { color: #94A3B8; }

        /* Shared page primitives for older Admin views, scoped to this layout. */
        body.admin-layout .admin-stat-grid,
        body.admin-layout .sb-stats-grid { grid-template-columns: repeat(auto-fit, minmax(min(100%, 210px), 1fr)); }
        body.admin-layout .admin-stat,
        body.admin-layout .admin-stat-card,
        body.admin-layout .sb-stat-card { min-width: 0; }
        body.admin-layout .admin-stat-label,
        body.admin-layout .admin-stat-value,
        body.admin-layout .sb-stat-label { color: #CBD5E1; }
        body.admin-layout .admin-stat-value { color: #F8FAFC; }
        body.admin-layout .admin-toolbar { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin: 0 0 18px; }
        body.admin-layout .admin-toolbar > input,
        body.admin-layout .admin-toolbar > select { flex: 1 1 170px; }
        body.admin-layout .admin-input,
        body.admin-layout .admin-select { padding: 9px 12px; }
        body.admin-layout .admin-card { padding: 18px; margin: 0 0 18px; }
        body.admin-layout .admin-card-title { margin: 0 0 14px; font-size: 1rem; font-weight: 750; }
        body.admin-layout .admin-page-header { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin: 0 0 22px; }
        body.admin-layout .admin-content > .admin-page-header,
        body.admin-layout .admin-content > .sb-dashboard-hero,
        body.admin-layout .admin-content > .profile-hero,
        body.admin-layout .admin-content > .sb-settings-header { width: 100%; max-width: none; box-sizing: border-box; }
        body.admin-layout .admin-page-title { display: flex; align-items: center; gap: 10px; margin: 0 0 5px; font-size: clamp(1.35rem, 2vw, 1.8rem); font-weight: 800; }
        body.admin-layout .admin-page-title > i { color: #93C5FD; font-size: .85em; }
        body.admin-layout .admin-page-description { margin: 0; line-height: 1.6; }
        body.admin-layout .admin-empty { padding: 30px 18px; text-align: center; color: #94A3B8; }
        body.admin-layout .admin-empty > i { display: block; margin-bottom: 10px; color: #60A5FA; font-size: 1.6rem; }
        body.admin-layout .admin-badge-success { color: #A7F3D0; background: rgba(16,185,129,.14); border: 1px solid rgba(16,185,129,.28); }
        body.admin-layout .admin-badge-warning { color: #FDE68A; background: rgba(245,158,11,.14); border: 1px solid rgba(245,158,11,.28); }
        body.admin-layout .admin-badge-danger { color: #FECDD3; background: rgba(244,63,94,.14); border: 1px solid rgba(244,63,94,.28); }
        body.admin-layout .admin-badge-info { color: #A5F3FC; background: rgba(34,211,238,.12); border: 1px solid rgba(34,211,238,.24); }
        body.admin-layout .admin-table-wrap { margin: 0; }
        body.admin-layout .admin-pagination { padding-top: 15px; overflow-x: auto; }
        body.admin-layout .admin-pagination nav > div:first-child { color: #94A3B8; }
        body.admin-layout .admin-content img { border-radius: 10px; }
        body.admin-layout .admin-content .modal-content,
        body.admin-layout .admin-content .dropdown-menu { color: #E2E8F0; background: #151C2F; border: 1px solid #263249; box-shadow: var(--shadow-lg); }
        body.admin-layout .admin-content .modal-header,
        body.admin-layout .admin-content .modal-footer { border-color: #263249; }
        body.admin-layout .admin-content .modal-title { color: #F8FAFC; }
        body.admin-layout .admin-content .dropdown-item { color: #CBD5E1; }
        body.admin-layout .admin-content .dropdown-item:hover,
        body.admin-layout .admin-content .dropdown-item:focus { color: #fff; background: rgba(59,130,246,.18); }
        body.admin-layout .admin-content .text-muted,
        body.admin-layout .admin-content small { color: #64748B; }
        body.admin-layout .admin-content .alert-success { color: #A7F3D0; background: rgba(16,185,129,.12); border-color: rgba(16,185,129,.3); }
        body.admin-layout .admin-content .alert-danger { color: #FECDD3; background: rgba(244,63,94,.12); border-color: rgba(244,63,94,.3); }
        body.admin-layout .admin-content label { color: #CBD5E1; }
        body.admin-layout .admin-content .form-text,
        body.admin-layout .admin-content .help-text { color: #94A3B8; }

        /* Dashboard accents use the same restrained Admin palette as the shell. */
        body.admin-layout .sb-dashboard-hero { border-color: rgba(59,130,246,.24); background: radial-gradient(circle at 88% 12%,rgba(29,78,216,.19),transparent 34%),radial-gradient(circle at 12% 100%,rgba(34,211,238,.07),transparent 36%),#151C2F; box-shadow: var(--shadow-sm); }
        body.admin-layout .sb-dashboard-hero::after { border-color: rgba(59,130,246,.18); }
        body.admin-layout .sb-eyebrow,
        body.admin-layout .sb-section-heading h2 i,
        body.admin-layout .sb-card-title i,
        body.admin-layout .sb-card-link,
        body.admin-layout .sb-quick-action i,
        body.admin-layout .sb-empty i { color: #93C5FD; }
        body.admin-layout .sb-admin-chip { border-color: var(--admin-border); background: rgba(255,255,255,.025); }
        body.admin-layout .sb-admin-avatar { color: #fff; background: linear-gradient(140deg,#3B82F6,#1D4ED8 70%,#1E40AF); }
        body.admin-layout .sb-blue { --stat-color: #67E8F9; --stat-bg: rgba(34,211,238,.12); --stat-glow: #22D3EE; }
        body.admin-layout .sb-green { --stat-color: #6EE7B7; --stat-bg: rgba(16,185,129,.12); --stat-glow: #10B981; }
        body.admin-layout .sb-orange { --stat-color: #FCD34D; --stat-bg: rgba(245,158,11,.12); --stat-glow: #F59E0B; }
        body.admin-layout .sb-purple { --stat-color: #C4B5FD; --stat-bg: rgba(37,99,235,.13); --stat-glow: #8B5CF6; }
        body.admin-layout .sb-red { --stat-color: #FDA4AF; --stat-bg: rgba(244,63,94,.12); --stat-glow: #F43F5E; }
        body.admin-layout .sb-gold { --stat-color: #93C5FD; --stat-bg: rgba(59,130,246,.14); --stat-glow: #3B82F6; }
        body.admin-layout .sb-stat-card:hover { border-color: color-mix(in srgb, var(--stat-color), transparent 55%); }
        body.admin-layout .sb-quick-action { background: rgba(255,255,255,.025); }
        body.admin-layout .sb-quick-action:hover { border-color: rgba(59,130,246,.38); background: rgba(59,130,246,.10); }
        body.admin-layout .sb-status { color: #93C5FD; background: rgba(59,130,246,.14); }

        /* Seller detail templates carry older light surface rules; normalize them here. */
        body.admin-layout .seller-stat-grid { grid-template-columns: repeat(auto-fit,minmax(min(100%,220px),1fr)); }
        body.admin-layout .seller-stat-card { color: #E2E8F0; background: #151C2F; border: 1px solid var(--admin-border); box-shadow: var(--shadow-xs); }
        body.admin-layout .seller-stat-icon,
        body.admin-layout .seller-page-icon,
        body.admin-layout .seller-empty-icon { color: #93C5FD; background: rgba(59,130,246,.14); }
        body.admin-layout .seller-stat-label,
        body.admin-layout .seller-page-description,
        body.admin-layout .seller-empty-text { color: #94A3B8; }
        body.admin-layout .seller-stat-value,
        body.admin-layout .seller-product-name,
        body.admin-layout .seller-price { color: #F8FAFC; }
        body.admin-layout .seller-table th { color: #AAB7CA; background: #111B2E; }
        body.admin-layout .seller-table td { color: #CBD5E1; }
        body.admin-layout .seller-stock,
        body.admin-layout .seller-status { color: #D7E0EF; background: #1A2439; border: 1px solid #35435D; }
        body.admin-layout .seller-empty-title { color: #E2E8F0; }
        body.admin-layout .seller-back-btn,
        body.admin-layout .seller-view-btn { color: #D7E0EF; background: #1A2439; border: 1px solid #35435D; }
        body.admin-layout .seller-kyc-btn { color: #fff; background: linear-gradient(135deg,#2563EB,#1D4ED8); border-color: #2563EB; }
        body.admin-layout .seller-back-btn:hover,
        body.admin-layout .seller-view-btn:hover { color: #fff; border-color: #3B82F6; background: rgba(59,130,246,.18); }

        body.admin-layout .admin-card, body.admin-layout .admin-info-card, body.admin-layout .sb-settings-card,
        body.admin-layout .sb-card, body.admin-layout .seller-card, body.admin-layout .profile-card,
        body.admin-layout .card, body.admin-layout .admin-stat-card, body.admin-layout .sb-stat-card {
            color: #E2E8F0; background: #151C2F; border: 1px solid var(--admin-border);
            border-radius: 15px; box-shadow: 0 12px 32px rgba(0,0,0,.16);
        }
        body.admin-layout .admin-card:hover, body.admin-layout .sb-settings-card:hover, body.admin-layout .seller-card:hover { border-color: #35435D; }
        body.admin-layout .admin-card-title, body.admin-layout .sb-card-title, body.admin-layout .seller-card-title { color: #F8FAFC; }
        body.admin-layout .admin-card-header, body.admin-layout .sb-settings-card-header, body.admin-layout .sb-card-header, body.admin-layout .seller-card-header {
            color: #F8FAFC; background: rgba(255,255,255,.018); border-bottom-color: var(--admin-border);
        }
        body.admin-layout .admin-card-body, body.admin-layout .sb-settings-card-body, body.admin-layout .seller-card-body { color: #CBD5E1; }
        body.admin-layout .admin-settings-nav, body.admin-layout .sb-settings-nav { background: #151C2F; border-color: var(--admin-border); }

        body.admin-layout .admin-table-wrap, body.admin-layout .seller-table-wrap, body.admin-layout .table-responsive {
            max-width: 100%; overflow-x: auto; border: 1px solid var(--admin-border); border-radius: 12px;
        }
        body.admin-layout table, body.admin-layout .admin-table, body.admin-layout .seller-table {
            width: 100%; color: #CBD5E1; background: #151C2F; border-collapse: separate; border-spacing: 0;
        }
        body.admin-layout table thead th, body.admin-layout .admin-table thead th, body.admin-layout .seller-table thead th {
            color: #93C5FD; background: #1A2439; border-bottom: 1px solid #35435D;
            font-size: .76rem; font-weight: 750; letter-spacing: .035em; text-transform: uppercase;
        }
        body.admin-layout table td, body.admin-layout table th { padding: 12px 14px; border-color: rgba(38,50,73,.8); vertical-align: middle; }
        body.admin-layout table tbody tr { background: transparent; transition: background .16s ease; }
        body.admin-layout table tbody tr:hover { background: rgba(148,163,184,.045); }
        body.admin-layout table a { color: #93C5FD; }

        body.admin-layout input:not([type="checkbox"]):not([type="radio"]), body.admin-layout select, body.admin-layout textarea,
        body.admin-layout .form-control, body.admin-layout .form-select, body.admin-layout .sb-form-control, body.admin-layout .admin-input {
            min-height: 40px; color: #F1F5F9; background-color: #0F1728; border: 1px solid #35435D; border-radius: 9px;
        }
        body.admin-layout textarea { min-height: 100px; }
        body.admin-layout input::placeholder, body.admin-layout textarea::placeholder { color: #718096; }
        body.admin-layout select option { color: #F1F5F9; background: #151C2F; }
        body.admin-layout input:focus, body.admin-layout select:focus, body.admin-layout textarea:focus, body.admin-layout .form-control:focus, body.admin-layout .form-select:focus {
            color: #F8FAFC; background-color: #111B2E; border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59,130,246,.20);
        }

        body.admin-layout .admin-btn, body.admin-layout .sb-btn, body.admin-layout .profile-primary-btn, body.admin-layout .seller-view-btn, body.admin-layout button.btn, body.admin-layout a.btn {
            min-height: 38px; border-radius: 9px; font-weight: 700; transition: transform .16s ease, filter .16s ease, box-shadow .16s ease;
        }
        body.admin-layout .admin-btn-primary, body.admin-layout .sb-btn-primary, body.admin-layout .profile-primary-btn,
        body.admin-layout button.btn-primary, body.admin-layout a.btn-primary {
            color: #fff; background: linear-gradient(135deg,#2563EB,#1D4ED8); border-color: #2563EB; box-shadow: 0 6px 16px rgba(29,78,216,.24);
        }
        body.admin-layout .admin-btn-secondary, body.admin-layout .sb-btn-secondary, body.admin-layout button.btn-secondary, body.admin-layout a.btn-secondary {
            color: #D7E0EF; background: #1A2439; border: 1px solid #35435D;
        }
        body.admin-layout .admin-btn-success, body.admin-layout button.btn-success { color: #D1FAE5; background: rgba(16,185,129,.15); border: 1px solid rgba(16,185,129,.38); }
        body.admin-layout .admin-btn-danger, body.admin-layout button.btn-danger { color: #FFE4E6; background: rgba(244,63,94,.14); border: 1px solid rgba(244,63,94,.38); }
        body.admin-layout button:not(:disabled):hover, body.admin-layout a.btn:hover, body.admin-layout .admin-btn:hover, body.admin-layout .sb-btn:hover { filter: brightness(1.08); transform: translateY(-1px); }
        body.admin-layout button:disabled, body.admin-layout .disabled { opacity: .55; cursor: not-allowed; }

        body.admin-layout .admin-badge, body.admin-layout .sb-badge, body.admin-layout .badge { border-radius: 999px; font-weight: 700; }
        body.admin-layout .admin-pagination a, body.admin-layout .admin-pagination span, body.admin-layout .pagination a, body.admin-layout .pagination span {
            color: #CBD5E1; background: #151C2F; border-color: var(--admin-border);
        }
        body.admin-layout .admin-pagination .active span, body.admin-layout .pagination .active span { color: white; background: #1D4ED8; border-color: #1D4ED8; }
        body.admin-layout .admin-alert, body.admin-layout .sb-alert, body.admin-layout .alert { color: #E2E8F0; background-color: #151C2F; border-color: var(--admin-border); }
        body.admin-layout .admin-empty-state, body.admin-layout .empty-state { color: #94A3B8; border-color: var(--admin-border); }

        @media (max-width: 900px) {
            body.admin-layout .admin-content { padding-left: 16px; padding-right: 16px; }
            body.admin-layout .admin-topbar { gap: 10px; }
        }
        @media (max-width: 600px) {
            body.admin-layout .admin-content { padding: 16px 12px 28px; }
            body.admin-layout .admin-page-header { align-items: flex-start; flex-direction: column; gap: 12px; }
            body.admin-layout .admin-page-header > :last-child { width: 100%; display: flex; flex-wrap: wrap; gap: 8px; }
            body.admin-layout .admin-page-header > :last-child .admin-btn { flex: 1 1 auto; }
            body.admin-layout table { min-width: 680px; }
            body.admin-layout .sb-settings-layout { grid-template-columns: minmax(0,1fr); }
            body.admin-layout .sb-settings-nav { position: static; }
            body.admin-layout .admin-card { padding: 14px; }
            body.admin-layout .admin-page-header { align-items: flex-start; }
            body.admin-layout .admin-toolbar > button { flex: 1 1 100%; min-height: 42px; }
            body.admin-layout .sb-hero-content { align-items: flex-start; flex-direction: column; }
            body.admin-layout .sb-admin-chip { width: 100%; }
        }

        /* Light content theme with the deep navy Admin navigation retained. */
        html.admin-shell {
            color-scheme: light;
            --admin-blue: #2563EB; --admin-blue-dark: #1D4ED8; --admin-blue-hover: #1D4ED8; --admin-blue-soft: #EFF6FF; --admin-blue-pale: #DBEAFE; --admin-violet: #7C3AED; --admin-cyan: #06B6D4;
            --admin-navy: #111827; --admin-surface: #FFFFFF; --admin-surface-raised: #F9FAFB;
            --admin-text: #172033; --admin-text-muted: #667085; --admin-border: #E4E7EC;
            --admin-gold: #2563EB; --primary-gold: #2563EB; --gold: #2563EB; --gold-light: #60A5FA; --gold-dark: #1D4ED8; --gold-soft: rgba(37,99,235,.10);
            --text-primary: #172033; --text-secondary: #667085; --card-bg: #FFFFFF; --border-color: #E4E7EC;
            --navy: #111827; --navy-2: #1F2937; --navy-3: #374151;
            --bg: #F5F7FC; --surface: #FFFFFF; --surface-2: #F9FAFB;
            --text: #172033; --text-2: #344054; --text-3: #475467; --muted: #667085; --muted-2: #98A2B3;
            --border: #E4E7EC; --border-soft: #EEF0F4;
            --green: #059669; --green-soft: #ECFDF3; --red: #E11D48; --red-soft: #FFF1F2;
            --orange: #D97706; --orange-soft: #FFFAEB; --blue: #2563EB; --blue-soft: #EFF6FF;
            --purple: #7C3AED; --purple-soft: #F5F3FF;
        }
        body.admin-layout {
            color: #172033; color-scheme: light;
            background: radial-gradient(ellipse at 80% -10%,rgba(37,99,235,.055),transparent 38%),#F5F7FC;
        }
        body.admin-layout::before { opacity:.22; background-image:linear-gradient(rgba(17,24,39,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(17,24,39,.025) 1px,transparent 1px); }
        body.admin-layout :focus-visible { outline-color:rgba(37,99,235,.78); }
        body.admin-layout ::selection { background:rgba(37,99,235,.18); color:#111827; }
        body.admin-layout ::-webkit-scrollbar-track { background:#EEF0F4; }
        body.admin-layout ::-webkit-scrollbar-thumb { background:#C5CBD5; }
        body.admin-layout ::-webkit-scrollbar-thumb:hover { background:#98A2B3; }
        body.admin-layout .admin-main { background:transparent; }
        body.admin-layout .admin-topbar { color:#172033; background:rgba(255,255,255,.94); border-bottom:1px solid #E4E7EC; box-shadow:0 4px 18px rgba(16,24,40,.045); }
        body.admin-layout .admin-topbar-title, body.admin-layout .admin-topbar h1 { color:#172033; }
        body.admin-layout .admin-topbar-breadcrumb, body.admin-layout .admin-breadcrumb { color:#667085; }
        body.admin-layout .admin-top-search { color:#172033; background:#fff; border-color:#D0D5DD; }
        body.admin-layout .admin-top-search::placeholder { color:#667085; }
        body.admin-layout .admin-topbar-icon, body.admin-layout .admin-topbar-item { color:#475467; }
        body.admin-layout .admin-topbar-icon:hover, body.admin-layout .admin-topbar-item:hover { color:#1E40AF; background:#F2F4F7; }
        body.admin-layout .admin-profile-dropdown, body.admin-layout .admin-notifications-dropdown { color:#344054; background:#fff; border:1px solid #E4E7EC; box-shadow:0 16px 40px rgba(16,24,40,.14); }
        body.admin-layout .admin-content { color:#344054; background:transparent; }
        body.admin-layout .admin-content h1, body.admin-layout .admin-content h2, body.admin-layout .admin-content h3, body.admin-layout .admin-content h4 { color:#172033; }
        body.admin-layout .admin-page-title { color:#172033; }
        body.admin-layout .admin-page-title > i { color:#2563EB; }
        body.admin-layout .admin-page-description { color:#667085; }
        body.admin-layout .admin-card, body.admin-layout .admin-info-card, body.admin-layout .sb-settings-card,
        body.admin-layout .sb-card, body.admin-layout .seller-card, body.admin-layout .profile-card,
        body.admin-layout .card, body.admin-layout .admin-stat-card, body.admin-layout .sb-stat-card,
        body.admin-layout .seller-stat-card {
            color:#344054; background:#FFFFFF; border:1px solid #E4E7EC; border-radius:15px;
            box-shadow:0 4px 16px rgba(16,24,40,.045);
        }
        body.admin-layout .admin-card:hover, body.admin-layout .sb-settings-card:hover, body.admin-layout .seller-card:hover,
        body.admin-layout .sb-stat-card:hover { border-color:#BFDBFE; box-shadow:0 10px 26px rgba(16,24,40,.08); }
        body.admin-layout .admin-card-title, body.admin-layout .sb-card-title, body.admin-layout .seller-card-title,
        body.admin-layout .profile-card h2 { color:#172033; }
        body.admin-layout .admin-card-header, body.admin-layout .sb-settings-card-header, body.admin-layout .sb-card-header,
        body.admin-layout .seller-card-header { color:#172033; background:#FAFBFD; border-bottom-color:#E4E7EC; }
        body.admin-layout .admin-card-body, body.admin-layout .sb-settings-card-body, body.admin-layout .seller-card-body { color:#344054; }
        body.admin-layout .admin-settings-nav, body.admin-layout .sb-settings-nav { color:#344054; background:#fff; border-color:#E4E7EC; }
        body.admin-layout .admin-table-wrap, body.admin-layout .seller-table-wrap, body.admin-layout .table-responsive { border-color:#E4E7EC; }
        body.admin-layout table, body.admin-layout .admin-table, body.admin-layout .seller-table { color:#344054; background:#fff; }
        body.admin-layout table thead th, body.admin-layout .admin-table thead th, body.admin-layout .seller-table thead th {
            color:#475467; background:#F5F7FA; border-bottom:1px solid #E4E7EC;
        }
        body.admin-layout table td, body.admin-layout table th { border-color:#EAECF0; }
        body.admin-layout table tbody tr { background:#fff; }
        body.admin-layout table tbody tr:hover { background:#F9FAFB; }
        body.admin-layout table a { color:#1D4ED8; }
        body.admin-layout .seller-table th { color:#475467; background:#F5F7FA; }
        body.admin-layout .seller-table td, body.admin-layout .seller-stat-card { color:#344054; }
        body.admin-layout .seller-stat-label, body.admin-layout .seller-page-description { color:#667085; }
        body.admin-layout .seller-stat-value, body.admin-layout .seller-product-name, body.admin-layout .seller-price { color:#172033; }
        body.admin-layout .seller-stat-icon, body.admin-layout .seller-page-icon, body.admin-layout .seller-empty-icon { color:#1D4ED8; background:#EEF2FF; }
        body.admin-layout .seller-stock, body.admin-layout .seller-status { color:#344054; background:#F2F4F7; border-color:#E4E7EC; }
        body.admin-layout .seller-empty-title { color:#344054; }
        body.admin-layout .seller-back-btn, body.admin-layout .seller-view-btn { color:#344054; background:#fff; border-color:#D0D5DD; }
        body.admin-layout .seller-back-btn:hover, body.admin-layout .seller-view-btn:hover { color:#1E40AF; background:#F5F7FF; border-color:#BFDBFE; }
        body.admin-layout input:not([type="checkbox"]):not([type="radio"]), body.admin-layout select, body.admin-layout textarea,
        body.admin-layout .form-control, body.admin-layout .form-select, body.admin-layout .sb-form-control, body.admin-layout .admin-input {
            color:#172033; background-color:#fff; border:1px solid #D0D5DD;
        }
        body.admin-layout input::placeholder, body.admin-layout textarea::placeholder { color:#667085; opacity:1; }
        body.admin-layout select option { color:#172033; background:#fff; }
        body.admin-layout input:focus, body.admin-layout select:focus, body.admin-layout textarea:focus,
        body.admin-layout .form-control:focus, body.admin-layout .form-select:focus { color:#172033; background:#fff; border-color:#3B82F6; box-shadow:0 0 0 3px rgba(37,99,235,.15); }
        body.admin-layout input:disabled, body.admin-layout select:disabled, body.admin-layout textarea:disabled { color:#667085; background:#F2F4F7; opacity:1; }
        body.admin-layout .admin-content label { color:#344054; }
        body.admin-layout .admin-content .form-text, body.admin-layout .admin-content .help-text,
        body.admin-layout .admin-content .text-muted, body.admin-layout .admin-content small { color:#667085 !important; }
        body.admin-layout .admin-content .modal-content, body.admin-layout .admin-content .dropdown-menu { color:#344054; background:#fff; border-color:#E4E7EC; box-shadow:0 18px 50px rgba(16,24,40,.18); }
        body.admin-layout .admin-content .modal-header, body.admin-layout .admin-content .modal-footer { border-color:#E4E7EC; }
        body.admin-layout .admin-content .modal-title { color:#172033; }
        body.admin-layout .admin-content .dropdown-item { color:#344054; }
        body.admin-layout .admin-content .dropdown-item:hover, body.admin-layout .admin-content .dropdown-item:focus { color:#1E40AF; background:#F5F7FF; }
        body.admin-layout .admin-content .alert { color:#344054; background:#F9FAFB; border-color:#E4E7EC; }
        body.admin-layout .admin-content .alert-success { color:#065F46; background:#ECFDF3; border-color:#A6F4C5; }
        body.admin-layout .admin-content .alert-danger { color:#9F1239; background:#FFF1F2; border-color:#FECDD3; }
        body.admin-layout .admin-content .alert-warning { color:#92400E; background:#FFFAEB; border-color:#FEDF89; }
        body.admin-layout .admin-content .alert-info { color:#1E40AF; background:#EFF6FF; border-color:#BFDBFE; }
        body.admin-layout .admin-btn-secondary, body.admin-layout .sb-btn-secondary, body.admin-layout button.btn-secondary,
        body.admin-layout a.btn-secondary { color:#344054; background:#fff; border:1px solid #D0D5DD; }
        body.admin-layout .admin-btn-secondary:hover, body.admin-layout .sb-btn-secondary:hover,
        body.admin-layout button.btn-secondary:hover, body.admin-layout a.btn-secondary:hover { color:#1E40AF; background:#F5F7FF; border-color:#BFDBFE; }
        body.admin-layout .admin-pagination a, body.admin-layout .admin-pagination span,
        body.admin-layout .pagination a, body.admin-layout .pagination span { color:#344054; background:#fff; border-color:#D0D5DD; }
        body.admin-layout .admin-pagination .active span, body.admin-layout .pagination .active span { color:#fff; background:#2563EB; border-color:#2563EB; }
        body.admin-layout .admin-badge-success { color:#05603A; background:#ECFDF3; border-color:#A6F4C5; }
        body.admin-layout .admin-badge-warning { color:#92400E; background:#FFFAEB; border-color:#FEDF89; }
        body.admin-layout .admin-badge-danger { color:#9F1239; background:#FFF1F2; border-color:#FECDD3; }
        body.admin-layout .admin-badge-info { color:#1D4ED8; background:#EFF6FF; border-color:#BFDBFE; }
        body.admin-layout .admin-empty, body.admin-layout .empty-state { color:#667085; }
        body.admin-layout .admin-empty > i { color:#2563EB; }
        body.admin-layout .sb-dashboard-hero { color:#344054; background:radial-gradient(circle at 88% 12%,rgba(37,99,235,.08),transparent 34%),#fff; border-color:#E4E7EC; box-shadow:0 8px 24px rgba(16,24,40,.055); }
        body.admin-layout .sb-dashboard-hero::after { border-color:rgba(37,99,235,.12); }
        body.admin-layout .sb-hero-title, body.admin-layout .sb-section-heading h2, body.admin-layout .sb-admin-chip strong { color:#172033; }
        body.admin-layout .sb-hero-description, body.admin-layout .sb-section-heading span, body.admin-layout .sb-admin-chip small { color:#667085; }
        body.admin-layout .sb-eyebrow, body.admin-layout .sb-section-heading h2 i, body.admin-layout .sb-card-title i,
        body.admin-layout .sb-card-link, body.admin-layout .sb-quick-action i, body.admin-layout .sb-empty i { color:#2563EB; }
        body.admin-layout .sb-admin-chip { border-color:#E4E7EC; background:#F9FAFB; }
        body.admin-layout .sb-blue { --stat-color:#0E7490; --stat-bg:#ECFEFF; --stat-glow:#06B6D4; }
        body.admin-layout .sb-green { --stat-color:#047857; --stat-bg:#ECFDF3; --stat-glow:#059669; }
        body.admin-layout .sb-orange { --stat-color:#B45309; --stat-bg:#FFFAEB; --stat-glow:#D97706; }
        body.admin-layout .sb-purple { --stat-color:#6D28D9; --stat-bg:#F5F3FF; --stat-glow:#7C3AED; }
        body.admin-layout .sb-red { --stat-color:#BE123C; --stat-bg:#FFF1F2; --stat-glow:#E11D48; }
        body.admin-layout .sb-gold { --stat-color:#1D4ED8; --stat-bg:#EEF2FF; --stat-glow:#2563EB; }
        body.admin-layout .sb-stat-number { color:var(--stat-color); }
        body.admin-layout .sb-quick-action { color:#344054; background:#fff; border-color:#E4E7EC; }
        body.admin-layout .sb-quick-action:hover { color:#1E40AF; border-color:#BFDBFE; background:#F5F7FF; }
        body.admin-layout .sb-status { color:#1D4ED8; background:#EEF2FF; }
        body.admin-layout .seller-kyc-btn { color:#fff; background:#2563EB; border-color:#2563EB; }
        body.admin-layout .admin-content .admin-verification-detail { color:#344054; }
        body.admin-layout .admin-content .admin-verification-detail .card,
        body.admin-layout .admin-content .admin-verification-detail .document,
        body.admin-layout .admin-content .admin-verification-detail .info,
        body.admin-layout .admin-content .admin-verification-detail .log { color:#344054; background:#fff; border-color:#E4E7EC; }
        body.admin-layout .admin-content .admin-verification-detail .card h2,
        body.admin-layout .admin-content .admin-verification-detail .document h3,
        body.admin-layout .admin-content .admin-verification-detail .shop-name,
        body.admin-layout .admin-content .admin-verification-detail .value,
        body.admin-layout .admin-content .admin-verification-detail .log-title { color:#172033; }
        body.admin-layout .admin-content .admin-verification-detail .label,
        body.admin-layout .admin-content .admin-verification-detail .seller-name,
        body.admin-layout .admin-content .admin-verification-detail .log-meta,
        body.admin-layout .admin-content .admin-verification-detail .empty { color:#667085; }
        body.admin-layout .admin-content .admin-verification-detail .logo,
        body.admin-layout .admin-content .admin-verification-detail .logo-placeholder { background:#EEF2FF; border-color:#E4E7EC; color:#1D4ED8; }
        body.admin-layout .admin-content .admin-verification-detail .btn-secondary { color:#344054; background:#F2F4F7; border-color:#D0D5DD; }
        body.admin-layout .admin-content .admin-verification-detail .document img { background:#F9FAFB; border-color:#D0D5DD; }
        body.admin-layout .admin-content .admin-verification-detail .log { border-left-color:#2563EB; }
        @media (max-width:600px) {
            body.admin-layout .admin-content { color:#344054; }
            body.admin-layout .admin-card, body.admin-layout .seller-card { box-shadow:0 2px 10px rgba(16,24,40,.04); }
        }

        /* Unified premium blue layer for every page using the Admin shell. */
        html.admin-shell { color-scheme: light; --admin-blue:#2563EB; --admin-blue-dark:#1D4ED8; --admin-blue-soft:#EFF6FF; --admin-blue-pale:#DBEAFE; --admin-navy:#0F172A; --admin-surface:#FFFFFF; --admin-surface-raised:#F8FAFC; --admin-text:#172033; --admin-text-muted:#64748B; --admin-border:#E2E8F0; --gold:#2563EB; --gold-light:#60A5FA; --gold-dark:#1D4ED8; --gold-soft:rgba(37,99,235,.1); --bg:#F5F8FF; --surface:#FFFFFF; --surface-2:#F8FAFC; --text:#172033; --text-2:#344054; --text-3:#475467; --muted:#64748B; --border:#E2E8F0; --blue:#2563EB; --blue-soft:#EFF6FF; }
        body.admin-layout { color:#172033; background:#F5F8FF; }
        body.admin-layout::before { opacity:.16; background-image:linear-gradient(rgba(37,99,235,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(37,99,235,.025) 1px,transparent 1px); }
        body.admin-layout :focus-visible { outline:3px solid rgba(37,99,235,.7); outline-offset:2px; }
        body.admin-layout .admin-sidebar { background:linear-gradient(180deg,#111C32 0%,#0F172A 55%,#0B1220 100%); border-right-color:#1E293B; }
        body.admin-layout .admin-sidebar-header { background:rgba(15,23,42,.97); border-bottom-color:#26354D; }
        body.admin-layout .admin-sidebar-section-title { color:#A9B8CC; font-size:10px; letter-spacing:.09em; }
        body.admin-layout .admin-sidebar-section-title i { color:#60A5FA; }
        body.admin-layout .admin-sidebar-link { min-height:44px; color:#CBD5E1; font-size:13px; border-radius:10px; }
        body.admin-layout .admin-sidebar-link i { color:#94A3B8; font-size:15px; }
        body.admin-layout .admin-sidebar-link:hover { color:#fff; background:rgba(96,165,250,.12); }
        body.admin-layout .admin-sidebar-link:hover i, body.admin-layout .admin-sidebar-link.active i { color:#93C5FD; }
        body.admin-layout .admin-sidebar-link.active, body.admin-layout .admin-sidebar-link[aria-current=page] { color:#fff; background:linear-gradient(100deg,rgba(37,99,235,.32),rgba(37,99,235,.12)); box-shadow:inset 3px 0 #60A5FA,inset 0 0 0 1px rgba(96,165,250,.16); }
        body.admin-layout .admin-logo-text span { color:#93C5FD; }
        body.admin-layout .admin-topbar { background:rgba(255,255,255,.96); border-color:#E2E8F0; }
        body.admin-layout .admin-content { color:#344054; }
        body.admin-layout .admin-content p, body.admin-layout .admin-content li { line-height:1.6; }
        body.admin-layout .admin-content .text-muted, body.admin-layout .admin-content small { color:#64748B !important; }
        body.admin-layout .admin-card, body.admin-layout .admin-info-card, body.admin-layout .sb-settings-card, body.admin-layout .sb-card, body.admin-layout .seller-card, body.admin-layout .profile-card, body.admin-layout .card, body.admin-layout .admin-stat-card, body.admin-layout .sb-stat-card { color:#344054; background:#fff; border-color:#E2E8F0; box-shadow:0 4px 16px rgba(15,23,42,.045); }
        body.admin-layout .admin-card-title, body.admin-layout .sb-card-title, body.admin-layout .seller-card-title, body.admin-layout .admin-content h1, body.admin-layout .admin-content h2, body.admin-layout .admin-content h3, body.admin-layout .admin-content h4 { color:#172033; }
        body.admin-layout table, body.admin-layout .admin-table, body.admin-layout .seller-table { color:#344054; background:#fff; }
        body.admin-layout table thead th, body.admin-layout .admin-table thead th, body.admin-layout .seller-table thead th { color:#344054; background:#F1F5FB; border-color:#E2E8F0; font-size:12px; }
        body.admin-layout table td, body.admin-layout table th { padding:13px 15px; border-color:#E2E8F0; font-size:13px; line-height:1.5; }
        body.admin-layout table tbody tr:hover { background:#F5F9FF; }
        body.admin-layout table a, body.admin-layout .admin-content a:not(.btn):not(.admin-btn):not(.admin-sidebar-link) { color:#1D4ED8; }
        body.admin-layout input:not([type=checkbox]):not([type=radio]), body.admin-layout select, body.admin-layout textarea, body.admin-layout .form-control, body.admin-layout .form-select, body.admin-layout .sb-form-control, body.admin-layout .admin-input { color:#172033; background-color:#fff; border-color:#CBD5E1; }
        body.admin-layout input::placeholder, body.admin-layout textarea::placeholder { color:#64748B; opacity:1; }
        body.admin-layout select option { color:#172033; background:#fff; }
        body.admin-layout input:focus, body.admin-layout select:focus, body.admin-layout textarea:focus, body.admin-layout .form-control:focus, body.admin-layout .form-select:focus { color:#172033; background-color:#fff; border-color:#2563EB; box-shadow:0 0 0 3px rgba(37,99,235,.14); }
        body.admin-layout input[type=checkbox], body.admin-layout input[type=radio] { accent-color:#2563EB; }
        body.admin-layout .admin-btn-primary, body.admin-layout .sb-btn-primary, body.admin-layout .profile-primary-btn, body.admin-layout .seller-kyc-btn, body.admin-layout button.btn-primary, body.admin-layout a.btn-primary { color:#fff; background:#2563EB; border-color:#2563EB; }
        body.admin-layout .admin-btn-primary:hover, body.admin-layout .sb-btn-primary:hover, body.admin-layout button.btn-primary:hover, body.admin-layout a.btn-primary:hover { background:#1D4ED8; border-color:#1D4ED8; }
        body.admin-layout .admin-btn-secondary, body.admin-layout .sb-btn-secondary, body.admin-layout button.btn-secondary, body.admin-layout a.btn-secondary { color:#1D4ED8; background:#EFF6FF; border-color:#BFDBFE; }
        body.admin-layout .admin-pagination a, body.admin-layout .admin-pagination span, body.admin-layout .pagination a, body.admin-layout .pagination span { color:#344054; background:#fff; border-color:#E2E8F0; }
        body.admin-layout .admin-pagination .active span, body.admin-layout .pagination .active span { color:#fff; background:#2563EB; border-color:#2563EB; }
        body.admin-layout .admin-alert, body.admin-layout .sb-alert, body.admin-layout .alert { color:#344054; background:#fff; border-color:#E2E8F0; }
        body.admin-layout .admin-badge-info { color:#1D4ED8; background:#EFF6FF; border-color:#BFDBFE; }
        body.admin-layout .admin-stat-label, body.admin-layout .sb-stat-label { color:#64748B; }
        body.admin-layout .admin-stat-value { color:#172033; }
        @media(max-width:768px) { body.admin-layout .admin-sidebar-link { font-size:14px; } body.admin-layout .admin-topbar { padding-left:14px; padding-right:14px; flex-wrap:wrap; } body.admin-layout .admin-page-title { line-height:1.25; } body.admin-layout .admin-table-wrap, body.admin-layout .table-responsive { overscroll-behavior-x:contain; } }
        @media(max-width:480px) { body.admin-layout .admin-content { padding-left:12px; padding-right:12px; } body.admin-layout .admin-card, body.admin-layout .sb-settings-card { padding:14px; } body.admin-layout .admin-page-title { font-size:1.35rem; } }
</style>

<link rel="stylesheet" href="{{ asset('css/admin-visual-system.css') }}">

</head>


<body class="admin-layout {{ request()->routeIs('admin.dashboard') ? 'admin-dashboard-page' : '' }}">


    <!-- =========================================================
         MOBILE OVERLAY
    ========================================================== -->

    <div
        class="admin-sidebar-overlay"
        id="adminSidebarOverlay"
    ></div>


    <!-- =========================================================
         SIDEBAR
    ========================================================== -->

    <aside
        class="admin-sidebar"
        id="adminSidebar"
    >

        <!-- BRAND -->

        <div class="admin-sidebar-header">

            <a
                href="{{ route('admin.dashboard') }}"
                class="admin-brand"
            >

                <div class="admin-logo">
                    <i class="fas fa-crown"></i>
                </div>

                <div>

                    <div class="admin-logo-text">
                        SMART <span>BASKET</span>
                    </div>

                    <div class="admin-logo-subtitle">
                        PREMIUM ADMIN CENTER
                    </div>

                </div>

            </a>

        </div>


        <!-- MENU -->

        <nav class="admin-sidebar-menu">


            <!-- DASHBOARD -->

            <div class="admin-sidebar-section">

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    >

                        <span class="admin-dashboard-emoji" aria-hidden="true">🏠</span>

                        <span>Dashboard</span>

                    </a>

                </div>

            </div>


            <!-- CUSTOMERS -->

            <div class="admin-sidebar-section">

                <div class="admin-sidebar-section-title">

                    <i class="fas fa-users"></i>

                    <span>Customers</span>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.customers.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">👥</span>

                        <span>All Customers</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.customers.activity') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.customers.activity') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">🕒</span>

                        <span>Customer Activity</span>

                    </a>

                </div>

            </div>


            <!-- SELLERS -->

            <div class="admin-sidebar-section">

                <div class="admin-sidebar-section-title">

                    <i class="fas fa-store"></i>

                    <span>Sellers</span>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.sellers.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">🏪</span>

                        <span>All Sellers</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.seller-verifications.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.seller-verifications.*') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">🛡️</span>

                        <span>KYC Verification</span>

                        @if($pendingCount > 0)

                            <span class="admin-sidebar-badge">
                                {{ $pendingCount > 99 ? '99+' : $pendingCount }}
                            </span>

                        @endif

                    </a>

                </div>

            </div>


            <!-- PRODUCTS -->

            <div class="admin-sidebar-section">

                <div class="admin-sidebar-section-title">

                    <i class="fas fa-box"></i>

                    <span>Products</span>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">📦</span>

                        <span>All Products</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">🏷️</span>

                        <span>Categories</span>

                    </a>

                </div>

            </div>


            <!-- ORDERS -->

            <div class="admin-sidebar-section">

                <div class="admin-sidebar-section-title">

                    <i class="fas fa-bag-shopping"></i>

                    <span>Orders</span>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">🧾</span>

                        <span>All Orders</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a href="{{ route('admin.deliveries.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.deliveries.*') ? 'active' : '' }}">
                        <span class="admin-menu-emoji" aria-hidden="true">🚚</span>
                        <span>Live Deliveries</span>
                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.returns.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">↩️</span>

                        <span>Returns</span>

                    </a>

                </div>

            </div>


            <!-- PAYMENTS -->

            <div class="admin-sidebar-section">

                <div class="admin-sidebar-section-title">

                    <i class="fas fa-credit-card"></i>

                    <span>Payments</span>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.transactions.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">💸</span>

                        <span>Transactions</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.revenue') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.revenue') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">💰</span>

                        <span>Revenue</span>

                    </a>

                </div>

            </div>


            <!-- MARKETING -->

            <div class="admin-sidebar-section">

                <div class="admin-sidebar-section-title">

                    <i class="fas fa-bullhorn"></i>

                    <span>Marketing</span>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.coupons.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">🎟️</span>

                        <span>Coupons</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.offers.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.offers.*') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">🔥</span>

                        <span>Offers & Deals</span>

                    </a>

                </div>

            </div>


            <!-- ANALYTICS -->

            <div class="admin-sidebar-section">

                <div class="admin-sidebar-section-title">

                    <i class="fas fa-chart-line"></i>

                    <span>Analytics</span>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.analytics.sales') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.analytics.sales') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">📈</span>

                        <span>Sales</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.analytics.customers') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.analytics.customers') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">👥</span>

                        <span>Customers</span>

                    </a>

                </div>

            </div>


            <!-- SYSTEM -->

            <div class="admin-sidebar-section">

                <div class="admin-sidebar-section-title">

                    <i class="fas fa-gear"></i>

                    <span>System</span>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.visual-editor.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.visual-editor.*') ? 'active' : '' }}"
                    >
                        <span class="admin-menu-emoji" aria-hidden="true">🎨</span>
                        <span>Visual Website Editor</span>
                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.audit-logs.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">📋</span>

                        <span>Audit Logs</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.settings') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"
                    >

                        <span class="admin-menu-emoji" aria-hidden="true">⚙️</span>

                        <span>Settings</span>

                    </a>

                </div>

            </div>


            <!-- SIDEBAR FOOTER -->

            <div class="admin-sidebar-footer">

                <div class="admin-sidebar-footer-top">

                    <div class="admin-sidebar-footer-icon">
                        <i class="fas fa-shield-halved"></i>
                    </div>

                    <div>

                        <strong>
                            Admin Protection
                        </strong>

                        <span>
                            Security systems operational
                        </span>

                    </div>

                </div>

                <div class="admin-sidebar-footer-status">
                    <div></div>
                </div>

            </div>


        </nav>

    </aside>


    <!-- =========================================================
         MAIN WRAPPER
    ========================================================== -->

    <div class="admin-main">


        <!-- =====================================================
             TOPBAR
        ====================================================== -->

        <header class="admin-topbar">


            <div class="admin-topbar-left">

                <button
                    type="button"
                    class="admin-menu-toggle"
                    id="menuToggle"
                    aria-label="Open navigation"
                >

                    <i class="fas fa-bars"></i>

                </button>


                <div class="admin-breadcrumbs">

                    <a href="{{ route('admin.dashboard') }}">
                        Admin
                    </a>

                    @foreach($adminBreadcrumbLabels as $breadcrumbLabel)
                        <span class="admin-breadcrumb-separator">/</span>
                        <span class="admin-breadcrumb-label">{{ $breadcrumbLabel }}</span>
                    @endforeach

                </div>

            </div>


            <div class="admin-topbar-right">


                <!-- QUICK SEARCH -->

                <div class="admin-top-search" role="search" aria-label="Search this admin page">

                    <i class="fas fa-magnifying-glass"></i>

                    <input
                        type="search"
                        id="adminPageSearch"
                        placeholder="Search this page..."
                        autocomplete="off"
                        aria-label="Search current admin page"
                        aria-controls="adminPageSearchResults"
                        aria-expanded="false"
                    >

                    <kbd aria-hidden="true">/</kbd>

                    <div class="admin-search-results" id="adminPageSearchResults" role="listbox" aria-label="Page search results" hidden></div>

                </div>


                <!-- NOTIFICATIONS -->

                <div
                    class="admin-notification-wrap"
                    id="notificationWrap"
                >

                    <button
                        type="button"
                        class="admin-topbar-icon"
                        id="notificationButton"
                        title="Notifications"
                        aria-expanded="false"
                    >

                        <i class="far fa-bell"></i>

                        @if($pendingCount > 0)

                            <span class="admin-notification-badge">
                                {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                            </span>

                        @endif

                    </button>


                    <div
                        class="admin-notification-dropdown"
                        id="notificationDropdown"
                    >

                        <div class="admin-notification-header">

                            <strong>
                                Notifications
                            </strong>

                            <span>
                                SmartBasket Admin
                            </span>

                        </div>


                        @if($pendingCount > 0)

                            <a
                                href="{{ route('admin.seller-verifications.index') }}"
                                style="
                                    display:flex;
                                    gap:11px;
                                    padding:14px;
                                    text-decoration:none;
                                    border-bottom:1px solid #f0f2f5;
                                "
                            >

                                <div
                                    style="
                                        width:36px;
                                        height:36px;
                                        display:grid;
                                        place-items:center;
                                        border-radius:11px;
                                        background:#fff8df;
                                        color:#b98300;
                                        flex-shrink:0;
                                    "
                                >

                                    <i class="fas fa-shield-halved"></i>

                                </div>

                                <div>

                                    <strong
                                        style="
                                            display:block;
                                            color:#1d2939;
                                            font-size:9.5px;
                                            margin-bottom:3px;
                                        "
                                    >
                                        Pending KYC Reviews
                                    </strong>

                                    <span
                                        style="
                                            color:#667085;
                                            font-size:8px;
                                            line-height:1.5;
                                        "
                                    >
                                        {{ $pendingCount }}
                                        seller application(s)
                                        require attention.
                                    </span>

                                </div>

                            </a>

                        @else

                            <div class="admin-notification-empty">

                                <i class="fas fa-circle-check"></i>

                                <strong>
                                    You're all caught up
                                </strong>

                                <span>
                                    No new admin notifications
                                    require your attention.
                                </span>

                            </div>

                        @endif

                    </div>

                </div>


                <!-- PROFILE -->

                <div
                    class="admin-topbar-item"
                    id="profileContainer"
                >

                    <div
                        class="admin-profile-menu"
                        id="profileMenu"
                        role="button"
                        tabindex="0"
                        aria-expanded="false"
                    >

                        <div class="admin-profile-avatar">
                            @if($adminAvatarUrl)
                                <img src="{{ $adminAvatarUrl }}" alt="{{ $adminDisplayName }}">
                            @else
                                <i class="fas fa-user-tie" aria-hidden="true"></i>
                            @endif
                        </div>


                        <div class="admin-profile-info">

                            <div class="admin-profile-name">
                                {{ $adminDisplayName }}
                            </div>

                            <div class="admin-profile-role">

                                <span class="admin-online-dot"></span>

                                Administrator

                            </div>

                        </div>


                        <i
                            class="fas fa-chevron-down admin-profile-chevron"
                        ></i>


                        <!-- PROFILE DROPDOWN -->

                        <div
                            class="admin-profile-dropdown"
                            id="profileDropdown"
                        >

                            <!-- HEADER -->

                            <div class="admin-profile-dropdown-header">

                                <div class="admin-profile-dropdown-header-row">

                                    <div class="admin-mini-avatar">
                                        @if($adminAvatarUrl)
                                            <img src="{{ $adminAvatarUrl }}" alt="{{ $adminDisplayName }}">
                                        @else
                                            <i class="fas fa-user-tie" aria-hidden="true"></i>
                                        @endif
                                    </div>

                                    <div>

                                        <strong>
                                            {{ $adminDisplayName }}
                                        </strong>

                                        <span>
                                            SmartBasket Administrator
                                        </span>

                                    </div>

                                </div>

                            </div>


                            <!-- MY PROFILE -->

                            @if(Route::has('admin.profile'))

                                <a
                                    href="{{ route('admin.profile') }}"
                                    class="admin-profile-dropdown-item"
                                >

                                    <i class="fa-regular fa-user"></i>

                                    <span>
                                        My Profile
                                    </span>

                                </a>

                            @else

                                <a
                                    href="{{ route('admin.settings') }}"
                                    class="admin-profile-dropdown-item"
                                >

                                    <i class="fa-regular fa-user"></i>

                                    <span>
                                        My Profile
                                    </span>

                                </a>

                            @endif


                            <!-- SECURITY -->

                            @if(Route::has('admin.security'))

                                <a
                                    href="{{ route('admin.security') }}"
                                    class="admin-profile-dropdown-item"
                                >

                                    <i class="fa-solid fa-shield-halved"></i>

                                    <span>
                                        Security
                                    </span>

                                </a>

                            @else

                                <a
                                    href="{{ route('admin.settings') }}#security"
                                    class="admin-profile-dropdown-item"
                                >

                                    <i class="fa-solid fa-shield-halved"></i>

                                    <span>
                                        Security
                                    </span>

                                </a>

                            @endif


                            <!-- SETTINGS -->

                            @if(Route::has('admin.settings'))

                                <a
                                    href="{{ route('admin.settings') }}"
                                    class="admin-profile-dropdown-item"
                                >

                                    <i class="fa-solid fa-gear"></i>

                                    <span>
                                        Admin Settings
                                    </span>

                                </a>

                            @endif


                            <!-- DIVIDER -->

                            <div class="admin-profile-divider"></div>


                            <!-- LOGOUT -->

                            @if(Route::has('admin.logout'))

                                <form
                                    method="POST"
                                    action="{{ route('admin.logout') }}"
                                    class="admin-logout-form"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="admin-profile-dropdown-item"
                                    >

                                        <i class="fa-solid fa-right-from-bracket"></i>

                                        <span>
                                            Logout
                                        </span>

                                    </button>

                                </form>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </header>


        <!-- =====================================================
             CONTENT
        ====================================================== -->

        <main class="admin-content">


            <!-- SUCCESS -->

            @if(session('success'))

                <div class="admin-alert admin-alert-success">

                    <div class="admin-alert-icon">
                        <i class="fas fa-circle-check"></i>
                    </div>

                    <div>
                        {{ session('success') }}
                    </div>

                    <button
                        type="button"
                        class="admin-alert-close"
                        aria-label="Close"
                    >

                        <i class="fas fa-xmark"></i>

                    </button>

                </div>

            @endif


            <!-- ERROR -->

            @if(session('error'))

                <div class="admin-alert admin-alert-danger">

                    <div class="admin-alert-icon">
                        <i class="fas fa-circle-exclamation"></i>
                    </div>

                    <div>
                        {{ session('error') }}
                    </div>

                    <button
                        type="button"
                        class="admin-alert-close"
                        aria-label="Close"
                    >

                        <i class="fas fa-xmark"></i>

                    </button>

                </div>

            @endif


            <!-- WARNING -->

            @if(session('warning'))

                <div class="admin-alert admin-alert-warning">

                    <div class="admin-alert-icon">
                        <i class="fas fa-triangle-exclamation"></i>
                    </div>

                    <div>
                        {{ session('warning') }}
                    </div>

                    <button
                        type="button"
                        class="admin-alert-close"
                        aria-label="Close"
                    >

                        <i class="fas fa-xmark"></i>

                    </button>

                </div>

            @endif


            <!-- INFO -->

            @if(session('info'))

                <div class="admin-alert admin-alert-info">

                    <div class="admin-alert-icon">
                        <i class="fas fa-circle-info"></i>
                    </div>

                    <div>
                        {{ session('info') }}
                    </div>

                    <button
                        type="button"
                        class="admin-alert-close"
                        aria-label="Close"
                    >

                        <i class="fas fa-xmark"></i>

                    </button>

                </div>

            @endif


            <!-- =================================================
                 IMPORTANT
                 ALL ADMIN PAGES RENDER HERE
            ================================================== -->

            @yield('content')


        </main>


        <!-- =====================================================
             FOOTER
        ====================================================== -->

        <footer class="admin-footer">

            <div>

                <strong>
                    SMARTBASKET
                </strong>

                Admin Control Center

                © {{ date('Y') }}

            </div>

            <div class="admin-footer-right">

                <span class="admin-footer-dot"></span>

                All systems operational

            </div>

        </footer>


    </div>


    <!-- =========================================================
         JAVASCRIPT
    ========================================================== -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            // Use clear, page-specific emoji for every admin navigation link.
            const adminMenuEmoji = [
                [/dashboard/i, '🏠'],
                [/all customers|customers/i, '👥'],
                [/customer activity/i, '🕒'],
                [/all sellers|sellers/i, '🏪'],
                [/kyc|verification/i, '🛡️'],
                [/products/i, '📦'],
                [/categor/i, '🏷️'],
                [/orders/i, '🧾'],
                [/returns/i, '↩️'],
                [/transaction|payment/i, '💸'],
                [/revenue/i, '💰'],
                [/coupon/i, '🎟️'],
                [/offer|deal/i, '🔥'],
                [/sales|analytic/i, '📈'],
                [/visual website editor/i, '🎨'],
                [/audit/i, '📋'],
                [/setting/i, '⚙️'],
            ];

            const adminPageEmoji = [
                [/dashboard|overview|welcome back/i, '🏠'],
                [/setting|configuration|preference/i, '⚙️'],
                [/profile|administrator account/i, '👤'],
                [/kyc|verification|security/i, '🛡️'],
                [/activity/i, '🕒'],
                [/customer/i, '👥'],
                [/seller/i, '🏪'],
                [/product|catalog|inventory/i, '📦'],
                [/categor/i, '🏷️'],
                [/order/i, '🧾'],
                [/return|refund/i, '↩️'],
                [/payment|transaction/i, '💳'],
                [/revenue|payout/i, '💰'],
                [/coupon/i, '🎟️'],
                [/offer|deal/i, '🔥'],
                [/analytic|sales/i, '📈'],
                [/audit|log/i, '📋'],
                [/editor|design/i, '🎨'],
            ];
            const adminRouteName = @json(request()->route()?->getName() ?? '');

            document.querySelectorAll('.admin-sidebar-link').forEach(function (link) {
                const label = Array.from(link.children)
                    .filter(function (child) {
                        return child.tagName === 'SPAN' &&
                            !child.classList.contains('admin-sidebar-badge') &&
                            !child.classList.contains('admin-dashboard-emoji') &&
                            !child.classList.contains('admin-menu-emoji');
                    })[0]?.textContent.trim() || '';
                const matchedEmoji = adminMenuEmoji.find(function ([pattern]) {
                    return pattern.test(label);
                })?.[1] || '🔹';
                let icon = link.querySelector(':scope > .admin-dashboard-emoji, :scope > .admin-menu-emoji');

                if (!icon) {
                    const oldIcon = link.querySelector(':scope > i');
                    if (!oldIcon) return;

                    icon = document.createElement('span');
                    icon.className = 'admin-menu-emoji';
                    icon.setAttribute('aria-hidden', 'true');
                    oldIcon.replaceWith(icon);
                }

                icon.textContent = matchedEmoji;
            });

            // Give each admin page heading the same branded blue title hero.
            const adminContent = document.querySelector('body.admin-layout .admin-content');
            // The settings page had a separate gear beside the heading; the
            // shared title emoji now owns that single visual icon spot.
            if (/setting/i.test(adminRouteName)) {
                adminContent?.querySelector('.sb-settings-main-icon')?.remove();
            }

            if (adminContent && !adminContent.querySelector('.ve-shell')) {
                const pageTitle = Array.from(adminContent.querySelectorAll('h1')).find(function (heading) {
                    return !heading.closest('.ve-shell, .modal, .dropdown-menu, .admin-content .admin-content');
                });

                if (pageTitle) {
                    let titleHero = pageTitle.closest('.admin-page-header, .seller-page-header, .sb-dashboard-hero, .sb-settings-header, .profile-hero');

                    if (!titleHero) {
                        titleHero = document.createElement('section');
                        titleHero.className = 'admin-title-hero';
                        pageTitle.parentNode.insertBefore(titleHero, pageTitle);
                        titleHero.appendChild(pageTitle);

                        const subtitle = titleHero.nextElementSibling;
                        if (subtitle && subtitle.tagName === 'P') {
                            titleHero.appendChild(subtitle);
                        }
                    } else {
                        titleHero.classList.add('admin-title-hero');
                    }

                    // Keep exactly one page icon: the emoji beside the title.
                    titleHero.querySelectorAll('.admin-page-icon, .seller-page-icon, .sb-settings-main-icon')
                        .forEach(function (icon) { icon.remove(); });

                    const titleText = `${adminRouteName} ${pageTitle.textContent.replace(/\s+/g, ' ').trim()}`;
                    const titleEmoji = adminPageEmoji.find(function ([pattern]) {
                        return pattern.test(titleText);
                    })?.[1] || '🗂️';
                    let titleMark = pageTitle.querySelector(':scope > .admin-title-emoji');

                    if (!titleMark) {
                        titleMark = document.createElement('span');
                        titleMark.className = 'admin-title-emoji';
                        titleMark.setAttribute('aria-hidden', 'true');
                        pageTitle.insertBefore(titleMark, pageTitle.firstChild);
                    }

                    titleMark.textContent = titleEmoji;
                    pageTitle.querySelectorAll(':scope > i.fa, :scope > i.fas, :scope > i.far, :scope > i.fa-solid, :scope > i.fa-regular')
                        .forEach(function (icon) { icon.remove(); });

                }
            }

            const editorTitle = adminContent?.querySelector('.ve-shell .ve-heading h1');
            if (editorTitle) {
                const editorContext = `${adminRouteName} ${editorTitle.textContent.replace(/\s+/g, ' ').trim()}`;
                const editorEmoji = adminPageEmoji.find(function ([pattern]) {
                    return pattern.test(editorContext);
                })?.[1] || '🎨';
                const editorMark = editorTitle.closest('.ve-heading-top')?.querySelector('.ve-brand-icon');

                if (editorMark) {
                    editorMark.classList.add('admin-title-emoji-mark');
                    editorMark.textContent = editorEmoji;
                }
            }

            /* =================================================
               ELEMENTS
            ================================================= */

            const sidebar =
                document.getElementById('adminSidebar');

            const menuToggle =
                document.getElementById('menuToggle');

            const overlay =
                document.getElementById('adminSidebarOverlay');

            const profileMenu =
                document.getElementById('profileMenu');

            const profileDropdown =
                document.getElementById('profileDropdown');

            const notificationButton =
                document.getElementById('notificationButton');

            const notificationDropdown =
                document.getElementById('notificationDropdown');


            /* =================================================
               SIDEBAR
            ================================================= */

            function openSidebar() {

                sidebar?.classList.add('mobile-open');

                overlay?.classList.add('active');

                document.body.style.overflow = 'hidden';
            }


            function closeSidebar() {

                sidebar?.classList.remove('mobile-open');

                overlay?.classList.remove('active');

                document.body.style.overflow = '';
            }


            menuToggle?.addEventListener('click', function (event) {

                event.stopPropagation();

                if (
                    sidebar?.classList.contains('mobile-open')
                ) {

                    closeSidebar();

                } else {

                    openSidebar();

                }

            });


            overlay?.addEventListener(
                'click',
                closeSidebar
            );


            document
                .querySelectorAll('.admin-sidebar-link')
                .forEach(function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            if (window.innerWidth <= 768) {
                                closeSidebar();
                            }

                        }
                    );

                });


            window.addEventListener(
                'resize',
                function () {

                    if (window.innerWidth > 768) {
                        closeSidebar();
                    }

                }
            );


            /* =================================================
               PROFILE
            ================================================= */

            function closeProfileDropdown() {

                profileDropdown?.classList.remove('active');

                profileMenu?.classList.remove('open');

                profileMenu?.setAttribute(
                    'aria-expanded',
                    'false'
                );
            }


            function openProfileDropdown() {

                closeNotifications();

                profileDropdown?.classList.add('active');

                profileMenu?.classList.add('open');

                profileMenu?.setAttribute(
                    'aria-expanded',
                    'true'
                );
            }


            profileMenu?.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    /*
                     * Don't toggle when clicking links/buttons/forms
                     * inside the dropdown.
                     */

                    if (
                        event.target.closest(
                            '.admin-profile-dropdown a, .admin-profile-dropdown button'
                        )
                    ) {
                        return;
                    }

                    const isOpen =
                        profileDropdown?.classList.contains('active');

                    if (isOpen) {
                        closeProfileDropdown();
                    } else {
                        openProfileDropdown();
                    }

                }
            );


            profileMenu?.addEventListener(
                'keydown',
                function (event) {

                    if (
                        event.key === 'Enter' ||
                        event.key === ' '
                    ) {

                        event.preventDefault();

                        profileMenu.click();

                    }

                }
            );


            /* =================================================
               NOTIFICATIONS
            ================================================= */

            function closeNotifications() {

                notificationDropdown?.classList.remove('active');

                notificationButton?.setAttribute(
                    'aria-expanded',
                    'false'
                );
            }


            function openNotifications() {

                closeProfileDropdown();

                notificationDropdown?.classList.add('active');

                notificationButton?.setAttribute(
                    'aria-expanded',
                    'true'
                );
            }


            notificationButton?.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    const isOpen =
                        notificationDropdown?.classList.contains(
                            'active'
                        );

                    if (isOpen) {

                        closeNotifications();

                    } else {

                        openNotifications();

                    }

                }
            );


            notificationDropdown?.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                }
            );


            /* =================================================
               GLOBAL CLICK
            ================================================= */

            document.addEventListener(
                'click',
                function () {

                    closeProfileDropdown();

                    closeNotifications();

                }
            );


            /* =================================================
               KEYBOARD
            ================================================= */

            const pageSearchInput = document.getElementById('adminPageSearch');
            const pageSearchResults = document.getElementById('adminPageSearchResults');
            const pageSearchContent = document.querySelector('.admin-content');

            if (pageSearchInput && pageSearchResults && pageSearchContent) {
                const collectPageSearchTargets = function () {
                    const tableRows = Array.from(pageSearchContent.querySelectorAll('table tbody tr'))
                        .filter(function (row) { return !row.closest('.ve-shell') && row.textContent.trim(); });

                    if (tableRows.length) return tableRows;

                    const cardSelector = [
                        '.sb-list-item', '.admin-list-item', '.seller-order-card', '.admin-product-card',
                        '.seller-product-card', '.sb-quick-action', '.sb-stat-card', '.admin-stat-card',
                        '.sb-settings-card', '.admin-info-card', '.seller-card', '.sb-card', '.admin-card'
                    ].join(',');
                    const cards = Array.from(pageSearchContent.querySelectorAll(cardSelector))
                        .filter(function (card) { return !card.closest('.ve-shell') && card.textContent.trim(); });
                    const leafCards = cards.filter(function (card) {
                        return !cards.some(function (other) { return other !== card && card.contains(other); });
                    });

                    if (leafCards.length) return leafCards;

                    return Array.from(pageSearchContent.querySelectorAll('h1, h2, h3, h4, p, li, td, dd, dt, label, a, button'))
                        .filter(function (element) {
                            return !element.closest('.ve-shell, .modal, .dropdown-menu') &&
                                element.textContent.trim() &&
                                !element.querySelector('h1, h2, h3, h4, p, li, td, dd, dt, label, a, button');
                        });
                };

                const closePageSearchResults = function () {
                    pageSearchResults.hidden = true;
                    pageSearchResults.replaceChildren();
                    pageSearchInput.setAttribute('aria-expanded', 'false');
                };

                pageSearchInput.addEventListener('input', function () {
                    const query = this.value.trim().toLocaleLowerCase();
                    pageSearchResults.replaceChildren();

                    if (!query) {
                        closePageSearchResults();
                        return;
                    }

                    const matches = collectPageSearchTargets()
                        .filter(function (element) { return element.textContent.toLocaleLowerCase().includes(query); })
                        .slice(0, 8);

                    if (!matches.length) {
                        const empty = document.createElement('div');
                        empty.className = 'admin-search-empty';
                        empty.textContent = 'No matches on this page';
                        pageSearchResults.appendChild(empty);
                    } else {
                        matches.forEach(function (element) {
                            const result = document.createElement('button');
                            result.type = 'button';
                            result.className = 'admin-search-result';
                            result.setAttribute('role', 'option');
                            result.textContent = element.textContent.replace(/\s+/g, ' ').trim().slice(0, 150);
                            result.addEventListener('click', function () {
                                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                element.classList.add('admin-search-highlight');
                                window.setTimeout(function () { element.classList.remove('admin-search-highlight'); }, 1800);
                                closePageSearchResults();
                            });
                            pageSearchResults.appendChild(result);
                        });
                    }

                    pageSearchResults.hidden = false;
                    pageSearchInput.setAttribute('aria-expanded', 'true');
                });

                pageSearchInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') closePageSearchResults();
                });

                document.addEventListener('click', function (event) {
                    if (!event.target.closest('.admin-top-search')) closePageSearchResults();
                });
            }

            document.addEventListener(
                'keydown',
                function (event) {

                    const activeElement =
                        document.activeElement;

                    const tagName =
                        activeElement?.tagName || '';

                    if (
                        event.key === '/' &&
                        ![
                            'INPUT',
                            'TEXTAREA',
                            'SELECT'
                        ].includes(tagName)
                    ) {

                        event.preventDefault();

                        const search = document.getElementById('adminPageSearch');

                        search?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });
                        search?.focus();

                    }


                    if (event.key === 'Escape') {

                        closeProfileDropdown();

                        closeNotifications();

                        closeSidebar();

                    }

                }
            );


            /* =================================================
               ALERT CLOSE
            ================================================= */

            document
                .querySelectorAll('.admin-alert-close')
                .forEach(function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            const alert =
                                this.closest('.admin-alert');

                            if (!alert) {
                                return;
                            }

                            alert.style.opacity = '0';

                            alert.style.transform =
                                'translateY(-5px)';

                            setTimeout(
                                function () {

                                    alert.remove();

                                },
                                220
                            );

                        }
                    );

                });


            /* =================================================
               AUTO CLOSE ALERT
            ================================================= */

            document
                .querySelectorAll('.admin-alert')
                .forEach(function (alert) {

                    setTimeout(
                        function () {

                            if (
                                !document.body.contains(alert)
                            ) {
                                return;
                            }

                            alert.style.opacity = '0';

                            alert.style.transform =
                                'translateY(-5px)';

                            setTimeout(
                                function () {

                                    if (alert.parentNode) {
                                        alert.remove();
                                    }

                                },
                                220
                            );

                        },
                        6000
                    );

                });

        });

    </script>


    @yield('extra-js')

</body>

</html>
