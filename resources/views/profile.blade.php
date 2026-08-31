<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Profile | SMART BASKET</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >

    <style>

        :root {
            --bg: #f5f7fb;
            --card: rgba(255,255,255,.90);
            --solid: #ffffff;
            --text: #111827;
            --muted: #64748b;
            --border: rgba(15,23,42,.08);
            --input: #ffffff;
            --input-border: #dbe3ef;
            --primary: #2563eb;
            --purple: #7c3aed;
            --gold: #b8860b;
            --gold2: #e4bd50;
            --green: #16a34a;
            --red: #dc2626;

            --shadow:
                0 25px 70px rgba(15,23,42,.10);
        }

        html[data-theme="dark"] {
            --bg: #020617;
            --card: rgba(15,23,42,.88);
            --solid: #0f172a;
            --text: #f8fafc;
            --muted: #94a3b8;
            --border: rgba(255,255,255,.09);
            --input: #111c31;
            --input-border: rgba(255,255,255,.12);
            --primary: #3b82f6;
            --purple: #8b5cf6;
            --gold: #d2a93b;
            --gold2: #f0cc64;
            --green: #22c55e;
            --red: #ef4444;

            --shadow:
                0 30px 90px rgba(0,0,0,.48);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            color: var(--text);

            background:
                radial-gradient(
                    circle at 5% 5%,
                    rgba(37,99,235,.13),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 95% 10%,
                    rgba(124,58,237,.12),
                    transparent 28%
                ),
                var(--bg);

            transition:
                background .35s ease,
                color .35s ease;
        }


        /* =====================================================
           3 DOTS MENU
        ===================================================== */

        .profile-menu-wrap {
            position: fixed;
            top: 22px;
            right: 24px;
            z-index: 99999;
        }

        .profile-menu-button {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid var(--border);
            border-radius: 15px;

            color: var(--text);
            background: var(--card);

            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);

            box-shadow:
                0 12px 35px rgba(15,23,42,.13);

            cursor: pointer;

            transition:
                transform .22s ease,
                background .22s ease,
                color .22s ease,
                box-shadow .22s ease;
        }

        .profile-menu-button:hover {
            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--purple)
                );

            transform: translateY(-2px);

            box-shadow:
                0 16px 40px
                rgba(37,99,235,.25);
        }

        .profile-menu-button i {
            font-size: 20px;
            transition: transform .25s ease;
        }

        .profile-menu-wrap.open
        .profile-menu-button i {
            transform: rotate(90deg);
        }

        .profile-menu {
            position: absolute;

            top: 58px;
            right: 0;

            width: 245px;

            padding: 9px;

            border-radius: 20px;

            background: var(--card);

            border:
                1px solid
                var(--border);

            box-shadow:
                0 25px 70px
                rgba(15,23,42,.20);

            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);

            opacity: 0;
            visibility: hidden;

            transform:
                translateY(-8px)
                scale(.97);

            transform-origin: top right;

            transition:
                opacity .2s ease,
                visibility .2s ease,
                transform .2s ease;
        }

        .profile-menu-wrap.open
        .profile-menu {
            opacity: 1;
            visibility: visible;

            transform:
                translateY(0)
                scale(1);
        }

        .menu-user {
            display: flex;
            align-items: center;
            gap: 11px;

            padding: 10px 10px 12px;

            margin-bottom: 5px;

            border-bottom:
                1px solid
                var(--border);
        }

        .menu-user-avatar {
            width: 38px;
            height: 38px;

            flex: 0 0 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            overflow: hidden;

            color: #fff;

            font-weight: 900;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--purple)
                );
        }

        .menu-user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .menu-user-info {
            min-width: 0;
        }

        .menu-user-name {
            font-size: 13px;
            font-weight: 900;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-user-email {
            margin-top: 2px;

            color: var(--muted);

            font-size: 10px;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-menu-item {
            width: 100%;

            display: flex;
            align-items: center;
            gap: 11px;

            padding: 11px 12px;

            border: 0;
            border-radius: 13px;

            text-decoration: none;

            color: var(--text);

            background: transparent;

            font-size: 13px;
            font-weight: 750;

            cursor: pointer;

            transition:
                background .18s ease,
                color .18s ease,
                transform .18s ease;
        }

        .profile-menu-item:hover {
            color: var(--primary);

            background:
                rgba(37,99,235,.08);

            transform:
                translateX(2px);
        }

        .profile-menu-item .menu-icon {
            width: 32px;
            height: 32px;

            flex: 0 0 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            color: var(--primary);

            background:
                rgba(37,99,235,.08);
        }

        .profile-menu-item.danger {
            color: var(--red);
        }

        .profile-menu-item.danger .menu-icon {
            color: var(--red);

            background:
                rgba(239,68,68,.08);
        }

        .menu-divider {
            height: 1px;

            margin: 6px 5px;

            background:
                var(--border);
        }

        .menu-badge {
            margin-left: auto;

            padding: 4px 7px;

            border-radius: 999px;

            color: var(--primary);

            background:
                rgba(37,99,235,.08);

            font-size: 9px;
            font-weight: 900;
        }

        @media (max-width: 767px) {

            .profile-menu-wrap {
                top: 12px;
                right: 12px;
            }

            .profile-menu-button {
                width: 44px;
                height: 44px;
                border-radius: 13px;
            }

            .profile-menu {
                position: fixed;

                top: 64px;
                right: 10px;

                width:
                    min(280px, calc(100vw - 20px));
            }
        }


        /* =====================================================
           MAIN
        ===================================================== */

        .page {
            min-height: 100vh;

            padding:
                35px
                18px
                100px;
        }

        .container-premium {
            max-width: 1250px;
            margin: auto;
        }


        /* =====================================================
           TOP BAR
        ===================================================== */

        .topbar {
            display: flex;

            justify-content: space-between;
            align-items: center;

            gap: 20px;

            margin-bottom: 25px;

            padding-right: 60px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .brand-logo {
            width: 48px;
            height: 48px;

            border-radius: 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;

            font-size: 20px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--purple)
                );

            box-shadow:
                0 12px 30px
                rgba(37,99,235,.25);
        }

        .brand h1 {
            margin: 0;

            font-size: 25px;

            font-weight: 900;
        }

        .brand p {
            margin: 2px 0 0;

            color: var(--muted);

            font-size: 13px;
        }

        .continue-btn {
            text-decoration: none;

            color: var(--text);

            border:
                1px solid
                var(--border);

            background:
                var(--card);

            padding:
                11px
                17px;

            border-radius: 14px;

            font-weight: 750;

            backdrop-filter: blur(18px);

            transition: .25s ease;
        }

        .continue-btn:hover {
            color: white;

            background:
                var(--primary);

            transform:
                translateY(-2px);
        }


        /* =====================================================
           ALERT
        ===================================================== */

        .alert-premium {
            border:
                1px solid
                var(--border);

            border-radius: 17px;

            background:
                var(--card);

            color:
                var(--text);

            padding:
                15px
                18px;

            margin-bottom: 22px;

            box-shadow:
                var(--shadow);

            backdrop-filter:
                blur(18px);
        }


        /* =====================================================
           CARDS
        ===================================================== */

        .card-premium {
            position: relative;

            overflow: hidden;

            border:
                1px solid
                var(--border);

            border-radius: 27px;

            background:
                var(--card);

            box-shadow:
                var(--shadow);

            backdrop-filter:
                blur(22px);

            -webkit-backdrop-filter:
                blur(22px);

            transition:
                transform .3s ease,
                box-shadow .3s ease;
        }

        .card-premium::before {
            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            top: -120px;
            right: -100px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(59,130,246,.13),
                    transparent 70%
                );

            pointer-events: none;
        }

        .card-premium:hover {
            transform:
                translateY(-3px);

            box-shadow:
                0 32px 80px
                rgba(15,23,42,.14);
        }


        /* =====================================================
           PROFILE HERO
        ===================================================== */

        .profile-hero {
            text-align: center;

            padding:
                32px
                20px
                25px;

            position: relative;

            z-index: 2;
        }

        .avatar-zone {
            position: relative;

            width: 152px;
            height: 152px;

            margin:
                0 auto
                18px;
        }

        .avatar-ring {
            position: absolute;

            inset: 0;

            padding: 3px;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #8b6508,
                    #c49a28,
                    #f1d778,
                    #b8860b,
                    #8b6508
                );

            box-shadow:
                0 8px 25px
                rgba(139,101,8,.22);

            z-index: 1;
        }

        .avatar-inner {
            width: 100%;
            height: 100%;

            padding: 3px;

            border-radius: 50%;

            background:
                var(--solid);
        }

        .avatar,
        .avatar-placeholder {
            width: 100%;
            height: 100%;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            overflow: hidden;
        }

        .avatar {
            object-fit: cover;
        }

        .avatar-placeholder {
            color: white;

            font-size: 50px;

            font-weight: 900;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--purple)
                );
        }

        .online {
            position: absolute;

            width: 20px;
            height: 20px;

            right: 5px;
            bottom: 9px;

            border-radius: 50%;

            background:
                #22c55e;

            border:
                4px solid
                var(--solid);

            z-index: 8;

            box-shadow:
                0 0 0 3px
                rgba(34,197,94,.16);
        }


        /* =====================================================
           100% STAR CELEBRATION
        ===================================================== */

        .celebration-stars {
            position: absolute;

            inset: -35px;

            pointer-events: none;

            z-index: 10;

            opacity: 0;
        }

        .profile-complete .celebration-stars {
            opacity: 1;
        }

        .star {
            position: absolute;

            color:
                #f5c542;

            font-size:
                14px;

            filter:
                drop-shadow(
                    0 0 8px
                    rgba(245,197,66,.8)
                );

            animation:
                starCelebrate
                2.8s
                ease-out
                infinite;
        }

        .star:nth-child(1) {
            left: 50%;
            top: 0;
            animation-delay: .1s;
        }

        .star:nth-child(2) {
            right: 7%;
            top: 25%;
            animation-delay: .35s;
        }

        .star:nth-child(3) {
            right: 12%;
            bottom: 13%;
            animation-delay: .6s;
        }

        .star:nth-child(4) {
            left: 15%;
            bottom: 8%;
            animation-delay: .85s;
        }

        .star:nth-child(5) {
            left: 0;
            top: 28%;
            animation-delay: 1.1s;
        }

        .star:nth-child(6) {
            left: 25%;
            top: 5%;
            animation-delay: 1.35s;
        }

        .star:nth-child(7) {
            right: 24%;
            top: 3%;
            animation-delay: 1.6s;
        }

        .star:nth-child(8) {
            left: 7%;
            bottom: 27%;
            animation-delay: 1.85s;
        }

        @keyframes starCelebrate {

            0% {
                opacity: 0;

                transform:
                    scale(.2)
                    rotate(0deg)
                    translateY(10px);
            }

            20% {
                opacity: 1;

                transform:
                    scale(1.35)
                    rotate(45deg);
            }

            50% {
                opacity: 1;

                transform:
                    scale(.85)
                    rotate(120deg);
            }

            80% {
                opacity: .7;

                transform:
                    scale(1.15)
                    rotate(220deg)
                    translateY(-8px);
            }

            100% {
                opacity: 0;

                transform:
                    scale(.2)
                    rotate(360deg)
                    translateY(-20px);
            }
        }

        .profile-complete .avatar-ring {
            animation:
                premiumRing
                1.8s
                ease-in-out
                infinite;
        }

        @keyframes premiumRing {

            0%,
            100% {
                box-shadow:
                    0 8px 25px
                    rgba(139,101,8,.22);
            }

            50% {
                box-shadow:
                    0 0 0 6px
                    rgba(228,189,80,.10),
                    0 0 30px
                    rgba(228,189,80,.55),
                    0 10px 35px
                    rgba(139,101,8,.35);
            }
        }

        .completion-badge {
            display: inline-flex;

            align-items: center;

            gap: 7px;

            margin-top: 13px;

            padding:
                7px
                13px;

            border-radius: 999px;

            color:
                var(--gold);

            background:
                rgba(212,175,55,.10);

            border:
                1px solid
                rgba(212,175,55,.25);

            font-size: 12px;

            font-weight: 850;
        }

        .completion-badge.complete {
            color:
                #a87900;

            background:
                linear-gradient(
                    135deg,
                    rgba(245,197,66,.16),
                    rgba(255,224,120,.09)
                );

            border-color:
                rgba(212,175,55,.40);

            box-shadow:
                0 0 25px
                rgba(212,175,55,.13);
        }

        html[data-theme="dark"]
        .completion-badge.complete {
            color:
                #f0cc64;
        }


        /* =====================================================
           PROFILE COMPLETION
        ===================================================== */

        .completion-box {
            margin:
                0 20px
                24px;

            padding:
                17px;

            border-radius:
                18px;

            background:
                rgba(37,99,235,.06);

            border:
                1px solid
                rgba(37,99,235,.12);
        }

        .completion-top {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 9px;
        }

        .completion-title {
            font-size: 13px;

            font-weight: 850;
        }

        .completion-percent {
            font-size: 15px;

            font-weight: 950;

            color:
                var(--primary);
        }

        .progress {
            height: 9px;

            border-radius: 999px;

            background:
                rgba(100,116,139,.13);

            overflow: hidden;
        }

        .progress-bar {
            border-radius: 999px;

            background:
                linear-gradient(
                    90deg,
                    var(--primary),
                    var(--purple)
                );

            transition:
                width .8s
                cubic-bezier(.2,.8,.2,1);
        }

        .profile-complete .progress-bar {
            background:
                linear-gradient(
                    90deg,
                    #b8860b,
                    #e8c85c,
                    #b8860b
                );

            background-size:
                200% 100%;

            animation:
                goldMove
                2s
                linear
                infinite;
        }

        @keyframes goldMove {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 200% 0;
            }
        }


        /* =====================================================
           SECTION
        ===================================================== */

        .section {
            padding:
                25px;
        }

        .section-title {
            display: flex;

            align-items: center;

            gap: 11px;

            margin-bottom: 20px;
        }

        .section-icon {
            width: 40px;
            height: 40px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 12px;

            color:
                var(--primary);

            background:
                rgba(37,99,235,.08);
        }

        .section-title h2 {
            margin: 0;

            font-size: 18px;

            font-weight: 900;
        }

        .section-title p {
            margin: 2px 0 0;

            color:
                var(--muted);

            font-size: 12px;
        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-label {
            color:
                var(--text);

            font-size:
                12px;

            font-weight:
                800;

            margin-bottom:
                7px;
        }

        .form-control,
        .form-select {
            min-height:
                49px;

            color:
                var(--text) !important;

            background:
                var(--input) !important;

            border:
                1px solid
                var(--input-border) !important;

            border-radius:
                13px !important;

            box-shadow:
                none !important;

            transition:
                .2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color:
                var(--primary) !important;

            box-shadow:
                0 0 0 4px
                rgba(37,99,235,.10)
                !important;
        }

        textarea.form-control {
            min-height:
                105px;
        }

        .form-select option {
            color:
                #111827;

            background:
                #ffffff;
        }

        html[data-theme="dark"]
        .form-select option {
            color:
                #ffffff;

            background:
                #0f172a;
        }


        /* =====================================================
           IMAGE UPLOAD
        ===================================================== */

        .image-upload {
            border:
                1px dashed
                rgba(37,99,235,.30);

            border-radius:
                17px;

            padding:
                15px;

            background:
                rgba(37,99,235,.035);

            transition:
                .25s ease;
        }

        .image-upload:hover {
            border-color:
                var(--primary);

            background:
                rgba(37,99,235,.06);
        }

        .upload-row {
            display: flex;

            align-items: center;

            gap: 12px;

            flex-wrap: wrap;
        }

        .choose-btn {
            position: relative;

            display: inline-flex;

            align-items: center;

            gap: 8px;

            min-height:
                44px;

            padding:
                0 16px;

            border-radius:
                12px;

            color:
                white;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--purple)
                );

            font-weight:
                800;

            cursor:
                pointer;

            box-shadow:
                0 10px 24px
                rgba(37,99,235,.20);
        }

        .choose-btn input {
            position: absolute;

            inset: 0;

            opacity: 0;

            cursor: pointer;
        }

        .image-info {
            color:
                var(--muted);

            font-size:
                11px;
        }

        .image-preview {
            display:
                none;

            margin-top:
                13px;

            width:
                100%;

            border-radius:
                14px;

            overflow:
                hidden;

            border:
                1px solid
                var(--border);
        }

        .image-preview img {
            width:
                100%;

            max-height:
                220px;

            object-fit:
                contain;

            background:
                rgba(0,0,0,.04);
        }


        /* =====================================================
           BUTTONS
        ===================================================== */

        .save-button {
            min-height:
                51px;

            padding:
                0 24px;

            border: 0;

            border-radius:
                14px;

            color:
                white;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--purple)
                );

            font-weight:
                850;

            box-shadow:
                0 12px 30px
                rgba(37,99,235,.23);

            transition:
                .25s ease;
        }

        .save-button:hover {
            color:
                white;

            transform:
                translateY(-2px);

            box-shadow:
                0 18px 38px
                rgba(37,99,235,.32);
        }

        .back-button {
            min-height:
                51px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            padding:
                0 20px;

            border-radius:
                14px;

            border:
                1px solid
                var(--border);

            color:
                var(--text);

            text-decoration:
                none;

            font-weight:
                750;
        }


        /* =====================================================
           SECURITY
        ===================================================== */

        .security {
            padding:
                16px;

            border-radius:
                17px;

            margin-bottom:
                20px;
        }

        .security.enabled {
            background:
                rgba(34,197,94,.08);

            border:
                1px solid
                rgba(34,197,94,.18);
        }

        .security.disabled {
            background:
                rgba(245,158,11,.08);

            border:
                1px solid
                rgba(245,158,11,.18);
        }

        .security-icon {
            width:
                42px;

            height:
                42px;

            border-radius:
                12px;

            display:
                flex;

            align-items:
                center;
            justify-content:
                center;

            font-size:
                17px;
        }

        .security.enabled
        .security-icon {
            color:
                #22c55e;

            background:
                rgba(34,197,94,.12);
        }

        .security.disabled
        .security-icon {
            color:
                #f59e0b;

            background:
                rgba(245,158,11,.12);
        }


        /* =====================================================
           ORDERS
        ===================================================== */

        .orders {
            overflow:
                hidden;

            border:
                1px solid
                var(--border);

            border-radius:
                17px;

            scroll-margin-top:
                90px;
        }

        #ordersSection {
            scroll-margin-top:
                90px;
        }

        .orders-highlight {
            animation:
                ordersHighlight
                1.4s
                ease;
        }

        @keyframes ordersHighlight {

            0% {
                box-shadow:
                    0 0 0 0
                    rgba(37,99,235,.0);
            }

            35% {
                box-shadow:
                    0 0 0 7px
                    rgba(37,99,235,.16);
            }

            100% {
                box-shadow:
                    0 0 0 0
                    rgba(37,99,235,.0);
            }
        }

        .table {
            margin:
                0;

            color:
                var(--text) !important;
        }

        .table > :not(caption)
        > *
        > * {
            color:
                var(--text) !important;

            background:
                transparent !important;

            border-color:
                var(--border) !important;

            padding:
                14px;
        }

        .order-id {
            color:
                var(--primary);

            font-weight:
                850;
        }

        .status {
            display:
                inline-flex;

            padding:
                6px 10px;

            border-radius:
                999px;

            color:
                var(--primary);

            background:
                rgba(37,99,235,.08);

            font-size:
                11px;

            font-weight:
                850;
        }

        .empty {
            text-align:
                center;

            padding:
                35px;

            color:
                var(--muted);
        }

        .empty i {
            display:
                block;

            font-size:
                40px;

            margin-bottom:
                10px;

            opacity:
                .5;
        }


        /* =====================================================
           LOGOUT
        ===================================================== */

        .logout {
            width:
                100%;

            min-height:
                52px;

            margin-top:
                24px;

            border-radius:
                15px;

            border:
                1px solid
                rgba(239,68,68,.20);

            color:
                var(--red);

            background:
                rgba(239,68,68,.06);

            font-weight:
                850;

            transition:
                .25s ease;
        }

        .logout:hover {
            color:
                white;

            background:
                var(--red);

            transform:
                translateY(-2px);
        }


        /* =====================================================
           CELEBRATION MESSAGE
        ===================================================== */

        .complete-message {
            display:
                none;

            margin:
                0 20px 20px;

            padding:
                13px;

            text-align:
                center;

            border-radius:
                15px;

            color:
                #9a7100;

            background:
                linear-gradient(
                    135deg,
                    rgba(245,197,66,.15),
                    rgba(255,231,140,.08)
                );

            border:
                1px solid
                rgba(212,175,55,.25);

            font-size:
                12px;

            font-weight:
                850;
        }

        .profile-complete .complete-message {
            display:
                block;

            animation:
                messagePop
                .7s
                ease both;
        }

        @keyframes messagePop {

            from {
                opacity:
                    0;

                transform:
                    translateY(8px)
                    scale(.97);
            }

            to {
                opacity:
                    1;

                transform:
                    translateY(0)
                    scale(1);
            }
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 767px) {

            .page {
                padding:
                    22px 10px 70px;
            }

            .topbar {
                flex-direction:
                    column;

                align-items:
                    stretch;

                padding-right:
                    0;
            }

            .continue-btn {
                text-align:
                    center;
            }

            .brand h1 {
                font-size:
                    21px;
            }

            .card-premium {
                border-radius:
                    22px;
            }

            .section {
                padding:
                    20px 17px;
            }

            .avatar-zone {
                width:
                    135px;

                height:
                    135px;
            }

            .save-button,
            .back-button {
                width:
                    100%;
            }

            .table {
                min-width:
                    600px;
            }
        }

    </style>

