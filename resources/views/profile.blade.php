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
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >

    @php
        $customerTheme = auth()->check()
            ? (auth()->user()->dark_mode ?? 'light')
            : 'light';

        if (!in_array($customerTheme, ['light', 'dark', 'system'])) {
            $customerTheme = 'light';
        }
    @endphp

    <style>
        :root {
            --profile-bg: #f1f5f9;
            --profile-card: rgba(255,255,255,.90);
            --profile-card-solid: #ffffff;
            --profile-text: #0f172a;
            --profile-muted: #64748b;
            --profile-border: rgba(15,23,42,.09);
            --profile-input: #ffffff;
            --profile-input-border: #dbe3ef;
            --profile-primary: #2563eb;
            --profile-primary-2: #7c3aed;
            --profile-success: #16a34a;
            --profile-danger: #dc2626;
            --profile-shadow: 0 25px 70px rgba(15,23,42,.12);
            --profile-soft: rgba(37,99,235,.07);
        }

        html[data-sb-theme="dark"],
        body[data-sb-theme="dark"] {
            --profile-bg: #020617;
            --profile-card: rgba(15,23,42,.88);
            --profile-card-solid: #0f172a;
            --profile-text: #f8fafc;
            --profile-muted: #94a3b8;
            --profile-border: rgba(255,255,255,.09);
            --profile-input: #111c31;
            --profile-input-border: rgba(255,255,255,.12);
            --profile-primary: #3b82f6;
            --profile-primary-2: #8b5cf6;
            --profile-success: #22c55e;
            --profile-danger: #ef4444;
            --profile-shadow: 0 30px 90px rgba(0,0,0,.48);
            --profile-soft: rgba(59,130,246,.10);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            color: var(--profile-text);

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                radial-gradient(
                    circle at 5% 5%,
                    rgba(37,99,235,.18),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 95% 15%,
                    rgba(124,58,237,.16),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 50% 100%,
                    rgba(14,165,233,.10),
                    transparent 35%
                ),
                var(--profile-bg);

            transition:
                background .35s ease,
                color .35s ease;
        }

        body[data-sb-theme="dark"] {
            background:
                radial-gradient(
                    circle at 5% 5%,
                    rgba(37,99,235,.16),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 95% 15%,
                    rgba(124,58,237,.15),
                    transparent 28%
                ),
                #020617;
        }

        .profile-wrapper {
            min-height: 100vh;
            padding: 45px 15px 100px;
        }

        .profile-container {
            max-width: 1250px;
            margin: auto;
        }

        /* TOP BAR */

        .profile-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 25px;
        }

        .brand-title {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;
            font-size: 21px;

            background:
                linear-gradient(
                    135deg,
                    var(--profile-primary),
                    var(--profile-primary-2)
                );

            box-shadow:
                0 12px 30px rgba(37,99,235,.28);
        }

        .brand-title h1 {
            margin: 0;
            font-size: 25px;
            font-weight: 900;
            letter-spacing: -.5px;
        }

        .brand-title span {
            display: block;
            margin-top: 2px;
            color: var(--profile-muted);
            font-size: 13px;
        }

        .back-btn {
            border: 1px solid var(--profile-border);
            color: var(--profile-text);
            background: var(--profile-card);
            padding: 11px 17px;
            border-radius: 13px;
            text-decoration: none;
            font-weight: 700;
            backdrop-filter: blur(15px);
            transition: .25s ease;
        }

        .back-btn:hover {
            color: white;
            background: var(--profile-primary);
            transform: translateY(-2px);
        }

        /* ALERT */

        .premium-alert {
            border: 1px solid var(--profile-border);
            border-radius: 16px;
            background: var(--profile-card);
            color: var(--profile-text);
            box-shadow: var(--profile-shadow);
            backdrop-filter: blur(18px);
            padding: 14px 18px;
            margin-bottom: 20px;
        }

        /* CARDS */

        .profile-card {
            position: relative;
            overflow: hidden;

            border: 1px solid var(--profile-border) !important;
            border-radius: 25px !important;

            background: var(--profile-card) !important;
            color: var(--profile-text) !important;

            box-shadow: var(--profile-shadow) !important;

            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);

            transition:
                transform .3s ease,
                box-shadow .3s ease,
                background .3s ease,
                border-color .3s ease;
        }

        .profile-card::before {
            content: "";
            position: absolute;
            top: -80px;
            right: -80px;

            width: 180px;
            height: 180px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(59,130,246,.16),
                    transparent 70%
                );

            pointer-events: none;
        }

        .profile-card:hover {
            transform: translateY(-4px);
            box-shadow:
                0 30px 80px rgba(15,23,42,.16) !important;
        }

        body[data-sb-theme="dark"] .profile-card:hover {
            box-shadow:
                0 35px 90px rgba(0,0,0,.55) !important;
        }

        /* PROFILE HEADER */

        .profile-header {
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .avatar-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }

        .avatar {
            width: 135px;
            height: 135px;

            object-fit: cover;
            border-radius: 50%;

            border: 5px solid var(--profile-card-solid);

            box-shadow:
                0 15px 45px rgba(15,23,42,.20);

            transition: .3s ease;
        }

        .avatar:hover {
            transform: scale(1.05);
        }

        .avatar-placeholder {
            width: 135px;
            height: 135px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;
            font-size: 48px;
            font-weight: 900;

            border: 5px solid var(--profile-card-solid);

            background:
                linear-gradient(
                    135deg,
                    var(--profile-primary),
                    var(--profile-primary-2)
                );

            box-shadow:
                0 15px 45px rgba(37,99,235,.30);
        }

        .online-dot {
            position: absolute;
            right: 7px;
            bottom: 10px;

            width: 19px;
            height: 19px;

            border-radius: 50%;

            background: #22c55e;

            border: 4px solid var(--profile-card-solid);
        }

        .profile-name {
            font-size: 25px;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .profile-email {
            color: var(--profile-muted);
            font-size: 14px;
            margin-bottom: 0;
        }

        .verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            margin-top: 12px;
            padding: 7px 12px;

            border-radius: 999px;

            background: rgba(34,197,94,.10);
            border: 1px solid rgba(34,197,94,.20);

            color: var(--profile-success);

            font-size: 12px;
            font-weight: 800;
        }

        /* SECTION */

        .section-heading {
            display: flex;
            align-items: center;
            gap: 10px;

            margin-bottom: 20px;
        }

        .section-icon {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            color: var(--profile-primary);

            background: var(--profile-soft);
        }

        .section-heading h2 {
            margin: 0;
            font-size: 19px;
            font-weight: 850;
        }

        .section-heading p {
            margin: 2px 0 0;
            color: var(--profile-muted);
            font-size: 12px;
        }

        /* FORM */

        .form-label {
            color: var(--profile-text);
            font-size: 13px;
            font-weight: 750;
            margin-bottom: 7px;
        }

        .form-control,
        .form-select {
            min-height: 49px;

            color: var(--profile-text) !important;
            background: var(--profile-input) !important;

            border: 1px solid var(--profile-input-border) !important;

            border-radius: 13px !important;

            box-shadow: none !important;

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                transform .2s ease;
        }

        textarea.form-control {
            min-height: 100px;
        }

        .form-control::placeholder {
            color: var(--profile-muted);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--profile-primary) !important;

            box-shadow:
                0 0 0 4px rgba(37,99,235,.12) !important;
        }

        .form-select option {
            background: var(--profile-input);
            color: var(--profile-text);
        }

        /* DIVIDER */

        .premium-divider {
            height: 1px;
            border: 0;
            margin: 24px 0;

            background: var(--profile-border);
        }

        /* SAVE BUTTON */

        .save-btn {
            min-height: 50px;

            border: 0;
            border-radius: 14px;

            padding: 0 23px;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    var(--profile-primary),
                    var(--profile-primary-2)
                );

            font-weight: 800;

            box-shadow:
                0 12px 30px rgba(37,99,235,.25);

            transition: .25s ease;
        }

        .save-btn:hover {
            color: white;
            transform: translateY(-2px);

            box-shadow:
                0 18px 40px rgba(37,99,235,.35);
        }

        .outline-btn {
            min-height: 50px;
            border-radius: 14px;

            color: var(--profile-text);

            border: 1px solid var(--profile-border);
            background: transparent;

            font-weight: 700;

            text-decoration: none;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0 20px;

            transition: .25s ease;
        }

        .outline-btn:hover {
            color: var(--profile-primary);
            border-color: var(--profile-primary);
        }

        /* SECURITY */

        .security-status {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 15px;

            border-radius: 16px;

            margin-bottom: 20px;
        }

        .security-status.enabled {
            background: rgba(34,197,94,.09);
            border: 1px solid rgba(34,197,94,.18);
        }

        .security-status.disabled {
            background: rgba(245,158,11,.09);
            border: 1px solid rgba(245,158,11,.18);
        }

        .security-icon {
            width: 42px;
            height: 42px;

            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 17px;
        }

        .enabled .security-icon {
            color: #22c55e;
            background: rgba(34,197,94,.12);
        }

        .disabled .security-icon {
            color: #f59e0b;
            background: rgba(245,158,11,.12);
        }

        .security-status strong {
            display: block;
            font-size: 14px;
        }

        .security-status span {
            color: var(--profile-muted);
            font-size: 12px;
        }

        /* ORDERS */

        .order-table-wrapper {
            border: 1px solid var(--profile-border);
            border-radius: 17px;
            overflow: hidden;
        }

        .table {
            margin: 0;
            color: var(--profile-text) !important;
        }

        .table > :not(caption) > * > * {
            color: var(--profile-text) !important;
            background: transparent !important;
            border-color: var(--profile-border) !important;
            padding: 15px 14px;
        }

        .table thead th {
            color: var(--profile-muted) !important;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .6px;
            font-weight: 800;
        }

        .order-id {
            color: var(--profile-primary);
            font-weight: 800;
        }

        .status-badge {
            display: inline-flex;
            padding: 6px 10px;

            border-radius: 999px;

            background: var(--profile-soft);
            color: var(--profile-primary);

            font-size: 11px;
            font-weight: 800;
        }

        .empty-orders {
            text-align: center;
            padding: 35px 15px;

            color: var(--profile-muted);
        }

        .empty-orders i {
            font-size: 42px;
            margin-bottom: 12px;
            opacity: .55;
        }

        /* LOGOUT */

        .logout-area {
            margin-top: 25px;
        }

        .logout-btn {
            width: 100%;
            min-height: 52px;

            border-radius: 15px;

            border: 1px solid rgba(239,68,68,.25);

            background: rgba(239,68,68,.07);

            color: var(--profile-danger);

            font-weight: 800;

            transition: .25s ease;
        }

        .logout-btn:hover {
            color: white;
            background: var(--profile-danger);
            transform: translateY(-2px);
        }

        /* MOBILE */

        @media (max-width: 767px) {

            .profile-wrapper {
                padding: 25px 10px 80px;
            }

            .profile-topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .brand-title h1 {
                font-size: 21px;
            }

            .profile-card {
                border-radius: 21px !important;
            }

            .avatar,
            .avatar-placeholder {
                width: 115px;
                height: 115px;
            }

            .avatar-placeholder {
                font-size: 40px;
            }

            .profile-name {
                font-size: 22px;
            }

            .save-btn,
            .outline-btn {
                width: 100%;
            }

            .table {
                min-width: 600px;
            }
        }
    </style>
