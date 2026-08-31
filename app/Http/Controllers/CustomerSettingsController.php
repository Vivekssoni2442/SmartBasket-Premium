<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

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
        | LOCALES
        |--------------------------------------------------------------------------
        */

        $locales = config('locales', []);

        if (!is_array($locales)) {
            $locales = [];
        }

        /*
        |--------------------------------------------------------------------------
        | CURRENT THEME
        |--------------------------------------------------------------------------
        */

        $theme = $user->dark_mode
            ?? session('customer_theme', 'dark');

        if (!in_array($theme, ['light', 'dark', 'system'], true)) {
            $theme = 'dark';
        }

        /*
        |--------------------------------------------------------------------------
        | CURRENT LANGUAGE
        |--------------------------------------------------------------------------
        */

        $language = $this->resolveConfiguredLocale(
            $user->language
            ?? session('customer_language', 'en'),
            $locales
        );

        /*
        |--------------------------------------------------------------------------
        | Absolute fallback
        |--------------------------------------------------------------------------
        */

        if ($language === null) {
            $language = array_key_exists('en', $locales)
                ? 'en'
                : (array_key_first($locales) ?? 'en');
        }

        /*
        |--------------------------------------------------------------------------
        | CURRENT NOTIFICATION SETTING
        |--------------------------------------------------------------------------
        */

        $notifications = $user->notifications ?? 'enabled';

        if (!in_array($notifications, ['enabled', 'disabled'], true)) {
            $notifications = 'enabled';
        }

        /*
        |--------------------------------------------------------------------------
        | SETTINGS VIEW
        |--------------------------------------------------------------------------
        */

        return view('settings.customer', [
            'user' => $user,
            'theme' => $theme,
            'language' => $language,
            'languages' => $locales,
            'notifications' => $notifications,
        ]);
    }


    /**
     * UPDATE CUSTOMER SETTINGS
     */
    public function update(Request $request)
    {
        abort_unless(Auth::check(), 403);

        /*
        |--------------------------------------------------------------------------
        | LOCALES
        |--------------------------------------------------------------------------
        */

        $locales = config('locales', []);

        if (!is_array($locales)) {
            $locales = [];
        }

        /*
        |--------------------------------------------------------------------------
        | BASIC VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([
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
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | RESOLVE THE LANGUAGE TO A REAL CONFIG LOCALE
        |--------------------------------------------------------------------------
        */

        $language = $this->resolveConfiguredLocale(
            $request->input('language'),
            $locales
        );

        /*
        |--------------------------------------------------------------------------
        | LANGUAGE VALIDATION
        |--------------------------------------------------------------------------
        |
        | The submitted value is accepted when it can be safely matched
        | to one of the configured locales.
        |
        |--------------------------------------------------------------------------
        */

        if (
            $language === null ||
            !array_key_exists($language, $locales)
        ) {
            return back()
                ->withErrors([
                    'language' => 'The selected language is invalid.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | SAVE CUSTOMER SETTINGS
        |--------------------------------------------------------------------------
        */

        $user->dark_mode = $request->input('dark_mode');

        $user->notifications =
            $request->input('notifications');

        $user->language = $language;

        $user->save();

        /*
        |--------------------------------------------------------------------------
        | APPLY SETTINGS TO SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'customer_theme' =>
                $request->input('dark_mode'),

            'customer_language' =>
                $language,

            'customer_notifications' =>
                $request->input('notifications'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | APPLY LANGUAGE IMMEDIATELY
        |--------------------------------------------------------------------------
        */

        App::setLocale($language);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('settings')
            ->with(
                'success',
                __('messages.language_updated')
            );
    }


    /**
     * RESOLVE SUBMITTED LANGUAGE TO CONFIGURED LOCALE
     *
     * Supports:
     *
     * en
     * EN
     * en-US
     * en_US
     * English
     * hindi
     * Hindi
     * hi-IN
     * hi_IN
     *
     * and matches them against the actual keys inside config/locales.php.
     */
    private function resolveConfiguredLocale(
        mixed $locale,
        array $locales
    ): ?string {

        if (
            $locale === null ||
            $locale === ''
        ) {
            return null;
        }

        $value = trim((string) $locale);

        if ($value === '') {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Legacy / language-name mapping
        |--------------------------------------------------------------------------
        */

        $legacy = [

            'english'     => 'en',
            'hindi'       => 'hi',
            'gujarati'    => 'gu',
            'bengali'     => 'bn',
            'marathi'     => 'mr',
            'tamil'       => 'ta',
            'telugu'      => 'te',
            'kannada'     => 'kn',
            'malayalam'   => 'ml',
            'punjabi'     => 'pa',
            'urdu'        => 'ur',

            'arabic'      => 'ar',
            'french'      => 'fr',
            'german'      => 'de',
            'spanish'     => 'es',
            'portuguese'  => 'pt',
            'italian'     => 'it',
            'russian'     => 'ru',
            'japanese'    => 'ja',
            'korean'      => 'ko',
            'chinese'     => 'zh',
            'thai'        => 'th',
            'vietnamese'  => 'vi',
            'indonesian'  => 'id',
            'turkish'     => 'tr',
            'dutch'       => 'nl',
            'polish'      => 'pl',
            'ukrainian'   => 'uk',
            'greek'       => 'el',
            'hebrew'      => 'he',
            'persian'     => 'fa',
            'swedish'     => 'sv',
            'norwegian'   => 'no',
            'danish'      => 'da',
            'finnish'     => 'fi',
            'czech'       => 'cs',
            'slovak'      => 'sk',
            'romanian'    => 'ro',
            'hungarian'   => 'hu',

        ];

        $lower = strtolower($value);

        if (isset($legacy[$lower])) {
            $value = $legacy[$lower];
        }

        /*
        |--------------------------------------------------------------------------
        | Normalize - to _
        |--------------------------------------------------------------------------
        */

        $value = str_replace('-', '_', $value);

        /*
        |--------------------------------------------------------------------------
        | Exact match
        |--------------------------------------------------------------------------
        */

        if (array_key_exists($value, $locales)) {
            return $value;
        }

        /*
        |--------------------------------------------------------------------------
        | Case-insensitive exact match
        |--------------------------------------------------------------------------
        */

        foreach (array_keys($locales) as $configuredLocale) {

            if (
                strtolower($configuredLocale)
                === strtolower($value)
            ) {
                return $configuredLocale;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Base language match
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | en_US -> en
        | en_GB -> en
        | hi_IN -> hi
        | gu_IN -> gu
        |
        |--------------------------------------------------------------------------
        */

        $base = explode('_', $value)[0];

        if (array_key_exists($base, $locales)) {
            return $base;
        }

        /*
        |--------------------------------------------------------------------------
        | Case-insensitive base-language match
        |--------------------------------------------------------------------------
        */

        foreach (array_keys($locales) as $configuredLocale) {

            $normalizedConfigured =
                str_replace(
                    '-',
                    '_',
                    $configuredLocale
                );

            $configuredBase =
                explode(
                    '_',
                    $normalizedConfigured
                )[0];

            if (
                strtolower($configuredBase)
                === strtolower($base)
            ) {
                return $configuredLocale;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Not found
        |--------------------------------------------------------------------------
        */

        return null;
    }
}

