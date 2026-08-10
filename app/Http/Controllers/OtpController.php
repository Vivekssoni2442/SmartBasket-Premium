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
                'email'
            ]
        ]);


        $otp = random_int(100000, 999999);


        session([
            'reset_email' => $request->email,
            'reset_otp' => $otp,
            'otp_time' => now()
        ]);


        Mail::raw(
            "Hello,\n\nYour Smart Basket password recovery OTP is: ".$otp."\n\nThis OTP is valid for 5 minutes.\n\nThank you.",
            function ($message) use ($request) {

                $message->to($request->email)
                        ->subject(' Smart Basket - Password Recovery OTP');

            }
        );

return redirect('/verify-otp')
    ->with('success', 'OTP sent successfully to your email');
       
    }
}
