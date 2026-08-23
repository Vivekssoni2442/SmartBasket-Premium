<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seller Email Verification | SmartBasket Premium</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at top left, #243b55, transparent 35%),
                radial-gradient(circle at bottom right, #141e30, transparent 40%),
                #080b12;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
        }

        .container {
            width: 100%;
            max-width: 600px;
        }

        .card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 25px 70px rgba(0,0,0,0.45);
        }

        .brand {
            text-align: center;
            margin-bottom: 25px;
        }

        .brand h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: 1px;
        }

        .brand p {
            margin-top: 8px;
            color: #aeb8c8;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 35px;
            gap: 8px;
        }

        .step {
            flex: 1;
            text-align: center;
        }

        .circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 1px solid rgba(255,255,255,0.25);
            background: rgba(255,255,255,0.08);
            color: #aeb8c8;
        }

        .step.active .circle {
            background: #fff;
            color: #111;
        }

        .step-title {
            margin-top: 7px;
            font-size: 11px;
            color: #aeb8c8;
        }

        .step.active .step-title {
            color: #fff;
        }

        h2 {
            margin-bottom: 10px;
            font-size: 23px;
        }

        .description {
            color: #aeb8c8;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .email-box {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            padding: 15px;
            border-radius: 14px;
            margin-bottom: 20px;
        }

        .email-label {
            color: #9da8ba;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .email {
            font-weight: bold;
            word-break: break-all;
        }

        .alert {
            padding: 13px 15px;
            border-radius: 12px;
            margin-bottom: 18px;
            line-height: 1.5;
        }

        .success {
            background: rgba(34,197,94,0.15);
            border: 1px solid rgba(34,197,94,0.35);
            color: #9af5b5;
        }

        .error {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.35);
            color: #ffaaaa;
        }

        .info {
            background: rgba(59,130,246,0.15);
            border: 1px solid rgba(59,130,246,0.35);
            color: #a9c9ff;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #dbe2ed;
        }

        input {
            width: 100%;
            padding: 15px;
            border-radius: 13px;
            border: 1px solid rgba(255,255,255,0.18);
            background: rgba(0,0,0,0.25);
            color: white;
            outline: none;
            font-size: 17px;
            letter-spacing: 3px;
            text-align: center;
        }

        input:focus {
            border-color: rgba(255,255,255,0.55);
        }

        button {
            width: 100%;
            padding: 15px;
            border: 0;
            border-radius: 13px;
            background: white;
            color: #111;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            opacity: 0.9;
        }

        .secondary {
            background: rgba(255,255,255,0.08);
            color: white;
            border: 1px solid rgba(255,255,255,0.15);
        }

        .divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 28px 0;
        }

        .hint {
            text-align: center;
            color: #8995a8;
            font-size: 12px;
            margin-top: 15px;
            line-height: 1.6;
        }

        @media (max-width: 500px) {
            .card {
                padding: 24px;
            }

            .brand h1 {
                font-size: 23px;
            }

            .step-title {
                font-size: 9px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <!-- BRAND -->
        <div class="brand">
            <h1>SMART BASKET PREMIUM</h1>
            <p>Seller Partner Program</p>
        </div>

        <!-- STEPS -->
        <div class="steps">

            <div class="step active">
                <div class="circle">1</div>
                <div class="step-title">EMAIL</div>
            </div>

            <div class="step">
                <div class="circle">2</div>
                <div class="step-title">DOCUMENTS</div>
            </div>

            <div class="step">
                <div class="circle">3</div>
                <div class="step-title">AADHAAR</div>
            </div>

            <div class="step">
                <div class="circle">4</div>
                <div class="step-title">BUSINESS</div>
            </div>

            <div class="step">
                <div class="circle">5</div>
                <div class="step-title">BANK</div>
            </div>

            <div class="step">
                <div class="circle">6</div>
                <div class="step-title">REVIEW</div>
            </div>

        </div>


        <!-- MESSAGES -->

        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert info">
                {{ session('info') }}
            </div>
        @endif


        <h2>Verify Your Email</h2>

        <div class="description">
            Before continuing with your Seller Partner application,
            please verify your registered email address.
        </div>


        <!-- SELLER EMAIL -->

        <div class="email-box">

            <div class="email-label">
                REGISTERED EMAIL
            </div>

            <div class="email">
                {{ $seller->email }}
            </div>

        </div>


        <!-- SEND CODE -->

        <form method="POST"
              action="{{ route('seller.verification.email.send') }}">

            @csrf

            <button type="submit">
                SEND VERIFICATION CODE
            </button>

        </form>


        <div class="divider"></div>


        <!-- VERIFY CODE -->

        <form method="POST"
              action="{{ route('seller.verification.email.verify') }}">

            @csrf

            <label for="code">
                Enter 16-digit verification code
            </label>

            <input
                type="text"
                id="code"
                name="code"
                maxlength="16"
                minlength="16"
                pattern="[0-9]{16}"
                inputmode="numeric"
                autocomplete="one-time-code"
                placeholder="••••••••••••••••"
                value="{{ old('code') }}"
                required
            >

            @error('code')
                <div class="alert error" style="margin-top:12px;">
                    {{ $message }}
                </div>
            @enderror

            <button type="submit">
                VERIFY EMAIL & CONTINUE
            </button>

        </form>


        <div class="hint">
            A 16-digit verification code will be sent to your registered
            email address. The code is valid for 10 minutes.
        </div>

    </div>

</div>

</body>
</html>