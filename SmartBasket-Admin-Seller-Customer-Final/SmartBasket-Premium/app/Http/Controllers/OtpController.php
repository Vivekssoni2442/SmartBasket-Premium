<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            'reset_otp'   => $otp,
            'otp_time'    => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | SEND SMART BASKET PREMIUM EMAIL
        |--------------------------------------------------------------------------
        */

        Mail::send(
            'emails.otp',
            [
                'otp'   => $otp,
                'email' => $request->email,
            ],
            function ($message) use ($request) {

                $message
                    ->to($request->email)
                    ->subject('SMART BASKET - Password Recovery OTP');
            }
        );

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
}