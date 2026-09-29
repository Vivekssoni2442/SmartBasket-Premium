<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Security PIN - Smart Basket</title>

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
            min-height: 100%;
        }

        body {

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;

            overflow: hidden;

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                radial-gradient(
                    circle at 15% 15%,
                    rgba(99,102,241,.22),
                    transparent 34%
                ),
                radial-gradient(
                    circle at 85% 85%,
                    rgba(168,85,247,.20),
                    transparent 34%
                ),
                #070b13;

            color: white;
        }


        /* =====================================================
           BACKGROUND
        ===================================================== */

        .security-background {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .orb {

            position: absolute;

            border-radius: 50%;

            filter: blur(12px);

            animation:
                floating 8s ease-in-out infinite;
        }

        .orb-1 {

            width: 260px;
            height: 260px;

            left: -100px;
            top: -90px;

            background:
                radial-gradient(
                    circle,
                    rgba(99,102,241,.38),
                    transparent 70%
                );
        }

        .orb-2 {

            width: 320px;
            height: 320px;

            right: -130px;
            bottom: -130px;

            background:
                radial-gradient(
                    circle,
                    rgba(168,85,247,.35),
                    transparent 70%
                );

            animation-delay: -3s;
        }

        .orb-3 {

            width: 150px;
            height: 150px;

            right: 18%;
            top: 20%;

            background:
                radial-gradient(
                    circle,
                    rgba(59,130,246,.16),
                    transparent 70%
                );

            animation-delay: -5s;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }

        }


        /* =====================================================
           CARD
        ===================================================== */

        .pin-wrapper {

            position: relative;

            z-index: 5;

            width: min(430px, 100%);
        }

        .pin-card {

            position: relative;

            padding: 38px 34px;

            border-radius: 30px;

            background:
                linear-gradient(
                    145deg,
                    rgba(25,30,45,.96),
                    rgba(10,14,24,.96)
                );

            border:
                1px solid rgba(255,255,255,.10);

            box-shadow:
                0 40px 100px rgba(0,0,0,.60),
                inset 0 1px 0 rgba(255,255,255,.06);

            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);

            overflow: hidden;

            animation:
                cardAppear .65s cubic-bezier(.2,.8,.2,1);
        }

        @keyframes cardAppear {

            from {
                opacity: 0;
                transform:
                    translateY(25px)
                    scale(.96);
            }

            to {
                opacity: 1;
                transform:
                    translateY(0)
                    scale(1);
            }

        }


        /* RGB TOP LINE */

        .pin-card::before {

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
                0 0 20px rgba(99,102,241,.8);

            animation:
                lineGlow 3s ease-in-out infinite;
        }

        @keyframes lineGlow {

            0%,
            100% {
                opacity: .5;
            }

            50% {
                opacity: 1;
            }

        }


        /* =====================================================
           LOCK
        ===================================================== */

        .lock-container {

            width: 92px;
            height: 92px;

            margin: 0 auto 23px;

            padding: 2px;

            border-radius: 29px;

            background:
                linear-gradient(
                    135deg,
                    #6366f1,
                    #8b5cf6,
                    #a855f7
                );

            box-shadow:
                0 15px 45px
                rgba(99,102,241,.25);
        }

        .lock {

            width: 100%;
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 27px;

            background:
                linear-gradient(
                    145deg,
                    rgba(99,102,241,.18),
                    rgba(168,85,247,.08)
                );

            color: #c7d2fe;

            font-size: 37px;

            animation:
                lockPulse 3s ease-in-out infinite;
        }

        @keyframes lockPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.06);
            }

        }


        /* =====================================================
           TITLE
        ===================================================== */

        .pin-title {

            margin: 0;

            text-align: center;

            font-size: 29px;

            font-weight: 850;

            letter-spacing: -.7px;
        }

        .pin-title span {

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

        .pin-subtitle {

            margin:
                10px auto 28px;

            max-width: 330px;

            text-align: center;

            color: #8d98ab;

            font-size: 14px;

            line-height: 1.6;
        }


        /* =====================================================
           ERROR
        ===================================================== */

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
                1px solid rgba(239,68,68,.20);

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


        /* =====================================================
           LABEL
        ===================================================== */

        .pin-label {

            display: flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 9px;

            color: #b8c0d0;

            font-size: 11px;

            font-weight: 800;

            letter-spacing: .7px;

            text-transform: uppercase;
        }

        .pin-label i {
            color: #818cf8;
        }


        /* =====================================================
           INPUT
        ===================================================== */

        .pin-input-wrapper {

            position: relative;
        }

        .pin-input {

            width: 100%;
            height: 60px;

            padding:
                0 52px
                0 48px;

            border-radius: 17px;

            border:
                1px solid rgba(255,255,255,.10);

            outline: none;

            background:
                rgba(255,255,255,.045);

            color: white;

            font-size: 21px;

            font-weight: 700;

            letter-spacing: 7px;

            text-align: center;

            transition:
                .25s ease;
        }

        .pin-input::placeholder {

            color: #5f6a7d;

            font-size: 14px;

            letter-spacing: 1px;
        }

        .pin-input:focus {

            border-color:
                rgba(129,140,248,.75);

            background:
                rgba(99,102,241,.06);

            box-shadow:
                0 0 0 4px
                rgba(99,102,241,.09),
                0 10px 30px
                rgba(0,0,0,.15);
        }

        .input-icon {

            position: absolute;

            left: 17px;
            top: 50%;

            transform:
                translateY(-50%);

            color: #717c90;

            pointer-events: none;
        }


        /* =====================================================
           SHOW PIN
        ===================================================== */

        .toggle-pin {

            position: absolute;

            right: 12px;
            top: 50%;

            width: 36px;
            height: 36px;

            transform:
                translateY(-50%);

            border: 0;

            border-radius: 10px;

            background: transparent;

            color: #737e91;

            cursor: pointer;

            transition:
                .2s ease;
        }

        .toggle-pin:hover {

            color: #c7d2fe;

            background:
                rgba(129,140,248,.10);
        }


        /* =====================================================
           HINT
        ===================================================== */

        .pin-hint {

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            margin-top: 11px;

            color: #687386;

            font-size: 11px;
        }

        .pin-hint i {
            color: #818cf8;
        }


        /* =====================================================
           BUTTON
        ===================================================== */

        .unlock-button {

            position: relative;

            width: 100%;
            height: 58px;

            margin-top: 24px;

            border: 0;

            border-radius: 17px;

            background:
                linear-gradient(
                    110deg,
                    #4f46e5,
                    #7c3aed,
                    #9333ea
                );

            color: white;

            font-size: 14px;

            font-weight: 850;

            cursor: pointer;

            overflow: hidden;

            box-shadow:
                0 13px 32px
                rgba(99,102,241,.28);

            transition:
                .2s ease;
        }

        .unlock-button::before {

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
                    rgba(255,255,255,.25),
                    transparent
                );

            transform: skewX(-20deg);

            transition:
                left .65s ease;
        }

        .unlock-button:hover {

            transform: translateY(-2px);

            box-shadow:
                0 18px 40px
                rgba(99,102,241,.38);
        }

        .unlock-button:hover::before {
            left: 140%;
        }

        .unlock-button:active {
            transform: translateY(0);
        }

        .unlock-button i {
            margin-right: 8px;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .pin-footer {

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            margin-top: 23px;

            color: #606b7d;

            font-size: 11px;
        }

        .pin-footer i {
            color: #818cf8;
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 480px) {

            body {
                padding: 14px;
            }

            .pin-card {
                padding: 30px 21px;
                border-radius: 26px;
            }

            .lock-container {
                width: 78px;
                height: 78px;
                border-radius: 24px;
            }

            .lock {
                border-radius: 22px;
                font-size: 31px;
            }

            .pin-title {
                font-size: 25px;
            }

            .pin-input {
                height: 56px;
            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         BACKGROUND
    ===================================================== -->

    <div class="security-background">

        <div class="orb orb-1"></div>

        <div class="orb orb-2"></div>

        <div class="orb orb-3"></div>

    </div>


    <!-- =====================================================
         PIN CARD
    ===================================================== -->

    <main class="pin-wrapper">

        <section class="pin-card">


            <!-- LOCK -->

            <div class="lock-container">

                <div class="lock">

                    <i class="fa-solid fa-lock"></i>

                </div>

            </div>


            <!-- TITLE -->

            <h1 class="pin-title">

                Security <span>PIN</span>

            </h1>


            <p class="pin-subtitle">

                Enter your Security PIN to securely
                continue using Smart Basket.

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
                action="{{ route('security.verify') }}"
                method="POST"
            >

                @csrf


                <label
                    class="pin-label"
                    for="pin"
                >

                    <i class="fa-solid fa-key"></i>

                    Enter Security PIN

                </label>


                <div class="pin-input-wrapper">

                    <i
                        class="fa-solid fa-shield-halved input-icon"
                    ></i>


                    <input
                        type="password"
                        id="pin"
                        name="pin"
                        class="pin-input"
                        maxlength="6"
                        minlength="4"
                        inputmode="numeric"
                        pattern="[0-9]{4,6}"
                        placeholder="Enter PIN"
                        required
                        autocomplete="one-time-code"
                    >


                    <button
                        type="button"
                        class="toggle-pin"
                        id="togglePin"
                        aria-label="Show PIN"
                    >

                        <i class="fa-solid fa-eye"></i>

                    </button>

                </div>


                <div class="pin-hint">

                    <i class="fa-solid fa-circle-info"></i>

                    Enter your 4–6 digit Security PIN

                </div>


                <!-- UNLOCK -->

                <button
                    type="submit"
                    class="unlock-button"
                >

                    <i class="fa-solid fa-unlock-keyhole"></i>

                    Unlock Smart Basket

                </button>

            </form>


            <!-- FOOTER -->

            <div class="pin-footer">

                <i class="fa-solid fa-shield-halved"></i>

                Protected by Smart Basket Security

            </div>


        </section>

    </main>


    <script>

        /* =====================================================
           NUMERIC PIN ONLY
        ===================================================== */

        const pinInput =
            document.getElementById('pin');

        if (pinInput) {

            pinInput.addEventListener(
                'input',
                function () {

                    this.value =
                        this.value
                            .replace(/\D/g, '')
                            .slice(0, 6);

                }
            );

        }


        /* =====================================================
           SHOW / HIDE PIN
        ===================================================== */

        const togglePin =
            document.getElementById('togglePin');

        if (togglePin && pinInput) {

            togglePin.addEventListener(
                'click',
                function () {

                    const icon =
                        this.querySelector('i');

                    if (
                        pinInput.type === 'password'
                    ) {

                        pinInput.type = 'text';

                        icon.className =
                            'fa-solid fa-eye-slash';

                        this.setAttribute(
                            'aria-label',
                            'Hide PIN'
                        );

                    } else {

                        pinInput.type = 'password';

                        icon.className =
                            'fa-solid fa-eye';

                        this.setAttribute(
                            'aria-label',
                            'Show PIN'
                        );

                    }

                    pinInput.focus();

                }
            );

        }

    </script>


</body>

</html>