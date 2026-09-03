@extends('layouts.admin')

@section('title', 'My Profile')

@section('breadcrumbs')
    My Profile
@endsection

@section('content')

<div class="admin-profile-page">

    {{-- HEADER --}}
    <div class="profile-hero">

        <div class="profile-hero-left">

            <div class="profile-big-avatar">
                {{ $initials }}
            </div>

            <div>
                <div class="profile-eyebrow">
                    ADMINISTRATOR ACCOUNT
                </div>

                <h1>{{ $name }}</h1>

                <p>
                    {{ $email }}
                </p>

                <div class="profile-tags">
                    <span>
                        <i class="fa-solid fa-shield-halved"></i>
                        Administrator
                    </span>

                    <span>
                        <i class="fa-solid fa-circle-check"></i>
                        Active
                    </span>
                </div>
            </div>

        </div>

        <div class="profile-hero-right">

            <div class="hero-id">
                <span>ADMIN ID</span>
                <strong>{{ $admin->id ?? 'N/A' }}</strong>
            </div>

        </div>

    </div>


    @if(session('success'))
        <div class="profile-alert success">
            <i class="fa-solid fa-circle-check"></i>

            <span>
                {{ session('success') }}
            </span>
        </div>
    @endif


    @if($errors->any())
        <div class="profile-alert error">
            <i class="fa-solid fa-triangle-exclamation"></i>

            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif


    <div class="profile-grid">

        {{-- PERSONAL INFORMATION --}}
        <section class="profile-card">

            <div class="card-heading">
                <div class="card-icon">
                    <i class="fa-regular fa-user"></i>
                </div>

                <div>
                    <h2>Personal Information</h2>
                    <p>Manage your administrator account details.</p>
                </div>
            </div>


            <form
                method="POST"
                action="{{ route('admin.profile.update') }}"
            >

                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="form-field">

                        <label for="name">
                            Full Name
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $name) }}"
                            required
                        >

                    </div>


                    <div class="form-field">

                        <label for="email">
                            Email Address
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $email) }}"
                            required
                        >

                    </div>

                </div>


                <div class="form-field">

                    <label>
                        Administrator ID
                    </label>

                    <input
                        type="text"
                        value="{{ $admin->id ?? 'N/A' }}"
                        readonly
                        class="readonly-field"
                    >

                </div>


                <div class="form-actions">

                    <button
                        type="submit"
                        class="profile-primary-btn"
                    >
                        <i class="fa-solid fa-check"></i>
                        Save Changes
                    </button>

                </div>

            </form>

        </section>


        {{-- ACCOUNT --}}
        <section class="profile-card">

            <div class="card-heading">

                <div class="card-icon">
                    <i class="fa-solid fa-user-shield"></i>
                </div>

                <div>
                    <h2>Account Overview</h2>
                    <p>Current administrator account status.</p>
                </div>

            </div>


            <div class="account-list">

                <div class="account-row">

                    <span>
                        <i class="fa-solid fa-id-card"></i>
                        Account ID
                    </span>

                    <strong>
                        {{ $admin->id ?? 'N/A' }}
                    </strong>

                </div>


                <div class="account-row">

                    <span>
                        <i class="fa-solid fa-user-tie"></i>
                        Role
                    </span>

                    <strong>
                        Administrator
                    </strong>

                </div>


                <div class="account-row">

                    <span>
                        <i class="fa-solid fa-circle"></i>
                        Status
                    </span>

                    <strong class="status-active">
                        Active
                    </strong>

                </div>


                <div class="account-row">

                    <span>
                        <i class="fa-solid fa-clock"></i>
                        Last Activity
                    </span>

                    <strong>
                        @if(!empty($admin->last_activity_at))
                            {{ \Illuminate\Support\Carbon::parse($admin->last_activity_at)->format('d M Y, h:i A') }}
                        @else
                            Not available
                        @endif
                    </strong>

                </div>

            </div>

        </section>


        {{-- PASSWORD --}}
        <section class="profile-card profile-card-wide">

            <div class="card-heading">

                <div class="card-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>

                <div>
                    <h2>Change Password</h2>
                    <p>
                        Update your administrator password securely.
                    </p>
                </div>

            </div>


            <form
                method="POST"
                action="{{ route('admin.profile.update') }}"
            >

                @csrf
                @method('PUT')

                <input
                    type="hidden"
                    name="name"
                    value="{{ $name }}"
                >

                <input
                    type="hidden"
                    name="email"
                    value="{{ $email }}"
                >


                <div class="form-grid">

                    <div class="form-field">

                        <label for="current_password">
                            Current Password
                        </label>

                        <input
                            id="current_password"
                            type="password"
                            name="current_password"
                            autocomplete="current-password"
                        >

                    </div>


                    <div class="form-field">

                        <label for="password">
                            New Password
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="new-password"
                        >

                    </div>


                    <div class="form-field">

                        <label for="password_confirmation">
                            Confirm New Password
                        </label>

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            autocomplete="new-password"
                        >

                    </div>

                </div>


                <div class="password-note">

                    <i class="fa-solid fa-circle-info"></i>

                    <span>
                        Leave the password fields empty if you don't
                        want to change your password.
                    </span>

                </div>


                <div class="form-actions">

                    <button
                        type="submit"
                        class="profile-primary-btn"
                    >
                        <i class="fa-solid fa-key"></i>
                        Update Password
                    </button>

                </div>

            </form>

        </section>


        {{-- SETTINGS --}}
        <section class="profile-card">

            <div class="card-heading">

                <div class="card-icon">
                    <i class="fa-solid fa-sliders"></i>
                </div>

                <div>
                    <h2>Administration</h2>
                    <p>Manage system-level preferences.</p>
                </div>

            </div>


            <a
                href="{{ route('admin.settings') }}"
                class="settings-link"
            >
                <span>
                    <i class="fa-solid fa-gear"></i>
                    Admin Settings
                </span>

                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </section>

    </div>

