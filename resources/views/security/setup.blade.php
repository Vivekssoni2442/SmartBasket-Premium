<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Setup Security PIN - Smart Basket</title>

    <link
        rel="stylesheet"
        href="{{ asset('css/customer-ui.css') }}"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 18px;
            overflow-x: hidden;

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            color: #fff;

            background:
                radial-gradient(
                    circle at 15% 15%,
                    rgba(99, 102, 241, .22),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 85% 85%,
                    rgba(168, 85, 247, .20),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 50% 50%,
                    rgba(59, 130, 246, .07),
                    transparent 45%
                ),
                #070b13;
        }


        /* =========================================================
           BACKGROUND GLOW
        ========================================================= */

        .security-bg {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .security-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(10px);
            opacity: .45;
            animation: floatOrb 8s ease-in-out infinite;
        }

        .security-orb.one {
            width: 240px;
            height: 240px;
            top: -80px;
            left: -70px;

            background:
                radial-gradient(
                    circle,
                    rgba(99,102,241,.40),
                    transparent 70%
                );
        }

        .security-orb.two {
            width: 300px;
            height: 300px;
            right: -100px;
            bottom: -100px;

            background:
                radial-gradient(
                    circle,
                    rgba(168,85,247,.38),
                    transparent 70%
                );

            animation-delay: -3s;
        }

        .security-orb.three {
            width: 150px;
            height: 150px;
            top: 45%;
            right: 15%;

            background:
                radial-gradient(
                    circle,
                    rgba(59,130,246,.20),
                    transparent 70%
                );

            animation-delay: -5s;
        }

        @keyframes floatOrb {

            0%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            50% {
                transform: translate3d(0, -18px, 0);
            }
        }


        /* =========================================================
           MAIN WRAPPER
        ========================================================= */

        .security-wrapper {
            position: relative;
            z-index: 2;
            width: min(470px, 100%);
        }


        /* =========================================================
           CARD
        ========================================================= */

        .security-card {

            position: relative;

            width: 100%;

            padding: 38px;

            border-radius: 30px;

            background:
                linear-gradient(
                    145deg,
                    rgba(25, 30, 45, .96),
                    rgba(12, 16, 27, .94)
                );

            border:
                1px solid rgba(255,255,255,.11);

            box-shadow:
                0 40px 100px rgba(0,0,0,.58),
                inset 0 1px 0 rgba(255,255,255,.06);

            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);

            overflow: hidden;

            animation:
                cardEnter .65s cubic-bezier(.2,.8,.2,1);
        }

        @keyframes cardEnter {

            from {
                opacity: 0;
                transform:
                    translateY(25px)
                    scale(.97);
            }

            to {
                opacity: 1;
                transform:
                    translateY(0)
                    scale(1);
            }
        }


        /* Top RGB line */

        .security-card::before {

            content: "";

            position: absolute;

            top: 0;
            left: 8%;
            right: 8%;

            height: 2px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    #6366f1,
                    #a855f7,
                    #3b82f6,
                    transparent
                );

            box-shadow:
                0 0 20px rgba(99,102,241,.8),
                0 0 40px rgba(168,85,247,.45);

            animation: rgbLine 4s linear infinite;
        }

        @keyframes rgbLine {

            0% {
                opacity: .45;
                transform: scaleX(.75);
            }

            50% {
                opacity: 1;
                transform: scaleX(1);
            }

            100% {
                opacity: .45;
                transform: scaleX(.75);
            }
        }


        /* =========================================================
           ICON
        ========================================================= */

        .security-icon-wrap {

            width: 88px;
            height: 88px;

            margin: 0 auto 22px;

            padding: 1px;

            border-radius: 27px;

            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #8b5cf6,
                    #a855f7
                );

            box-shadow:
                0 15px 40px rgba(99,102,241,.25);
        }

        .security-icon {

            width: 100%;
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 26px;

            background:
                linear-gradient(
                    145deg,
                    rgba(99,102,241,.18),
                    rgba(168,85,247,.08)
                );

            color: #c7d2fe;

            font-size: 34px;

            animation:
                shieldPulse 3s ease-in-out infinite;
        }

        @keyframes shieldPulse {

            0%,
            100% {
                transform: scale(1);
                filter: drop-shadow(
                    0 0 0 rgba(129,140,248,0)
                );
            }

            50% {
                transform: scale(1.05);
                filter: drop-shadow(
                    0 0 12px rgba(129,140,248,.35)
                );
            }
        }


        /* =========================================================
           TITLE
        ========================================================= */

        .security-title {

            margin: 0;

            text-align: center;

            font-size: 29px;

            font-weight: 850;

            letter-spacing: -.7px;

            color: #ffffff;
        }

        .security-title span {

            background:
                linear-gradient(
                    90deg,
                    #a5b4fc,
                    #c084fc,
                    #818cf8
                );

            -webkit-background-clip: text;
            background-clip: text;

            -webkit-text-fill-color: transparent;
        }

        .security-subtitle {

            max-width: 350px;

            margin:
                10px auto 30px;

            text-align: center;

            color: #8f9aae;

            font-size: 14px;

            line-height: 1.65;
        }


        /* =========================================================
           FORM
        ========================================================= */

        .security-form {
            width: 100%;
        }

        .security-field {
            margin-bottom: 19px;
        }

        .security-label {

            display: flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 8px;

            color: #b7c0d0;

            font-size: 11px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .7px;
        }

        .security-label i {
            color: #818cf8;
            font-size: 11px;
        }


        /* =========================================================
           INPUT
        ========================================================= */

        .security-input-wrap {
            position: relative;
        }

        .security-input {

            width: 100%;
            height: 56px;

            padding:
                0 48px
                0 17px;

            border-radius: 16px;

            border:
                1px solid rgba(255,255,255,.09);

            background:
                rgba(255,255,255,.045);

            color: #fff;

            outline: none;

            font-size: 15px;

            transition:
                border-color .25s ease,
                background .25s ease,
                box-shadow .25s ease,
                transform .25s ease;
        }

        .security-input::placeholder {
            color: #687386;
        }

        .security-input:hover {
            background:
                rgba(255,255,255,.06);
        }

        .security-input:focus {

            border-color:
                rgba(129,140,248,.75);

            background:
                rgba(99,102,241,.055);

            box-shadow:
                0 0 0 4px
                rgba(99,102,241,.09),
                0 8px 25px
                rgba(0,0,0,.12);
        }

        .input-icon {

            position: absolute;

            left: 17px;
            top: 50%;

            transform:
                translateY(-50%);

            color: #687386;

            pointer-events: none;

            font-size: 14px;
        }


        /* =========================================================
           SHOW/HIDE BUTTON
        ========================================================= */

        .toggle-pin {

            position: absolute;

            right: 13px;
            top: 50%;

            transform:
                translateY(-50%);

            width: 34px;
            height: 34px;

            border: 0;

            border-radius: 10px;

            background: transparent;

            color: #737e92;

            cursor: pointer;

            transition:
                color .2s ease,
                background .2s ease;
        }

        .toggle-pin:hover {

            color: #c7d2fe;

            background:
                rgba(129,140,248,.10);
        }


        /* =========================================================
           PIN DOT HINT
        ========================================================= */

        .pin-hint {

            display: flex;

            align-items: center;

            gap: 7px;

            margin-top: 8px;

            color: #667085;

            font-size: 11px;
        }

        .pin-hint i {
            color: #818cf8;
        }


        /* =========================================================
           BUTTON
        ========================================================= */

        .security-button {

            position: relative;

            width: 100%;
            height: 58px;

            margin-top: 7px;

            border: 0;

            border-radius: 17px;

            color: #fff;

            font-size: 14px;

            font-weight: 850;

            letter-spacing: .15px;

            background:
                linear-gradient(
                    110deg,
                    #4f46e5,
                    #7c3aed,
                    #9333ea
                );

            box-shadow:
                0 12px 30px
                rgba(99,102,241,.25);

            cursor: pointer;

            overflow: hidden;

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        .security-button::before {

            content: "";

            position: absolute;

            top: 0;
            left: -120%;

            width: 80%;
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.22),
                    transparent
                );

            transform: skewX(-20deg);

            transition:
                left .65s ease;
        }

        .security-button:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 18px 38px
                rgba(99,102,241,.34);
        }

        .security-button:hover::before {
            left: 140%;
        }

        .security-button:active {
            transform: translateY(0);
        }

        .security-button i {
            margin-right: 8px;
        }


        /* =========================================================
           ERROR
        ========================================================= */

        .security-error {

            display: flex;
            align-items: center;
            gap: 10px;

            padding: 13px 15px;

            margin-bottom: 20px;

            border-radius: 14px;

            background:
                rgba(239,68,68,.08);

            border:
                1px solid rgba(239,68,68,.18);

            color: #fca5a5;

            font-size: 13px;

            animation:
                errorShake .35s ease;
        }

        @keyframes errorShake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .security-footer {

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 7px;

            margin-top: 23px;

            color: #626d80;

            font-size: 11px;
        }

        .security-footer i {
            color: #818cf8;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 520px) {

            body {
                padding: 18px 13px;
            }

            .security-card {
                padding: 30px 21px;
                border-radius: 25px;
            }

            .security-title {
                font-size: 25px;
            }

            .security-icon-wrap {
                width: 78px;
                height: 78px;
                border-radius: 24px;
            }

            .security-icon {
                border-radius: 23px;
                font-size: 30px;
            }

        }

    </style>

