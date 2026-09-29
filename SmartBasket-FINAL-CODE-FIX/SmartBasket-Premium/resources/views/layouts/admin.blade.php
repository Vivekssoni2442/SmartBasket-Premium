<!DOCTYPE html>
<html lang="en">

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


        @media(prefers-reduced-motion:reduce) {

            *,
            *::before,
            *::after {

                animation-duration: .01ms !important;

                animation-iteration-count: 1 !important;

                transition-duration: .01ms !important;

                scroll-behavior: auto !important;
            }
        }

    </style>

    @yield('extra-css')

</head>


<body>


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

                        <i class="fas fa-grid-2"></i>

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

                        <i class="fas fa-user-group"></i>

                        <span>All Customers</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.customers.activity') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.customers.activity') ? 'active' : '' }}"
                    >

                        <i class="fas fa-clock-rotate-left"></i>

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

                        <i class="fas fa-store"></i>

                        <span>All Sellers</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.seller-verifications.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.seller-verifications.*') ? 'active' : '' }}"
                    >

                        <i class="fas fa-shield-halved"></i>

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

                        <i class="fas fa-boxes-stacked"></i>

                        <span>All Products</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                    >

                        <i class="fas fa-tags"></i>

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

                        <i class="fas fa-receipt"></i>

                        <span>All Orders</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.returns.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}"
                    >

                        <i class="fas fa-arrow-rotate-left"></i>

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

                        <i class="fas fa-money-bill-transfer"></i>

                        <span>Transactions</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.revenue') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.revenue') ? 'active' : '' }}"
                    >

                        <i class="fas fa-chart-pie"></i>

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

                        <i class="fas fa-ticket"></i>

                        <span>Coupons</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.offers.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.offers.*') ? 'active' : '' }}"
                    >

                        <i class="fas fa-fire"></i>

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

                        <i class="fas fa-chart-area"></i>

                        <span>Sales</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.analytics.customers') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.analytics.customers') ? 'active' : '' }}"
                    >

                        <i class="fas fa-user-group"></i>

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
                        href="{{ route('admin.audit-logs.index') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}"
                    >

                        <i class="fas fa-file-shield"></i>

                        <span>Audit Logs</span>

                    </a>

                </div>

                <div class="admin-sidebar-item">

                    <a
                        href="{{ route('admin.settings') }}"
                        class="admin-sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"
                    >

                        <i class="fas fa-sliders"></i>

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

                    <span>/</span>

                    @yield('breadcrumbs')

                </div>

            </div>


            <div class="admin-topbar-right">


                <!-- QUICK SEARCH -->

                <div class="admin-top-search">

                    <i class="fas fa-magnifying-glass"></i>

                    <span>
                        Quick search
                    </span>

                    <kbd>
                        /
                    </kbd>

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
                            {{ $adminInitials }}
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
                                        {{ $adminInitials }}
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

                        const search =
                            document.querySelector(
                                '.admin-top-search'
                            );

                        search?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });

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