</div>


<style>

.admin-profile-page {
    padding: 4px 0 40px;
}

.profile-hero {
    position: relative;
    overflow: hidden;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
    padding: 34px;
    margin-bottom: 22px;
    border-radius: 24px;
    background:
        radial-gradient(
            circle at 15% 10%,
            rgba(99,102,241,.25),
            transparent 32%
        ),
        radial-gradient(
            circle at 90% 90%,
            rgba(139,92,246,.18),
            transparent 35%
        ),
        linear-gradient(
            135deg,
            #111827,
            #172033 55%,
            #111827
        );
    border: 1px solid rgba(255,255,255,.08);
    box-shadow: 0 20px 60px rgba(0,0,0,.22);
    color: #fff;
}

.profile-hero-left {
    display: flex;
    align-items: center;
    gap: 22px;
}

.profile-big-avatar {
    width: 92px;
    height: 92px;
    flex: 0 0 92px;
    display: grid;
    place-items: center;
    border-radius: 26px;
    font-size: 32px;
    font-weight: 800;
    background: linear-gradient(
        135deg,
        #6366f1,
        #8b5cf6
    );
    box-shadow:
        0 15px 35px rgba(99,102,241,.35);
}

.profile-eyebrow {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.5px;
    opacity: .65;
    margin-bottom: 6px;
}

.profile-hero h1 {
    margin: 0;
    font-size: 30px;
    font-weight: 800;
}

.profile-hero p {
    margin: 6px 0 13px;
    opacity: .68;
}

.profile-tags {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.profile-tags span {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 11px;
    border-radius: 999px;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.08);
    font-size: 12px;
    font-weight: 700;
}

.hero-id {
    padding: 15px 18px;
    min-width: 180px;
    border-radius: 15px;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.08);
}

.hero-id span {
    display: block;
    font-size: 10px;
    letter-spacing: 1px;
    opacity: .55;
    margin-bottom: 5px;
}

.hero-id strong {
    font-size: 12px;
    word-break: break-all;
}

