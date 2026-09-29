<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show customer profile page.
     */
    public function index()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        return view('profile', compact('user'));
    }

    /**
     * Update customer profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        /*
        |--------------------------------------------------------------------------
        | LANGUAGE CONFIGURATION
        |--------------------------------------------------------------------------
        |
        | Store language KEY in database:
        |
        | en = English
        | hi = Hindi
        | gu = Gujarati
        |
        */

        $configuredLocales = config('locales', []);

        if (is_array($configuredLocales) && count($configuredLocales) > 0) {
            $allowedLanguages = array_keys($configuredLocales);
        } else {
            $allowedLanguages = [
                'en',
                'hi',
                'gu',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | PASSWORD INPUT
        |--------------------------------------------------------------------------
        |
        | Important fix:
        |
        | Password is completely optional.
        |
        | If customer edits only name/email/phone/address/etc.
        | and leaves password empty, password validation is skipped.
        |
        | If customer enters a new password, Laravel will require:
        |
        | password_confirmation
        |
        | and it must match.
        |
        */

        $passwordRules = [
            'nullable',
            'string',
            'min:8',
            'confirmed',
        ];

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | BASIC INFORMATION
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'username')
                    ->ignore($user->id),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],

            'gender' => [
                'nullable',
                'string',
                'max:20',
            ],

            /*
            |--------------------------------------------------------------------------
            | ADDRESS
            |--------------------------------------------------------------------------
            */

            'address' => [
                'nullable',
                'string',
                'max:500',
            ],

            'house_no' => [
                'nullable',
                'string',
                'max:255',
            ],

            'street' => [
                'nullable',
                'string',
                'max:255',
            ],

            'area' => [
                'nullable',
                'string',
                'max:255',
            ],

            'landmark' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:255',
            ],

            'state' => [
                'nullable',
                'string',
                'max:255',
            ],

            'country' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pin_code' => [
                'nullable',
                'string',
                'max:20',
            ],

            /*
            |--------------------------------------------------------------------------
            | LANGUAGE
            |--------------------------------------------------------------------------
            */

            'language' => [
                'nullable',
                'string',
                Rule::in($allowedLanguages),
            ],

            /*
            |--------------------------------------------------------------------------
            | THEME
            |--------------------------------------------------------------------------
            */

            'dark_mode' => [
                'nullable',
                'string',
                Rule::in([
                    'light',
                    'dark',
                    'system',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | NOTIFICATIONS
            |--------------------------------------------------------------------------
            */

            'notifications' => [
                'nullable',
                'string',
                Rule::in([
                    'enabled',
                    'disabled',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | PASSWORD
            |--------------------------------------------------------------------------
            |
            | FIX:
            | nullable + confirmed
            |
            | Empty password:
            |     No password change.
            |
            | Password entered:
            |     Confirmation must match.
            |
            */

            'password' => $passwordRules,

            /*
            |--------------------------------------------------------------------------
            | PROFILE IMAGE
            |--------------------------------------------------------------------------
            */

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | BASIC INFORMATION UPDATE
        |--------------------------------------------------------------------------
        */

        $user->name = $validated['name'];

        $user->username =
            array_key_exists('username', $validated)
                ? $validated['username']
                : $user->username;

        $user->email = $validated['email'];

        $user->phone =
            array_key_exists('phone', $validated)
                ? $validated['phone']
                : $user->phone;

        $user->date_of_birth =
            array_key_exists('date_of_birth', $validated)
                ? $validated['date_of_birth']
                : $user->date_of_birth;

        $user->gender =
            array_key_exists('gender', $validated)
                ? $validated['gender']
                : $user->gender;

        /*
        |--------------------------------------------------------------------------
        | ADDRESS UPDATE
        |--------------------------------------------------------------------------
        */

        $user->address =
            array_key_exists('address', $validated)
                ? $validated['address']
                : $user->address;

        $user->house_no =
            array_key_exists('house_no', $validated)
                ? $validated['house_no']
                : $user->house_no;

        $user->street =
            array_key_exists('street', $validated)
                ? $validated['street']
                : $user->street;

        $user->area =
            array_key_exists('area', $validated)
                ? $validated['area']
                : $user->area;

        $user->landmark =
            array_key_exists('landmark', $validated)
                ? $validated['landmark']
                : $user->landmark;

        $user->city =
            array_key_exists('city', $validated)
                ? $validated['city']
                : $user->city;

        $user->state =
            array_key_exists('state', $validated)
                ? $validated['state']
                : $user->state;

        $user->country =
            array_key_exists('country', $validated)
                ? $validated['country']
                : $user->country;

        $user->pin_code =
            array_key_exists('pin_code', $validated)
                ? $validated['pin_code']
                : $user->pin_code;

        /*
        |--------------------------------------------------------------------------
        | LANGUAGE UPDATE
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists('language', $validated)
            && filled($validated['language'])
        ) {
            $user->language = $validated['language'];

            session([
                'customer_language' => $validated['language'],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | THEME UPDATE
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists('dark_mode', $validated)
            && filled($validated['dark_mode'])
        ) {
            $user->dark_mode = $validated['dark_mode'];
        } elseif (! $user->dark_mode) {
            $user->dark_mode = 'light';
        }

        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION UPDATE
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists('notifications', $validated)
            && filled($validated['notifications'])
        ) {
            $user->notifications = $validated['notifications'];
        } elseif (! $user->notifications) {
            $user->notifications = 'enabled';
        }

        /*
        |--------------------------------------------------------------------------
        | PASSWORD UPDATE
        |--------------------------------------------------------------------------
        |
        | Only update password if customer actually entered one.
        |
        | This prevents accidental password changes when editing
        | normal profile information.
        |
        */

        if (
            array_key_exists('password', $validated)
            && filled($validated['password'])
        ) {
            $user->password = Hash::make(
                $validated['password']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PROFILE IMAGE UPDATE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_image')) {

            $image = $request->file('profile_image');

            /*
            |--------------------------------------------------------------------------
            | Delete old image
            |--------------------------------------------------------------------------
            */

            if (
                ! empty($user->profile_image)
            ) {
                Storage::disk('public')->delete(
                    'profile/' . $user->profile_image
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Generate safe unique filename
            |--------------------------------------------------------------------------
            */

            $originalName = pathinfo(
                $image->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $extension = strtolower(
                $image->getClientOriginalExtension()
            );

            $safeName = Str::slug($originalName);

            if ($safeName === '') {
                $safeName = 'profile';
            }

            $fileName =
                time()
                . '_'
                . Str::random(8)
                . '_'
                . $safeName
                . '.'
                . $extension;

            /*
            |--------------------------------------------------------------------------
            | Store image
            |--------------------------------------------------------------------------
            */

            $image->storeAs(
                'profile',
                $fileName,
                'public'
            );

            $user->profile_image = $fileName;
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE USER
        |--------------------------------------------------------------------------
        */

        $user->save();

        /*
        |--------------------------------------------------------------------------
        | SUCCESS MESSAGE
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Profile updated successfully.'
        );
    }

    /**
     * Logout customer.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        /*
        |--------------------------------------------------------------------------
        | Invalidate current session
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();

        /*
        |--------------------------------------------------------------------------
        | Regenerate CSRF token
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerateToken();

        /*
        |--------------------------------------------------------------------------
        | Forget remember-me cookie
        |--------------------------------------------------------------------------
        */

        Cookie::queue(
            Cookie::forget(
                'remember_web_' .
                sha1('Illuminate\Auth\AuthGuard')
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect('/login')->with(
            'success',
            'You have been logged out successfully.'
        );
    }
}