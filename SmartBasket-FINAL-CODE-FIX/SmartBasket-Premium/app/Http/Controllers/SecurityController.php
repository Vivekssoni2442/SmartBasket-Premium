<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SecuritySetting;

class SecurityController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CREATE / UPDATE SECURITY PIN
    |--------------------------------------------------------------------------
    */

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
                'failed_attempt_count' => 0,
                'last_attempt_time' => now(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | AJAX / POPUP RESPONSE
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            session([
                'security_pin_verified' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Security PIN created successfully.'
            ]);
        }

        return back()->with(
            'security_success',
            'Security PIN Setup Successfully'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN SECURITY PIN
    |--------------------------------------------------------------------------
    */

    public function verifyPin(Request $request)
    {
        $request->validate([
            'pin' => 'required'
        ]);

        $userId = session('pin_user_id');

        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect('/login');
        }

        $security = $user->securitySetting;

        if (
            $security &&
            $security->pin_hash &&
            Hash::check($request->pin, $security->pin_hash)
        ) {

            Auth::login($user);

            /*
            |--------------------------------------------------------------------------
            | CUSTOMER LOGIN WELCOME ANIMATION
            |--------------------------------------------------------------------------
            */

            session()->flash(
                'customer_login_welcome',
                true
            );

            session()->forget('pin_user_id');

            /*
            |--------------------------------------------------------------------------
            | SECURITY SESSION
            |--------------------------------------------------------------------------
            */

            session([
                'security_pin_verified' => true
            ]);

            return redirect('/products')
                ->with(
                    'success',
                    'Welcome Back 🎉'
                );
        }

        return back()->with(
            'error',
            'Wrong Security PIN'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCTS PAGE SECURITY PIN
    |--------------------------------------------------------------------------
    */

    public function verifyCustomerPin(Request $request)
    {
        $request->validate([
            'pin' => [
                'required',
                'digits_between:4,6'
            ]
        ]);

        $user = Auth::user();

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Please login again.'
            ], 401);
        }

        $security = $user->securitySetting;

        if (!$security || !$security->pin_hash) {

            return response()->json([
                'success' => false,
                'message' => 'Security PIN is not configured.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CORRECT PIN
        |--------------------------------------------------------------------------
        */

        if (Hash::check($request->pin, $security->pin_hash)) {

            $security->update([
                'failed_attempt_count' => 0,
                'last_attempt_time' => now(),
                'last_security_status' => 'Safe'
            ]);

            session([
                'security_pin_verified' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Security PIN verified successfully.'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | WRONG PIN
        |--------------------------------------------------------------------------
        */

        $failedAttempts =
            ((int) $security->failed_attempt_count) + 1;

        $security->update([
            'failed_attempt_count' => $failedAttempts,
            'last_attempt_time' => now(),
            'last_security_status' => 'Warning'
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Wrong Security PIN.'
        ], 422);
    }


    /*
    |--------------------------------------------------------------------------
    | SECURITY PIN MANAGE PAGE
    |--------------------------------------------------------------------------
    |
    | Customer Settings
    |      ↓
    | Security Center
    |      ↓
    | Manage
    |      ↓
    | Security PIN Manage Page
    |
    */

    public function managePin()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $security = $user->securitySetting;

        /*
        |--------------------------------------------------------------------------
        | NO SECURITY PIN CONFIGURED
        |--------------------------------------------------------------------------
        */

        if (!$security || !$security->pin_hash) {

            return redirect()
                ->route('security.setup.page')
                ->with(
                    'error',
                    'Security PIN is not configured. Please set your Security PIN first.'
                );
        }

        return view('security.manage', [
            'user' => $user,
            'security' => $security,
            'verified' => session('security_manage_verified', false),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFY CURRENT PIN FOR MANAGE PAGE
    |--------------------------------------------------------------------------
    |
    | Existing PIN ko verify kiye bina new PIN change nahi hoga.
    |
    */

    public function verifyManagePin(Request $request)
    {
        $request->validate([
            'pin' => [
                'required',
                'digits_between:4,6'
            ],
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $security = $user->securitySetting;

        if (!$security || !$security->pin_hash) {

            return redirect()
                ->route('security.setup.page')
                ->with(
                    'error',
                    'Security PIN is not configured.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK CURRENT PIN
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($request->pin, $security->pin_hash)) {

            $failedAttempts =
                ((int) $security->failed_attempt_count) + 1;

            $security->update([
                'failed_attempt_count' => $failedAttempts,
                'last_attempt_time' => now(),
                'last_security_status' => 'Warning'
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Wrong Security PIN.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CURRENT PIN CORRECT
        |--------------------------------------------------------------------------
        */

        $security->update([
            'failed_attempt_count' => 0,
            'last_attempt_time' => now(),
            'last_security_status' => 'Safe'
        ]);

        session([
            'security_manage_verified' => true
        ]);

        return view('security.manage', [
            'user' => $user,
            'security' => $security,
            'verified' => true,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE / CHANGE SECURITY PIN
    |--------------------------------------------------------------------------
    |
    | Current PIN verify hone ke baad hi new PIN save hoga.
    |
    */

    public function updateManagedPin(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | SECURITY CHECK
        |--------------------------------------------------------------------------
        */

        if (!session('security_manage_verified')) {

            return redirect()
                ->route('security.manage.page')
                ->with(
                    'error',
                    'Please verify your current Security PIN first.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATE NEW PIN
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'pin' => [
                'required',
                'digits_between:4,6',
                'confirmed'
            ],
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $security = $user->securitySetting;

        if (!$security) {

            return redirect()
                ->route('security.setup.page')
                ->with(
                    'error',
                    'Security PIN is not configured.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE NEW PIN
        |--------------------------------------------------------------------------
        */

        $security->update([
            'email' => $user->email,
            'pin_hash' => Hash::make($request->pin),
            'security_enabled' => true,
            'last_security_status' => 'Safe',
            'failed_attempt_count' => 0,
            'last_attempt_time' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | SECURITY SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'security_pin_verified' => true
        ]);

        session()->forget(
            'security_manage_verified'
        );

        /*
        |--------------------------------------------------------------------------
        | BACK TO CUSTOMER SETTINGS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('settings')
            ->with(
                'success',
                'Security PIN updated successfully 🎉'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DISABLE SECURITY PIN
    |--------------------------------------------------------------------------
    */

    public function disable()
    {
        $user = Auth::user();

        if (
            $user &&
            $user->securitySetting
        ) {

            $user->securitySetting->update([
                'security_enabled' => false
            ]);

            /*
            |--------------------------------------------------------------------------
            | PIN DISABLED = PAGE VERIFIED
            |--------------------------------------------------------------------------
            */

            session([
                'security_pin_verified' => true
            ]);
        }

        return back()->with(
            'security_success',
            'Security PIN Disabled'
        );
    }
}