.profile-alert {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 15px 18px;
    margin-bottom: 20px;
    border-radius: 15px;
    font-size: 14px;
    font-weight: 600;
}

.profile-alert.success {
    background: rgba(16,185,129,.1);
    color: #059669;
    border: 1px solid rgba(16,185,129,.2);
}

.profile-alert.error {
    background: rgba(239,68,68,.1);
    color: #dc2626;
    border: 1px solid rgba(239,68,68,.2);
}

.profile-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.4fr) minmax(300px, .8fr);
    gap: 20px;
}

.profile-card {
    padding: 26px;
    border-radius: 22px;
    background: var(--admin-card, #fff);
    border: 1px solid var(--admin-border, #e5e7eb);
    box-shadow: 0 12px 35px rgba(15,23,42,.06);
}

.profile-card-wide {
    grid-column: 1 / -1;
}

.card-heading {
    display: flex;
    gap: 14px;
    align-items: center;
    margin-bottom: 24px;
}

.card-icon {
    width: 44px;
    height: 44px;
    display: grid;
    place-items: center;
    border-radius: 13px;
    background: rgba(99,102,241,.1);
    color: #6366f1;
}

.card-heading h2 {
    margin: 0;
    font-size: 17px;
    font-weight: 800;
}

.card-heading p {
    margin: 4px 0 0;
    font-size: 12px;
    opacity: .6;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0,1fr));
    gap: 18px;
}

.form-field {
    margin-bottom: 18px;
}

.form-field label {
    display: block;
    margin-bottom: 8px;
    font-size: 12px;
    font-weight: 800;
}

.form-field input {
    width: 100%;
    height: 46px;
    padding: 0 14px;
    border-radius: 12px;
    border: 1px solid var(--admin-border, #e5e7eb);
    background: var(--admin-input, #f9fafb);
    color: inherit;
    outline: none;
    transition: .2s;
}

.form-field input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99,102,241,.1);
}

.readonly-field {
    opacity: .7;
    cursor: not-allowed;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 5px;
}

.profile-primary-btn {
    border: 0;
    border-radius: 12px;
    padding: 12px 18px;
    background: linear-gradient(
        135deg,
        #6366f1,
        #8b5cf6
    );
    color: #fff;
    font-weight: 800;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 10px 24px rgba(99,102,241,.25);
}

.account-list {
    display: flex;
    flex-direction: column;
}

.account-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid var(--admin-border, #e5e7eb);
}

.account-row:last-child {
    border-bottom: 0;
}

.account-row span {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    font-size: 12px;
    opacity: .65;
}

.account-row strong {
    font-size: 12px;
    text-align: right;
    max-width: 60%;
    word-break: break-word;
}

.status-active {
    color: #10b981;
}

.password-note {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 12px 14px;
    margin-bottom: 15px;
    border-radius: 12px;
    background: rgba(99,102,241,.07);
    color: #6366f1;
    font-size: 12px;
}

.settings-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border-radius: 13px;
    text-decoration: none;
    color: inherit;
    background: var(--admin-input, #f9fafb);
    border: 1px solid var(--admin-border, #e5e7eb);
    transition: .2s;
}

.settings-link:hover {
    border-color: #6366f1;
    transform: translateY(-1px);
}

.settings-link span {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 700;
}

@media(max-width: 900px) {

    .profile-hero {
        align-items: flex-start;
        flex-direction: column;
    }

    .hero-id {
        width: 100%;
    }

    .profile-grid {
        grid-template-columns: 1fr;
    }

    .profile-card-wide {
        grid-column: auto;
    }
}

@media(max-width: 600px) {

    .profile-hero {
        padding: 24px;
    }

    .profile-hero-left {
        align-items: flex-start;
        flex-direction: column;
    }

    .profile-hero h1 {
        font-size: 24px;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 0;
    }

    .profile-card {
        padding: 20px;
    }

    .account-row {
        align-items: flex-start;
        flex-direction: column;
    }

    .account-row strong {
        max-width: 100%;
        text-align: left;
    }
}

</style>

@endsection