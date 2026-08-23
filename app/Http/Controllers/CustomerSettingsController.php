<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerSettingsController extends Controller
{
    /**
     * CUSTOMER SETTINGS PAGE
     */
    public function edit()
    {
        abort_unless(Auth::check(), 403);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | CURRENT THEME
        |--------------------------------------------------------------------------
        |
        | Database value first.
        | If database value is empty, use session value.
        | Finally default to dark.
        |
        */

        $theme = $user->dark_mode
            ?? session('customer_theme', 'dark');

        if (! in_array($theme, ['light', 'dark', 'system'], true)) {
            $theme = 'dark';
        }

        /*
        |--------------------------------------------------------------------------
        | CURRENT LANGUAGE
        |--------------------------------------------------------------------------
        */

        $language = $user->language
            ?? session('customer_language', 'english');

        if (! in_array($language, ['english', 'hindi', 'gujarati'], true)) {
            $language = 'english';
        }

        /*
        |--------------------------------------------------------------------------
        | CURRENT NOTIFICATION SETTING
        |--------------------------------------------------------------------------
        */

        $notifications = $user->notifications ?? 'enabled';

        if (! in_array($notifications, ['enabled', 'disabled'], true)) {
            $notifications = 'enabled';
        }

        return view('settings.customer', compact(
            'user',
            'theme',
            'language',
            'notifications'
        ));
    }


    /**
     * UPDATE CUSTOMER SETTINGS
     */
    public function update(Request $request)
    {
        abort_unless(Auth::check(), 403);

        /*
        |--------------------------------------------------------------------------
        | VALIDATE SETTINGS
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([
            'dark_mode' => [
                'required',
                'in:light,dark,system',
            ],

            'notifications' => [
                'required',
                'in:enabled,disabled',
            ],

            'language' => [
                'required',
                'in:english,hindi,gujarati',
            ],
        ]);


        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | SAVE CUSTOMER SETTINGS
        |--------------------------------------------------------------------------
        */

        $user->dark_mode = $data['dark_mode'];
        $user->notifications = $data['notifications'];
        $user->language = $data['language'];

        $user->save();


        /*
        |--------------------------------------------------------------------------
        | APPLY SETTINGS IMMEDIATELY
        |--------------------------------------------------------------------------
        */

        session([
            'customer_theme' => $data['dark_mode'],
            'customer_language' => $data['language'],
            'customer_notifications' => $data['notifications'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('settings')
            ->with(
                'success',
                'Your Smart Basket settings have been updated successfully.'
            );
    }
}