<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Seller Verification | SmartBasket')
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/premium-dark-theme.css') }}"
    >

    <style>
        body {
            min-height: 100vh;
            background:
                radial-gradient(
                    circle at top right,
                    rgba(99, 102, 241, 0.12),
                    transparent 35%
                ),
                #f8fafc;
        }

        .verification-wrapper {
            max-width: 760px;
            margin: 0 auto;
        }

        .verification-card {
            border: 0;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.10);
            overflow: hidden;
        }

        .verification-header {
            padding: 28px 30px;
            background: linear-gradient(
                135deg,
                #111827,
                #1e293b
            );
            color: #fff;
        }

        .verification-body {
            padding: 30px;
        }

        .brand {
            font-weight: 800;
            letter-spacing: .3px;
        }

        .alert {
            border-radius: 14px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 12px 14px;
        }

        .btn {
            border-radius: 12px;
            padding: 11px 18px;
        }
    </style>

    @stack('styles')
</head>

<body>

<main class="container py-5">

    <div class="verification-wrapper">

        <div class="mb-4">
            <a
                href="{{ route('seller.login') }}"
                class="text-decoration-none fw-semibold"
            >
                &larr; Back to Seller Login
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="verification-card">

            <div class="verification-header">
                <div class="brand fs-4">
                    SmartBasket Premium
                </div>

                <div class="mt-2 opacity-75">
                    Seller Verification &amp; KYC
                </div>
            </div>

            <div class="verification-body">

                @yield('content')

            </div>

        </div>

    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>