</head>


@php

    /*
    |--------------------------------------------------------------------------
    | THEME
    |--------------------------------------------------------------------------
    */

    $theme = auth()->user()->dark_mode ?? 'light';

    if (!in_array($theme, ['light', 'dark', 'system'])) {
        $theme = 'light';
    }


    /*
    |--------------------------------------------------------------------------
    | LANGUAGE OPTIONS
    |--------------------------------------------------------------------------
    */

    $localeConfig = config('locales', []);

    if (is_array($localeConfig) && count($localeConfig) > 0) {

        $languages = $localeConfig;

    } else {

        $languages = [
            'en' => 'English',
            'hi' => 'Hindi',
            'gu' => 'Gujarati',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | PROFILE COMPLETION
    |--------------------------------------------------------------------------
    */

    $profileFields = [

        'name' => $user->name,
        'username' => $user->username,
        'email' => $user->email,
        'phone' => $user->phone,
        'date_of_birth' => $user->date_of_birth,
        'gender' => $user->gender,
        'address' => $user->address,
        'house_no' => $user->house_no,
        'street' => $user->street,
        'area' => $user->area,
        'landmark' => $user->landmark,
        'city' => $user->city,
        'state' => $user->state,
        'country' => $user->country,
        'pin_code' => $user->pin_code,
        'language' => $user->language,
        'profile_image' => $user->profile_image,

    ];

    $filledFields = collect($profileFields)
        ->filter(function ($value) {
            return filled($value);
        })
        ->count();

    $totalFields = count($profileFields);

    $completion = $totalFields > 0
        ? (int) round(($filledFields / $totalFields) * 100)
        : 0;

@endphp


<body>


{{-- =========================================================
     3 DOTS MENU
========================================================= --}}

<div
    class="profile-menu-wrap"
    id="profileMenuWrap"
>

    <button
        type="button"
        class="profile-menu-button"
        id="profileMenuButton"
        aria-label="Open menu"
        aria-expanded="false"
    >
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>


    <div
        class="profile-menu"
        id="profileMenu"
    >

        {{-- USER --}}

        <div class="menu-user">

            <div class="menu-user-avatar">

                @if($user->profile_image)

                    <img
                        src="{{ asset('storage/profile/'.$user->profile_image) }}"
                        alt="Profile"
                    >

                @else

                    {{ strtoupper(substr($user->name ?: 'U', 0, 1)) }}

                @endif

            </div>

            <div class="menu-user-info">

                <div class="menu-user-name">
                    {{ $user->name }}
                </div>

                <div class="menu-user-email">
                    {{ $user->email }}
                </div>

            </div>

        </div>


        {{-- HOME --}}

        <a
            href="/"
            class="profile-menu-item menu-close"
        >

            <span class="menu-icon">
                <i class="fa-solid fa-house"></i>
            </span>

            <span>
                Home
            </span>

        </a>


        {{-- PRODUCTS --}}

        <a
            href="/products"
            class="profile-menu-item menu-close"
        >

            <span class="menu-icon">
                <i class="fa-solid fa-bag-shopping"></i>
            </span>

            <span>
                Products
            </span>

        </a>


        {{-- MY ORDERS --}}

        <button
            type="button"
            class="profile-menu-item"
            id="myOrdersMenuButton"
        >

            <span class="menu-icon">
                <i class="fa-solid fa-box-open"></i>
            </span>

            <span>
                My Orders
            </span>

            <span class="menu-badge">
                VIEW
            </span>

        </button>


        {{-- SECURITY --}}

        <button
            type="button"
            class="profile-menu-item"
            id="securityMenuButton"
        >

            <span class="menu-icon">
                <i class="fa-solid fa-shield-halved"></i>
            </span>

            <span>
                Security
            </span>

        </button>


        {{-- PROFILE --}}

        <button
            type="button"
            class="profile-menu-item"
            id="profileDetailsMenuButton"
        >

            <span class="menu-icon">
                <i class="fa-solid fa-user-pen"></i>
            </span>

            <span>
                Edit Profile
            </span>

        </button>


        <div class="menu-divider"></div>


        {{-- CONTINUE SHOPPING --}}

        <a
            href="/products"
            class="profile-menu-item menu-close"
        >

            <span class="menu-icon">
                <i class="fa-solid fa-arrow-right"></i>
            </span>

            <span>
                Continue Shopping
            </span>

        </a>


        {{-- LOGOUT --}}

        <form
            action="{{ route('logout') }}"
            method="POST"
            id="menuLogoutForm"
        >

            @csrf

            <button
                type="submit"
                class="profile-menu-item danger"
            >

                <span class="menu-icon">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </span>

                <span>
                    Logout
                </span>

            </button>

        </form>

    </div>

</div>



<div class="page">

    <div class="container-premium">


        {{-- =================================================
             TOP BAR
        ================================================= --}}

        <div class="topbar">

            <div class="brand">

                <div class="brand-logo">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div>

                    <h1>
                        My Profile
                    </h1>

                    <p>
                        Manage your SMART BASKET account
                    </p>

                </div>

            </div>


            <a
                href="/products"
                class="continue-btn"
            >

                <i class="fa-solid fa-arrow-left me-2"></i>

                Continue Shopping

            </a>

        </div>


        {{-- =================================================
             SUCCESS
        ================================================= --}}

        @if(session('success'))

            <div class="alert-premium">

                <i
                    class="fa-solid fa-circle-check text-success me-2"
                ></i>

                {{ session('success') }}

            </div>

        @endif


        {{-- =================================================
             ERRORS
        ================================================= --}}

        @if($errors->any())

            <div class="alert-premium">

                <strong class="text-danger">

                    <i
                        class="fa-solid fa-circle-exclamation me-2"
                    ></i>

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


        <div class="row g-4">


            {{-- =================================================
                 LEFT SIDE
            ================================================= --}}

            <div class="col-lg-4">


                <div
                    class="card-premium
                    {{ $completion >= 100 ? 'profile-complete' : '' }}"
                >


                    {{-- PROFILE HERO --}}

                    <div
                        class="profile-hero"
                        id="profileHero"
                    >


                        <div class="avatar-zone">


                            {{-- STARS --}}

                            <div class="celebration-stars">

                                <span class="star">★</span>
                                <span class="star">✦</span>
                                <span class="star">★</span>
                                <span class="star">✦</span>
                                <span class="star">★</span>
                                <span class="star">✦</span>
                                <span class="star">★</span>
                                <span class="star">✦</span>

                            </div>


                            {{-- GOLD RING --}}

                            <div class="avatar-ring">

                                <div class="avatar-inner">

                                    @if($user->profile_image)

                                        <img
                                            src="{{ asset('storage/profile/'.$user->profile_image) }}"
                                            class="avatar"
                                            alt="Profile"
                                        >

                                    @else

                                        <div class="avatar-placeholder">

                                            {{ strtoupper(substr($user->name ?: 'U', 0, 1)) }}

                                        </div>

                                    @endif

                                </div>

                            </div>


                            <span class="online"></span>


                        </div>


                        <div class="fw-black fs-4">

                            {{ $user->name }}

                        </div>


                        <div
                            style="
                                color:var(--muted);
                                font-size:13px;
                                margin-top:4px;
                            "
                        >

                            {{ $user->email }}

                        </div>


                        <div
                            class="completion-badge
                            {{ $completion >= 100 ? 'complete' : '' }}"
                        >

                            @if($completion >= 100)

                                <i class="fa-solid fa-star"></i>

                                Profile 100% Complete

                            @else

                                <i class="fa-solid fa-shield-halved"></i>

                                Account Protected

                            @endif

                        </div>

                    </div>


                    {{-- COMPLETION --}}

                    <div class="completion-box">

                        <div class="completion-top">

                            <span class="completion-title">
                                Profile Completion
                            </span>

                            <span
                                class="completion-percent"
                                id="completionPercent"
                            >
                                {{ $completion }}%
                            </span>

                        </div>


                        <div class="progress">

                            <div
                                id="completionBar"
                                class="progress-bar"
                                role="progressbar"
                                style="width:{{ $completion }}%"
                            ></div>

                        </div>


                        <div
                            style="
                                color:var(--muted);
                                font-size:11px;
                                margin-top:8px;
                            "
                            id="completionText"
                        >

                            @if($completion >= 100)

                                🎉 Everything looks perfect!

                            @else

                                Complete all details to reach 100%.

                            @endif

                        </div>

                    </div>


                    <div class="complete-message">

                        <i class="fa-solid fa-crown me-1"></i>

                        🎉 Congratulations! Your SMART BASKET profile
                        is completely filled.

                    </div>


                    {{-- FORM --}}

                    <form
                        action="{{ route('profile.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        id="profileForm"
                    >

                        @csrf


                        <div class="section">


                            {{-- PERSONAL --}}

                            <div class="section-title">

                                <div class="section-icon">
                                    <i class="fa-solid fa-id-card"></i>
                                </div>

                                <div>

                                    <h2>
                                        Personal Details
                                    </h2>

                                    <p>
                                        Keep your information updated
                                    </p>

                                </div>

                            </div>


                            {{-- IMAGE --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Profile Photo
                                </label>

                                <div class="image-upload">

                                    <div class="upload-row">

                                        <label class="choose-btn">

                                            <i class="fa-solid fa-camera"></i>

                                            Choose Photo

                                            <input
                                                type="file"
                                                name="profile_image"
                                                id="profileImage"
                                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                            >

                                        </label>

                                        <span
                                            class="image-info"
                                            id="imageInfo"
                                        >
                                            JPG, PNG, WEBP • Max 2 MB
                                        </span>

                                    </div>

                                    <div
                                        class="image-preview"
                                        id="imagePreview"
                                    >

                                        <img
                                            id="previewImage"
                                            alt="Preview"
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- NAME --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="form-control profile-input"
                                    value="{{ old('name', $user->name) }}"
                                >

                            </div>


                            {{-- USERNAME --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Username
                                </label>

                                <input
                                    type="text"
                                    name="username"
                                    class="form-control profile-input"
                                    value="{{ old('username', $user->username) }}"
                                >

                            </div>


                            {{-- EMAIL --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control profile-input"
                                    value="{{ old('email', $user->email) }}"
                                >

                            </div>


                            {{-- PHONE --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Phone
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control profile-input"
                                    value="{{ old('phone', $user->phone) }}"
                                >

                            </div>


                            {{-- DOB / GENDER --}}

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Date Of Birth
                                    </label>

                                    <input
                                        type="date"
                                        name="date_of_birth"
                                        class="form-control profile-input"
                                        value="{{ old('date_of_birth', $user->date_of_birth) }}"
                                    >

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Gender
                                    </label>

                                    <select
                                        name="gender"
                                        class="form-select profile-input"
                                    >

                                        <option value="">
                                            Select
                                        </option>

                                        <option
                                            value="Male"
                                            @selected(old('gender', $user->gender) === 'Male')
                                        >
                                            Male
                                        </option>

                                        <option
                                            value="Female"
                                            @selected(old('gender', $user->gender) === 'Female')
                                        >
                                            Female
                                        </option>

                                        <option
                                            value="Other"
                                            @selected(old('gender', $user->gender) === 'Other')
                                        >
                                            Other
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- ADDRESS --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Address
                                </label>

                                <textarea
                                    name="address"
                                    class="form-control profile-input"
                                    rows="3"
                                >{{ old('address', $user->address) }}</textarea>

                            </div>


                            {{-- HOUSE / STREET --}}

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        House No
                                    </label>

                                    <input
                                        type="text"
                                        name="house_no"
                                        class="form-control profile-input"
                                        value="{{ old('house_no', $user->house_no) }}"
                                    >

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Street
                                    </label>

                                    <input
                                        type="text"
                                        name="street"
                                        class="form-control profile-input"
                                        value="{{ old('street', $user->street) }}"
                                    >

                                </div>

                            </div>


                            {{-- AREA / LANDMARK --}}

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Area
                                    </label>

                                    <input
                                        type="text"
                                        name="area"
                                        class="form-control profile-input"
                                        value="{{ old('area', $user->area) }}"
                                    >

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Landmark
                                    </label>

                                    <input
                                        type="text"
                                        name="landmark"
                                        class="form-control profile-input"
                                        value="{{ old('landmark', $user->landmark) }}"
                                    >

                                </div>

                            </div>


                            {{-- CITY / STATE --}}

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        City
                                    </label>

                                    <input
                                        type="text"
                                        name="city"
                                        class="form-control profile-input"
                                        value="{{ old('city', $user->city) }}"
                                    >

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        State
                                    </label>

                                    <input
                                        type="text"
                                        name="state"
                                        class="form-control profile-input"
                                        value="{{ old('state', $user->state) }}"
                                    >

                                </div>

                            </div>


                            {{-- COUNTRY / PIN --}}

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Country
                                    </label>

                                    <input
                                        type="text"
                                        name="country"
                                        class="form-control profile-input"
                                        value="{{ old('country', $user->country) }}"
                                    >

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        PIN Code
                                    </label>

                                    <input
                                        type="text"
                                        name="pin_code"
                                        class="form-control profile-input"
                                        value="{{ old('pin_code', $user->pin_code) }}"
                                    >

                                </div>

                            </div>


                            {{-- LANGUAGE --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Language
                                </label>

                                <select
                                    name="language"
                                    class="form-select profile-input"
                                >

                                    @foreach($languages as $locale => $label)

                                        @php
                                            $displayLabel = is_array($label)
                                                ? ($label['name'] ?? $label['label'] ?? $locale)
                                                : $label;
                                        @endphp

                                        <option
                                            value="{{ $locale }}"
                                            @selected(
                                                old(
                                                    'language',
                                                    $user->language ?: array_key_first($languages)
                                                ) === $locale
                                            )
                                        >
                                            {{ $displayLabel }}
                                        </option>

                                    @endforeach

                                </select>

                                <small
                                    style="
                                        color:var(--muted);
                                        font-size:11px;
                                    "
                                >
                                    Select your preferred language.
                                </small>

                            </div>


                            {{-- THEME --}}

                            <div class="mb-3">

                                <label class="form-label">

                                    <i class="fa-solid fa-palette me-1"></i>

                                    Appearance

                                </label>

                                <select
                                    name="dark_mode"
                                    id="themeSelect"
                                    class="form-select profile-input"
                                >

                                    <option
                                        value="light"
                                        @selected(old('dark_mode', $user->dark_mode) === 'light')
                                    >
                                        ☀️ Light
                                    </option>

                                    <option
                                        value="dark"
                                        @selected(old('dark_mode', $user->dark_mode) === 'dark')
                                    >
                                        🌙 Dark
                                    </option>

                                    <option
                                        value="system"
                                        @selected(old('dark_mode', $user->dark_mode) === 'system')
                                    >
                                        💻 System Default
                                    </option>

                                </select>

                            </div>


                            {{-- NOTIFICATIONS --}}

                            <div class="mb-3">

                                <label class="form-label">
                                    Notifications
                                </label>

                                <select
                                    name="notifications"
                                    class="form-select profile-input"
                                >

                                    <option
                                        value="enabled"
                                        @selected(old('notifications', $user->notifications) === 'enabled')
                                    >
                                        🔔 Enabled
                                    </option>

                                    <option
                                        value="disabled"
                                        @selected(old('notifications', $user->notifications) === 'disabled')
                                    >
                                        🔕 Disabled
                                    </option>

                                </select>

                            </div>


                            <hr
                                style="
                                    border-color:var(--border);
                                    margin:25px 0;
                                "
                            >


                            {{-- PASSWORD --}}

                            <div class="section-title">

                                <div class="section-icon">
                                    <i class="fa-solid fa-lock"></i>
                                </div>

                                <div>

                                    <h2>
                                        Change Password
                                    </h2>

                                    <p>
                                        Keep your account secure
                                    </p>

                                </div>

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    New Password
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Enter new password"
                                >

                            </div>


                            <div class="mb-4">

                                <label class="form-label">
                                    Confirm Password
                                </label>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Confirm new password"
                                >

                            </div>


                            <div class="d-flex gap-2 flex-wrap">

                                <button
                                    type="submit"
                                    class="save-button"
                                >

                                    <i
                                        class="fa-solid fa-floppy-disk me-2"
                                    ></i>

                                    Save Profile

                                </button>


                                <a
                                    href="/products"
                                    class="back-button"
                                >

                                    Back

                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            {{-- =================================================
                 RIGHT SIDE
            ================================================= --}}

            <div class="col-lg-8">


                {{-- SECURITY --}}

                <div
                    class="card-premium mb-4"
                    id="securitySection"
                >

                    <div class="section">

                        <div class="section-title">

                            <div class="section-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>

                            <div>

                                <h2>
                                    Security Center
                                </h2>

                                <p>
                                    Protect your SMART BASKET account
                                </p>

                            </div>

                        </div>


                        @if(session('security_success'))

                            <div class="alert-premium">
                                {{ session('security_success') }}
                            </div>

                        @endif


                        @if(
                            $user->securitySetting &&
                            $user->securitySetting->security_enabled
                        )

                            <div class="security enabled d-flex gap-3">

                                <div class="security-icon">

                                    <i class="fa-solid fa-shield-check"></i>

                                </div>

                                <div>

                                    <strong>
                                        Security PIN Enabled
                                    </strong>

                                    <div
                                        style="
                                            color:var(--muted);
                                            font-size:12px;
                                            margin-top:3px;
                                        "
                                    >
                                        Your account has an extra
                                        layer of protection.
                                    </div>

                                </div>

                            </div>


                            <form
                                action="{{ route('security.disable') }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-danger rounded-4 px-4 fw-bold"
                                >

                                    <i class="fa-solid fa-lock-open me-2"></i>

                                    Disable PIN

                                </button>

                            </form>

                        @else

                            <div class="security disabled d-flex gap-3">

                                <div class="security-icon">

                                    <i class="fa-solid fa-triangle-exclamation"></i>

                                </div>

                                <div>

                                    <strong>
                                        Security PIN Not Setup
                                    </strong>

                                    <div
                                        style="
                                            color:var(--muted);
                                            font-size:12px;
                                            margin-top:3px;
                                        "
                                    >
                                        Create a PIN to improve
                                        account security.
                                    </div>

                                </div>

                            </div>


                            <form
                                action="{{ route('security.save') }}"
                                method="POST"
                            >

                                @csrf

                                <div class="mb-3">

                                    <label class="form-label">
                                        Create Security PIN
                                    </label>

                                    <input
                                        type="password"
                                        name="pin"
                                        maxlength="6"
                                        minlength="4"
                                        inputmode="numeric"
                                        class="form-control"
                                        placeholder="4–6 digit PIN"
                                        required
                                    >

                                </div>


                                <div class="mb-3">

                                    <label class="form-label">
                                        Confirm PIN
                                    </label>

                                    <input
                                        type="password"
                                        name="pin_confirmation"
                                        maxlength="6"
                                        minlength="4"
                                        inputmode="numeric"
                                        class="form-control"
                                        placeholder="Confirm PIN"
                                        required
                                    >

                                </div>


                                <button
                                    class="save-button"
                                    type="submit"
                                >

                                    <i class="fa-solid fa-shield me-2"></i>

                                    Enable Security PIN

                                </button>

                            </form>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                     ORDERS
                ================================================= --}}

                <div
                    class="card-premium"
                    id="ordersSection"
                >

                    <div class="section">


                        <div class="section-title">

                            <div class="section-icon">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </div>

                            <div>

                                <h2>
                                    My Orders
                                </h2>

                                <p>
                                    Your recent shopping activity
                                </p>

                            </div>

                        </div>


                        @php

                            $orders =
                                $user
                                ->orders()
                                ->latest()
                                ->get();

                        @endphp


                        @if($orders->count() === 0)

                            <div class="empty">

                                <i class="fa-solid fa-box-open"></i>

                                <strong>
                                    No Orders Yet
                                </strong>

                                <div>
                                    Start shopping and your
                                    orders will appear here.
                                </div>

                            </div>

                        @else

                            <div
                                class="orders"
                                id="ordersTable"
                            >

                                <div class="table-responsive">

                                    <table class="table align-middle">

                                        <thead>

                                            <tr>

                                                <th>
                                                    Order
                                                </th>

                                                <th>
                                                    Date
                                                </th>

                                                <th>
                                                    Total
                                                </th>

                                                <th>
                                                    Status
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                            @foreach($orders as $order)

                                                <tr>

                                                    <td>

                                                        <span class="order-id">

                                                            #{{ $order->id }}

                                                        </span>

                                                    </td>

                                                    <td>

                                                        {{ $order->created_at->format('d M Y') }}

                                                    </td>

                                                    <td class="fw-bold">

                                                        ₹{{ number_format($order->total, 2) }}

                                                    </td>

                                                    <td>

                                                        <span class="status">

                                                            {{ $order->status }}

                                                        </span>

                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
             LOGOUT
        ================================================= --}}

        <form
            action="{{ route('logout') }}"
            method="POST"
            id="mainLogoutForm"
        >

            @csrf

            <button
                type="submit"
                class="logout"
            >

                <i
                    class="fa-solid fa-right-from-bracket me-2"
                ></i>

                Logout from SMART BASKET

            </button>

        </form>

    </div>

</div>



<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* =====================================================
           3 DOTS MENU
        ===================================================== */

        const menuWrap =
            document.getElementById(
                'profileMenuWrap'
            );

        const menuButton =
            document.getElementById(
                'profileMenuButton'
            );

        const menu =
            document.getElementById(
                'profileMenu'
            );


        function openMenu() {

            if (!menuWrap) {
                return;
            }

            menuWrap.classList.add(
                'open'
            );

            if (menuButton) {

                menuButton.setAttribute(
                    'aria-expanded',
                    'true'
                );

            }

        }


        function closeMenu() {

            if (!menuWrap) {
                return;
            }

            menuWrap.classList.remove(
                'open'
            );

            if (menuButton) {

                menuButton.setAttribute(
                    'aria-expanded',
                    'false'
                );

            }

        }


        function toggleMenu() {

            if (
                menuWrap &&
                menuWrap.classList.contains('open')
            ) {

                closeMenu();

            } else {

                openMenu();

            }

        }


        if (menuButton) {

            menuButton.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    event.stopPropagation();

                    toggleMenu();

                }
            );

        }


        /*
         * Clicking inside menu should NOT
         * accidentally close it before buttons work.
         */

        if (menu) {

            menu.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                }
            );

        }


        /*
         * Click anywhere outside
         * closes menu.
         */

        document.addEventListener(
            'click',
            function (event) {

                if (
                    menuWrap &&
                    !menuWrap.contains(event.target)
                ) {

                    closeMenu();

                }

            }
        );


        /*
         * ESC closes menu.
         */

        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Escape') {

                    closeMenu();

                }

            }
        );


        /* =====================================================
           MY ORDERS BUTTON — FIXED
        ===================================================== */

        const myOrdersButton =
            document.getElementById(
                'myOrdersMenuButton'
            );

        const ordersSection =
            document.getElementById(
                'ordersSection'
            );


        if (myOrdersButton) {

            myOrdersButton.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();
                    event.stopPropagation();

                    /*
                     * Close 3-dots menu first.
                     */

                    closeMenu();


                    /*
                     * Scroll directly to My Orders.
                     */

                    if (ordersSection) {

                        ordersSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });


                        /*
                         * Premium highlight so user
                         * clearly sees the section.
                         */

                        ordersSection.classList.remove(
                            'orders-highlight'
                        );


                        void ordersSection.offsetWidth;


                        ordersSection.classList.add(
                            'orders-highlight'
                        );


                        setTimeout(
                            function () {

                                ordersSection.classList.remove(
                                    'orders-highlight'
                                );

                            },
                            1600
                        );

                    }

                }
            );

        }


        /* =====================================================
           SECURITY BUTTON
        ===================================================== */

        const securityButton =
            document.getElementById(
                'securityMenuButton'
            );

        const securitySection =
            document.getElementById(
                'securitySection'
            );


        if (securityButton) {

            securityButton.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    event.stopPropagation();

                    closeMenu();


                    if (securitySection) {

                        securitySection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                    }

                }
            );

        }


        /* =====================================================
           EDIT PROFILE BUTTON
        ===================================================== */

        const profileDetailsButton =
            document.getElementById(
                'profileDetailsMenuButton'
            );

        const profileForm =
            document.getElementById(
                'profileForm'
            );


        if (profileDetailsButton) {

            profileDetailsButton.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    event.stopPropagation();

                    closeMenu();


                    if (profileForm) {

                        profileForm.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });


                        /*
                         * Focus first input.
                         */

                        setTimeout(
                            function () {

                                const firstInput =
                                    profileForm.querySelector(
                                        'input[name="name"]'
                                    );

                                if (firstInput) {

                                    firstInput.focus({
                                        preventScroll: true
                                    });

                                }

                            },
                            650
                        );

                    }

                }
            );

        }


        /* =====================================================
           THEME
        ===================================================== */

        const themeSelect =
            document.getElementById(
                'themeSelect'
            );


        function applyTheme(theme) {

            let finalTheme = theme;

            if (theme === 'system') {

                finalTheme =
                    window.matchMedia(
                        '(prefers-color-scheme: dark)'
                    ).matches
                        ? 'dark'
                        : 'light';

            }

            document.documentElement
                .setAttribute(
                    'data-theme',
                    finalTheme
                );

        }


        applyTheme(
            @json($theme)
        );


        if (themeSelect) {

            themeSelect.addEventListener(
                'change',
                function () {

                    applyTheme(
                        this.value
                    );

                }
            );

        }


        /* =====================================================
           LIVE PROFILE COMPLETION
        ===================================================== */

        const form =
            document.getElementById(
                'profileForm'
            );

        const percent =
            document.getElementById(
                'completionPercent'
            );

        const bar =
            document.getElementById(
                'completionBar'
            );

        const completionText =
            document.getElementById(
                'completionText'
            );

        const card =
            document.querySelector(
                '.card-premium'
            );


        if (form) {

            const fields = [

                'name',
                'username',
                'email',
                'phone',
                'date_of_birth',
                'gender',
                'address',
                'house_no',
                'street',
                'area',
                'landmark',
                'city',
                'state',
                'country',
                'pin_code',
                'language',
                'profile_image'

            ];


            function calculateCompletion() {

                let filled = 0;


                fields.forEach(
                    function (name) {

                        const field =
                            form.querySelector(
                                '[name="' +
                                name +
                                '"]'
                            );


                        if (!field) {
                            return;
                        }


                        if (
                            field.type === 'file'
                        ) {

                            const existingImage =
                                {{ $user->profile_image ? 'true' : 'false' }};


                            if (
                                existingImage ||
                                field.files.length > 0
                            ) {

                                filled++;

                            }

                            return;

                        }


                        if (
                            field.value &&
                            field.value.trim() !== ''
                        ) {

                            filled++;

                        }

                    }
                );


                const total =
                    fields.length;


                const result =
                    Math.round(
                        (filled / total) * 100
                    );


                percent.textContent =
                    result + '%';


                bar.style.width =
                    result + '%';


                if (result >= 100) {

                    card.classList.add(
                        'profile-complete'
                    );

                    completionText.innerHTML =
                        '🎉 Everything looks perfect!';

                } else {

                    card.classList.remove(
                        'profile-complete'
                    );

                    completionText.innerHTML =
                        'Complete all details to reach 100%.';

                }

            }


            form.querySelectorAll(
                '.profile-input'
            ).forEach(
                function (field) {

                    field.addEventListener(
                        'input',
                        calculateCompletion
                    );

                    field.addEventListener(
                        'change',
                        calculateCompletion
                    );

                }
            );


            calculateCompletion();

        }


        /* =====================================================
           IMAGE PREVIEW + 2 MB CHECK
        ===================================================== */

        const imageInput =
            document.getElementById(
                'profileImage'
            );

        const previewBox =
            document.getElementById(
                'imagePreview'
            );

        const previewImage =
            document.getElementById(
                'previewImage'
            );

        const imageInfo =
            document.getElementById(
                'imageInfo'
            );


        if (imageInput) {

            imageInput.addEventListener(
                'change',
                function () {

                    const file =
                        this.files[0];


                    if (!file) {
                        return;
                    }


                    const maxSize =
                        2 * 1024 * 1024;


                    if (
                        file.size > maxSize
                    ) {

                        imageInfo.innerHTML =
                            '<span style="color:#dc2626;font-weight:800;">' +
                            'Image is larger than 2 MB. Please choose a smaller image.' +
                            '</span>';


                        this.value = '';


                        if (previewBox) {

                            previewBox.style.display =
                                'none';

                        }

                        return;

                    }


                    imageInfo.innerHTML =
                        '<span style="color:#16a34a;font-weight:800;">' +
                        file.name +
                        ' • ' +
                        (file.size / 1024 / 1024)
                            .toFixed(2) +
                        ' MB' +
                        '</span>';


                    const reader =
                        new FileReader();


                    reader.onload =
                        function (event) {

                            previewImage.src =
                                event.target.result;

                            previewBox.style.display =
                                'block';

                        };


                    reader.readAsDataURL(file);


                    if (form) {

                        const event =
                            new Event('change', {
                                bubbles: true
                            });

                        imageInput.dispatchEvent(
                            event
                        );

                    }

                }
            );

        }


        /* =====================================================
           SUCCESS MESSAGE
        ===================================================== */

        setTimeout(
            function () {

                document
                    .querySelectorAll(
                        '.alert-premium'
                    )
                    .forEach(
                        function (alert) {

                            alert.style.transition =
                                'opacity .5s ease';

                            alert.style.opacity =
                                '0';


                            setTimeout(
                                function () {

                                    alert.remove();

                                },
                                600
                            );

                        }
                    );

            },
            4500
        );


        /* =====================================================
           MENU LINKS — CLOSE AFTER NAVIGATION
        ===================================================== */

        document
            .querySelectorAll('.menu-close')
            .forEach(
                function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            closeMenu();

                        }
                    );

                }
            );


    }
);

</script>


</body>

</html>