<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SecuritySetting;


class SecurityController extends Controller
{


public function savePin(Request $request)
{

    $request->validate([
    'pin' => 'required|digits_between:4,6|confirmed',
]);


    $user = Auth::user();


    SecuritySetting::updateOrCreate(

        [
            'user_id' => $user->id
        ],

        [
            'email' => $user->email,

            'pin_hash' => Hash::make($request->pin),

            'security_enabled' => true,

            'last_security_status' => 'Safe',

            'failed_attempt_count' => 0

        ]

    );


    return back()->with(
        'security_success',
        'Security PIN Setup Successfully'
    );

}


public function verifyPin(Request $request)
{

$request->validate([
    'pin'=>'required'
]);


$userId=session('pin_user_id');


$user=\App\Models\User::find($userId);



if(!$user)
{
return redirect('/login');
}



$security=$user->securitySetting;



if(Hash::check($request->pin,$security->pin_hash))
{


Auth::login($user);



session()->forget('pin_user_id');


return redirect('/products')
->with('success','Welcome Back 🎉');


}



return back()->with(
'error',
'Wrong Security PIN'
);


}
public function disable()
{

    $user = Auth::user();


    if($user && $user->securitySetting)
    {

        $user->securitySetting->update([

            'security_enabled'=>false

        ]);

    }


    return back()->with(
        'security_success',
        'Security PIN Disabled'
    );

}

}