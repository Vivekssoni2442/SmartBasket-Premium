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
    public function index()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        /*
        |--------------------------------------------------------------------------
        | LANGUAGE FIX
        |--------------------------------------------------------------------------
        | The database should store the locale KEY, not the display name.
        | Example:
        | en => English
        | hi => Hindi
        |
        | If config/locales.php does not exist or is empty, the fallback
        | values below prevent "selected language is invalid".
        |--------------------------------------------------------------------------
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
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
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
             * IMPORTANT:
             * Do NOT validate against "English", "Hindi", "Other".
             * Validate actual locale keys.
             */
            'language' => [
                'nullable',
                'string',
                Rule::in($allowedLanguages),
            ],

            'dark_mode' => [
                'nullable',
                Rule::in([
                    'light',
                    'dark',
                    'system',
                ]),
            ],

            'notifications' => [
                'nullable',
                Rule::in([
                    'enabled',
                    'disabled',
                ]),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | BASIC INFORMATION
        |--------------------------------------------------------------------------
        */

        $user->name = $validated['name'];
        $user->username = $validated['username'] ?? null;
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->date_of_birth = $validated['date_of_birth'] ?? null;
        $user->gender = $validated['gender'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | ADDRESS
        |--------------------------------------------------------------------------
        */

        $user->address = $validated['address'] ?? null;
        $user->house_no = $validated['house_no'] ?? null;
        $user->street = $validated['street'] ?? null;
        $user->area = $validated['area'] ?? null;
        $user->landmark = $validated['landmark'] ?? null;
        $user->city = $validated['city'] ?? null;
        $user->state = $validated['state'] ?? null;
        $user->country = $validated['country'] ?? null;
        $user->pin_code = $validated['pin_code'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | LANGUAGE
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists('language', $validated) &&
            filled($validated['language'])
        ) {
            $user->language = $validated['language'];

            session([
                'customer_language' => $validated['language'],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | THEME
        |--------------------------------------------------------------------------
        */

        $user->dark_mode =
            $validated['dark_mode']
            ?? ($user->dark_mode ?: 'light');

        /*
        |--------------------------------------------------------------------------
        | NOTIFICATIONS
        |--------------------------------------------------------------------------
        */

        $user->notifications =
            $validated['notifications']
            ?? ($user->notifications ?: 'enabled');

        /*
        |--------------------------------------------------------------------------
        | PASSWORD
        |--------------------------------------------------------------------------
        */

        if ($request->filled('password')) {
            $user->password = Hash::make(
                $request->password
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PROFILE IMAGE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_image')) {

            /*
             * Delete old profile image if it exists.
             */
            if ($user->profile_image) {
                Storage::disk('public')->delete(
                    'profile/' . $user->profile_image
                );
            }

            $image = $request->file('profile_image');

            $fileName =
                time()
                . '_'
                . Str::slug(
                    pathinfo(
                        $image->getClientOriginalName(),
                        PATHINFO_FILENAME
                    )
                )
                . '.'
                . $image->getClientOriginalExtension();

            $image->storeAs(
                'profile',
                $fileName,
                'public'
            );

            $user->profile_image = $fileName;
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        $user->save();

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Profile updated successfully.'
        );
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Cookie::queue(
            Cookie::forget(
                'remember_web_' .
                sha1('Illuminate\Auth\AuthGuard')
            )
        );

        return redirect('/login')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }
}