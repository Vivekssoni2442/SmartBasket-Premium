<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Carbon;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
        ]);

        // Do not disclose whether an account exists; this prevents user enumeration.
        $key = 'password-reset:' . $request->ip() . ':' . strtolower($request->email);
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->with('error', 'Please wait before requesting another code.');
        }
        RateLimiter::hit($key, 600);

        if (! User::where('email', $request->email)->exists()) {
            return redirect('/verify-otp')->with('success', 'If that email is registered, a recovery code has been sent.');
        }

        /*
        |--------------------------------------------------------------------------
        | GENERATE 6 DIGIT OTP
        |--------------------------------------------------------------------------
        */

        $otp = random_int(100000, 999999);

        /*
        |--------------------------------------------------------------------------
        | STORE OTP IN SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'reset_email' => $request->email,
            // Never retain a recoverable reset code in the session.
            'reset_otp_hash' => Hash::make((string) $otp),
            'otp_time'    => now(),
            'reset_password_verified' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | SEND SMART BASKET PREMIUM EMAIL
        |--------------------------------------------------------------------------
        */

        try {
            Mail::send('emails.otp', ['otp' => $otp, 'email' => $request->email], function ($message) use ($request) {
                $message->to($request->email)->subject('SMART BASKET - Password Recovery OTP');
            });
        } catch (\Throwable $exception) {
            report($exception);
            return back()->with('error', 'Email delivery is temporarily unavailable. Please try again later.');
        }

        /*
        |--------------------------------------------------------------------------
        | REDIRECT TO OTP VERIFICATION
        |--------------------------------------------------------------------------
        */

        return redirect('/verify-otp')
            ->with(
                'success',
                'OTP sent successfully to your email'
            );
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate(['otp' => ['required', 'digits:6']]);
        $email = session('reset_email');
        $issuedAt = session('otp_time');
        $hash = session('reset_otp_hash');

        if (! $email || ! $issuedAt || ! $hash || now()->greaterThan(Carbon::parse($issuedAt)->addMinutes(15))) {
            session()->forget(['reset_email', 'reset_otp_hash', 'otp_time', 'reset_password_verified']);

            return redirect()->route('password.request')->with('error', 'This recovery code has expired. Please request a new one.');
        }

        $key = 'password-reset-verify:' . $request->ip() . ':' . strtolower((string) $email);
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->with('error', 'Too many invalid attempts. Please request a new code.');
        }

        if (! Hash::check((string) $data['otp'], (string) $hash)) {
            RateLimiter::hit($key, 900);

            return back()->with('error', 'Invalid recovery code.');
        }

        RateLimiter::clear($key);
        session([
            'reset_password_verified' => true,
            'reset_password_verified_at' => now(),
        ]);
        session()->forget(['reset_otp_hash', 'otp_time']);

        return redirect()->route('reset.password')->with('success', 'Recovery code verified. Choose a new password.');
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate(['password' => ['required', 'string', 'min:8', 'confirmed']]);
        $email = session('reset_email');
        $verifiedAt = session('reset_password_verified_at');

        if (! session('reset_password_verified') || ! $email || ! $verifiedAt || now()->greaterThan(Carbon::parse($verifiedAt)->addMinutes(15))) {
            session()->forget(['reset_email', 'reset_password_verified', 'reset_password_verified_at']);

            return redirect()->route('password.request')->with('error', 'Your password reset session has expired. Please start again.');
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            session()->forget(['reset_email', 'reset_password_verified', 'reset_password_verified_at']);

            return redirect()->route('password.request')->with('error', 'Unable to reset the password. Please start again.');
        }

        $user->forceFill(['password' => Hash::make($data['password'])])->save();
        session()->forget(['reset_email', 'reset_password_verified', 'reset_password_verified_at', 'reset_otp_hash', 'otp_time']);

        return redirect()->route('password.success')->with('success', 'Password reset successfully. Please sign in.');
    }
}