</head>


<body
    data-sb-theme="{{ $customerTheme }}"
    data-customer-theme="{{ $customerTheme }}"
>

<div class="profile-wrapper">

    <div class="profile-container">

        {{-- TOP BAR --}}
        <div class="profile-topbar">

            <div class="brand-title">

                <div class="brand-icon">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div>
                    <h1>My Profile</h1>
                    <span>Manage your SMART BASKET account</span>
                </div>

            </div>

            <a
                href="/products"
                class="back-btn"
            >
                <i class="fa-solid fa-arrow-left me-2"></i>
                Continue Shopping
            </a>

        </div>


        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="premium-alert">

                <i class="fa-solid fa-circle-check text-success me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        @if($errors->any())

            <div class="premium-alert">

                <strong class="text-danger">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    Please fix the following:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <div class="row g-4">

            {{-- LEFT --}}
            <div class="col-lg-4">

                <div class="profile-card p-4">

                    <div class="profile-header">

                        <div class="avatar-wrapper">

                            @if($user->profile_image)

                                <img
                                    src="{{ asset('storage/profile/'.$user->profile_image) }}"
                                    class="avatar"
                                    alt="Profile"
                                >

                            @else

                                <div class="avatar-placeholder">

                                    {{ strtoupper(substr($user->name,0,1)) }}

                                </div>

                            @endif

                            <span class="online-dot"></span>

                        </div>

                        <div class="profile-name">
                            {{ $user->name }}
                        </div>

                        <p class="profile-email">
                            {{ $user->email }}
                        </p>

                        <div class="verified-badge">

                            <i class="fa-solid fa-shield-check"></i>

                            Account Protected

                        </div>

                    </div>


                    <hr class="premium-divider">


                    <form
                        action="{{ route('profile.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        <div class="section-heading">

                            <div class="section-icon">
                                <i class="fa-solid fa-id-card"></i>
                            </div>

                            <div>

                                <h2>Personal Details</h2>

                                <p>Update your account information</p>

                            </div>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Profile Photo
                            </label>

                            <input
                                type="file"
                                name="profile_image"
                                class="form-control"
                                accept="image/*"
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name',$user->name) }}"
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                value="{{ old('username',$user->username) }}"
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email',$user->email) }}"
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Phone
                            </label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                value="{{ old('phone',$user->phone) }}"
                            >

                        </div>


                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Date Of Birth
                                </label>

                                <input
                                    type="date"
                                    name="date_of_birth"
                                    class="form-control"
                                    value="{{ old('date_of_birth',$user->date_of_birth) }}"
                                >

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Gender
                                </label>

                                <select
                                    name="gender"
                                    class="form-select"
                                >

                                    <option value="">
                                        Select
                                    </option>

                                    <option
                                        value="Male"
                                        @selected(old('gender',$user->gender) === 'Male')
                                    >
                                        Male
                                    </option>

                                    <option
                                        value="Female"
                                        @selected(old('gender',$user->gender) === 'Female')
                                    >
                                        Female
                                    </option>

                                    <option
                                        value="Other"
                                        @selected(old('gender',$user->gender) === 'Other')
                                    >
                                        Other
                                    </option>

                                </select>

                            </div>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Address
                            </label>

                            <textarea
                                name="address"
                                class="form-control"
                                rows="3"
                            >{{ old('address',$user->address) }}</textarea>

                        </div>


                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    House No
                                </label>

                                <input
                                    type="text"
                                    name="house_no"
                                    class="form-control"
                                    value="{{ old('house_no',$user->house_no) }}"
                                >

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Street
                                </label>

                                <input
                                    type="text"
                                    name="street"
                                    class="form-control"
                                    value="{{ old('street',$user->street) }}"
                                >

                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Area
                                </label>

                                <input
                                    type="text"
                                    name="area"
                                    class="form-control"
                                    value="{{ old('area',$user->area) }}"
                                >

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Landmark
                                </label>

                                <input
                                    type="text"
                                    name="landmark"
                                    class="form-control"
                                    value="{{ old('landmark',$user->landmark) }}"
                                >

                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    City
                                </label>

                                <input
                                    type="text"
                                    name="city"
                                    class="form-control"
                                    value="{{ old('city',$user->city) }}"
                                >

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    State
                                </label>

                                <input
                                    type="text"
                                    name="state"
                                    class="form-control"
                                    value="{{ old('state',$user->state) }}"
                                >

                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Country
                                </label>

                                <input
                                    type="text"
                                    name="country"
                                    class="form-control"
                                    value="{{ old('country',$user->country) }}"
                                >

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    PIN Code
                                </label>

                                <input
                                    type="text"
                                    name="pin_code"
                                    class="form-control"
                                    value="{{ old('pin_code',$user->pin_code) }}"
                                >

                            </div>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Language
                            </label>

                            <select
                                name="language"
                                class="form-select"
                            >

                                <option
                                    value="English"
                                    @selected(old('language',$user->language) === 'English')
                                >
                                    English
                                </option>

                                <option
                                    value="Hindi"
                                    @selected(old('language',$user->language) === 'Hindi')
                                >
                                    Hindi
                                </option>

                                <option
                                    value="Other"
                                    @selected(old('language',$user->language) === 'Other')
                                >
                                    Other
                                </option>

                            </select>

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
                                class="form-select"
                            >

                                <option
                                    value="light"
                                    @selected(old('dark_mode',$user->dark_mode) === 'light')
                                >
                                    ☀️ Light
                                </option>

                                <option
                                    value="dark"
                                    @selected(old('dark_mode',$user->dark_mode) === 'dark')
                                >
                                    🌙 Dark
                                </option>

                                <option
                                    value="system"
                                    @selected(old('dark_mode',$user->dark_mode) === 'system')
                                >
                                    💻 System Default
                                </option>

                            </select>

                            <small
                                style="color:var(--profile-muted);"
                            >
                                This theme will also be used across your customer pages.
                            </small>

                        </div>


                        {{-- NOTIFICATION --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Notifications
                            </label>

                            <select
                                name="notifications"
                                class="form-select"
                            >

                                <option
                                    value="enabled"
                                    @selected(old('notifications',$user->notifications) === 'enabled')
                                >
                                    🔔 Enabled
                                </option>

                                <option
                                    value="disabled"
                                    @selected(old('notifications',$user->notifications) === 'disabled')
                                >
                                    🔕 Disabled
                                </option>

                            </select>

                        </div>


                        <hr class="premium-divider">


                        <div class="section-heading">

                            <div class="section-icon">
                                <i class="fa-solid fa-lock"></i>
                            </div>

                            <div>

                                <h2>Change Password</h2>

                                <p>Keep your account secure</p>

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


                        <div class="d-flex flex-wrap gap-2">

                            <button
                                type="submit"
                                class="save-btn"
                            >
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                Save Profile
                            </button>

                            <a
                                href="/products"
                                class="outline-btn"
                            >
                                Back
                            </a>

                        </div>

                    </form>

                </div>

            </div>


            {{-- RIGHT --}}
            <div class="col-lg-8">

                {{-- SECURITY --}}
                <div class="profile-card p-4 mb-4">

                    <div class="section-heading">

                        <div class="section-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>

                        <div>

                            <h2>Security Center</h2>

                            <p>Protect your SMART BASKET account</p>

                        </div>

                    </div>


                    @if(session('security_success'))

                        <div class="premium-alert">
                            {{ session('security_success') }}
                        </div>

                    @endif


                    @if(
                        $user->securitySetting &&
                        $user->securitySetting->security_enabled
                    )

                        <div class="security-status enabled">

                            <div class="security-icon">
                                <i class="fa-solid fa-shield-check"></i>
                            </div>

                            <div>
                                <strong>Security PIN Enabled</strong>
                                <span>Your account has an extra layer of protection.</span>
                            </div>

                        </div>


                        <form
                            action="{{ route('security.disable') }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                class="btn btn-danger rounded-4 px-4 fw-bold"
                            >
                                <i class="fa-solid fa-lock-open me-2"></i>
                                Disable PIN
                            </button>

                        </form>

                    @else

                        <div class="security-status disabled">

                            <div class="security-icon">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>

                            <div>
                                <strong>Security PIN Not Setup</strong>
                                <span>Create a PIN to improve account security.</span>
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
                                    class="form-control"
                                    placeholder="Confirm PIN"
                                    required
                                >

                            </div>


                            <button
                                class="save-btn"
                                type="submit"
                            >
                                <i class="fa-solid fa-shield me-2"></i>
                                Enable Security PIN
                            </button>

                        </form>

                    @endif

                </div>


                {{-- ORDERS --}}
                <div class="profile-card p-4">

                    <div class="section-heading">

                        <div class="section-icon">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>

                        <div>

                            <h2>My Orders</h2>

                            <p>Your recent shopping activity</p>

                        </div>

                    </div>


                    @php
                        $orders = $user->orders()->latest()->get();
                    @endphp


                    @if($orders->count() == 0)

                        <div class="empty-orders">

                            <i class="fa-solid fa-box-open d-block"></i>

                            <strong>No Orders Yet</strong>

                            <div>
                                Start shopping and your orders will appear here.
                            </div>

                        </div>

                    @else

                        <div class="order-table-wrapper">

                            <div class="table-responsive">

                                <table class="table align-middle">

                                    <thead>

                                        <tr>

                                            <th>Order</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>

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
                                                    ₹{{ number_format($order->total,2) }}
                                                </td>

                                                <td>

                                                    <span class="status-badge">
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


        {{-- LOGOUT --}}
        <div class="logout-area">

            <form
                action="{{ route('logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-btn"
                >
                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                    Logout from SMART BASKET
                </button>

            </form>

        </div>

    </div>

</div>


<x-ai-hub-sidebar />


<script>

(function () {

    const savedTheme =
        document.body.dataset.customerTheme || 'light';

    const themeSelect =
        document.getElementById('themeSelect');


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

        document.documentElement.setAttribute(
            'data-sb-theme',
            finalTheme
        );

        document.body.setAttribute(
            'data-sb-theme',
            finalTheme
        );
    }


    // Page load par saved theme
    applyTheme(savedTheme);


    // Dropdown change karte hi preview
    if (themeSelect) {

        themeSelect.addEventListener(
            'change',
            function () {

                applyTheme(this.value);

            }
        );

    }


    // System theme change
    const media =
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        );


    media.addEventListener(
        'change',
        function () {

            if (
                themeSelect &&
                themeSelect.value === 'system'
            ) {
                applyTheme('system');
            }

        }
    );


    // Success message auto hide
    setTimeout(function () {

        document
            .querySelectorAll('.premium-alert')
            .forEach(function (alert) {

                if (
                    alert.innerText.includes('success') ||
                    alert.innerText.includes('Successfully')
                ) {

                    alert.style.transition =
                        'opacity .5s ease';

                    alert.style.opacity = '0';

                    setTimeout(
                        () => alert.remove(),
                        600
                    );

                }

            });

    }, 4000);

})();

</script>


</body>
</html>