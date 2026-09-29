@extends('layouts.app')

@section('title', 'SmartBasket Admin - 2FA Verification')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">
                👑 SMART BASKET
            </h1>
            <p class="text-purple-300 text-lg">2FA Verification</p>
        </div>

        <!-- MFA Card -->
        <div class="bg-slate-800/80 backdrop-blur-xl border border-purple-500/20 rounded-2xl p-8 shadow-2xl">
            <!-- Status -->
            <div class="mb-6 text-center">
                <div class="inline-block p-4 bg-purple-500/20 rounded-full mb-4">
                    <i class="fas fa-shield-alt text-purple-400 text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-white mb-2">Two-Factor Authentication</h2>
                <p class="text-gray-400">Enter your 2FA code to continue</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/50 rounded-lg p-4">
                    <p class="text-red-400 font-medium">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ $errors->first() }}
                    </p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/50 rounded-lg p-4">
                    <p class="text-red-400 font-medium">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            <!-- MFA Form -->
            <form method="POST" action="/admin/mfa-verify" class="space-y-5">
                @csrf

                <!-- TOTP Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-300 mb-2">
                        Authentication Code
                    </label>
                    <p class="text-xs text-gray-400 mb-2">
                        Enter the 6-digit code from your authenticator app
                    </p>
                    <input
                        type="text"
                        id="code"
                        name="code"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        required
                        autofocus
                        class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition text-center text-2xl tracking-widest font-mono"
                        placeholder="000000"
                    />
                </div>

                <!-- Recovery Code Option -->
                <div>
                    <details class="cursor-pointer">
                        <summary class="text-sm text-purple-400 hover:text-purple-300 transition">
                            Don't have access to authenticator app?
                        </summary>
                        <div class="mt-3 pt-3 border-t border-slate-600">
                            <label for="recovery_code" class="block text-sm font-medium text-gray-300 mb-2">
                                Recovery Code
                            </label>
                            <p class="text-xs text-gray-400 mb-2">
                                Use a one-time recovery code instead
                            </p>
                            <input
                                type="text"
                                id="recovery_code"
                                name="recovery_code"
                                class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition font-mono"
                                placeholder="XXXX-XXXX"
                            />
                        </div>
                    </details>
                </div>

                <!-- Verify Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3 rounded-lg transition transform hover:scale-105 active:scale-95"
                >
                    ✓ Verify & Continue
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center">
                <div class="flex-1 border-t border-slate-600"></div>
                <span class="px-3 text-gray-400 text-sm">OR</span>
                <div class="flex-1 border-t border-slate-600"></div>
            </div>

            <!-- Back to Login -->
            <a
                href="/admin/login"
                class="block w-full text-center bg-slate-700/50 hover:bg-slate-700 text-gray-300 font-medium py-3 rounded-lg transition"
            >
                ← Back to Login
            </a>
        </div>

        <!-- Security Notice -->
        <div class="mt-8 text-center text-gray-400 text-xs">
            <p>🔒 Your authentication code is secure and never shared</p>
        </div>
    </div>
</div>
@endsection