</head>


<body>

    <!-- =========================================================
         BACKGROUND
    ========================================================= -->

    <div class="security-bg">

        <div class="security-orb one"></div>

        <div class="security-orb two"></div>

        <div class="security-orb three"></div>

    </div>


    <!-- =========================================================
         SECURITY CARD
    ========================================================= -->

    <main class="security-wrapper">

        <section class="security-card">


            <!-- ICON -->

            <div class="security-icon-wrap">

                <div class="security-icon">

                    <i class="fa-solid fa-shield-halved"></i>

                </div>

            </div>


            <!-- TITLE -->

            <h1 class="security-title">

                Create <span>Security PIN</span>

            </h1>


            <p class="security-subtitle">

                Add an extra layer of protection to your
                Smart Basket account with a secure PIN.

            </p>


            <!-- ERROR -->

            @if(session('error'))

                <div class="security-error">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            <!-- FORM -->

            <form
                action="{{ route('security.save') }}"
                method="POST"
                class="security-form"
            >

                @csrf


                <!-- EMAIL -->

                <div class="security-field">

                    <label
                        class="security-label"
                        for="email"
                    >

                        <i class="fa-solid fa-envelope"></i>

                        Email ID

                    </label>


                    <div class="security-input-wrap">

                        <i
                            class="fa-solid fa-at input-icon"
                        ></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="security-input"
                            value="{{ old('email', auth()->user()->email) }}"
                            required
                            autocomplete="email"
                            placeholder="Enter your email"
                        >

                    </div>

                </div>


                <!-- PIN -->

                <div class="security-field">

                    <label
                        class="security-label"
                        for="pin"
                    >

                        <i class="fa-solid fa-lock"></i>

                        Security PIN

                    </label>


                    <div class="security-input-wrap">

                        <i
                            class="fa-solid fa-key input-icon"
                        ></i>

                        <input
                            type="password"
                            id="pin"
                            name="pin"
                            class="security-input"
                            maxlength="6"
                            minlength="4"
                            inputmode="numeric"
                            pattern="[0-9]{4,6}"
                            required
                            autocomplete="new-password"
                            placeholder="4 to 6 digit PIN"
                        >

                        <button
                            type="button"
                            class="toggle-pin"
                            data-target="pin"
                            aria-label="Show PIN"
                        >

                            <i class="fa-solid fa-eye"></i>

                        </button>

                    </div>


                    <div class="pin-hint">

                        <i class="fa-solid fa-circle-info"></i>

                        Use a 4–6 digit PIN.

                    </div>

                </div>


                <!-- CONFIRM PIN -->

                <div class="security-field">

                    <label
                        class="security-label"
                        for="pin_confirmation"
                    >

                        <i class="fa-solid fa-shield-check"></i>

                        Confirm Security PIN

                    </label>


                    <div class="security-input-wrap">

                        <i
                            class="fa-solid fa-check-double input-icon"
                        ></i>

                        <input
                            type="password"
                            id="pin_confirmation"
                            name="pin_confirmation"
                            class="security-input"
                            maxlength="6"
                            minlength="4"
                            inputmode="numeric"
                            pattern="[0-9]{4,6}"
                            required
                            autocomplete="new-password"
                            placeholder="Re-enter your PIN"
                        >

                        <button
                            type="button"
                            class="toggle-pin"
                            data-target="pin_confirmation"
                            aria-label="Show PIN"
                        >

                            <i class="fa-solid fa-eye"></i>

                        </button>

                    </div>

                </div>


                <!-- BUTTON -->

                <button
                    type="submit"
                    class="security-button"
                >

                    <i class="fa-solid fa-lock"></i>

                    Create Security PIN

                </button>

            </form>


            <!-- FOOTER -->

            <div class="security-footer">

                <i class="fa-solid fa-shield-halved"></i>

                Your security matters to Smart Basket.

            </div>


        </section>

    </main>


    <script>

        /*
        |--------------------------------------------------------------------------
        | NUMERIC PIN ONLY
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                'input[inputmode="numeric"]'
            )
            .forEach(function(input) {

                input.addEventListener(
                    'input',
                    function() {

                        this.value =
                            this.value
                                .replace(/\D/g, '')
                                .slice(0, 6);

                    }
                );

            });


        /*
        |--------------------------------------------------------------------------
        | SHOW / HIDE PIN
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.toggle-pin')
            .forEach(function(button) {

                button.addEventListener(
                    'click',
                    function() {

                        const targetId =
                            this.getAttribute(
                                'data-target'
                            );

                        const input =
                            document.getElementById(
                                targetId
                            );

                        const icon =
                            this.querySelector('i');


                        if (!input) {
                            return;
                        }


                        if (
                            input.type === 'password'
                        ) {

                            input.type = 'text';

                            icon.className =
                                'fa-solid fa-eye-slash';

                            this.setAttribute(
                                'aria-label',
                                'Hide PIN'
                            );

                        } else {

                            input.type = 'password';

                            icon.className =
                                'fa-solid fa-eye';

                            this.setAttribute(
                                'aria-label',
                                'Show PIN'
                            );

                        }

                    }
                );

            });

    </script>

</body>

</html>