<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetUserLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locales = config('locales', []);

        /*
        |--------------------------------------------------------------------------
        | Safety: make sure locales config is always an array
        |--------------------------------------------------------------------------
        */

        if (!is_array($locales)) {
            $locales = [];
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve current language
        |--------------------------------------------------------------------------
        */

        $locale = $this->resolveLocale($request, $locales);

        /*
        |--------------------------------------------------------------------------
        | Direction
        |--------------------------------------------------------------------------
        */

        $direction = $locales[$locale]['direction'] ?? 'ltr';

        /*
        |--------------------------------------------------------------------------
        | Set Laravel application locale
        |--------------------------------------------------------------------------
        */

        App::setLocale($locale);

        /*
        |--------------------------------------------------------------------------
        | Keep language in session
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'customer_language',
            $locale
        );

        /*
        |--------------------------------------------------------------------------
        | Share locale information with ALL Blade views
        |--------------------------------------------------------------------------
        */

        View::share([
            'supportedLocales' => $locales,
            'currentLocale' => $locale,
            'localeDirection' => $direction,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Continue request
        |--------------------------------------------------------------------------
        */

        $response = $next($request);

        /*
        |--------------------------------------------------------------------------
        | Inject HTML language attributes
        |--------------------------------------------------------------------------
        */

        if (
            $response instanceof Response &&
            str_contains(
                (string) $response->headers->get('Content-Type'),
                'text/html'
            )
        ) {
            $content = $response->getContent();

            if (is_string($content)) {

                /*
                |--------------------------------------------------------------------------
                | Build HTML opening tag
                |--------------------------------------------------------------------------
                */

                $html =
                    '<html lang="' . e($locale) .
                    '" dir="' . e($direction) .
                    '" data-locale="' . e($locale) . '"';


                /*
                |--------------------------------------------------------------------------
                | Replace existing <html> language attributes
                |--------------------------------------------------------------------------
                */

                $content = preg_replace_callback(
                    '/<html\b([^>]*)>/i',
                    static function (array $match) use ($html): string {

                        $attributes = preg_replace(
                            '/\s+(?:lang|dir|data-locale)=("[^"]*"|\'[^\']*\'|[^\s>]+)/i',
                            '',
                            $match[1]
                        );

                        $attributes = $attributes ?? '';

                        return $html . $attributes . '>';
                    },
                    $content,
                    1
                ) ?? $content;


                /*
                |--------------------------------------------------------------------------
                | Add Smart Basket localization CSS
                |--------------------------------------------------------------------------
                */

                if (
                    !str_contains(
                        $content,
                        'smartbasket-localization.css'
                    )
                ) {

                    $localizationCss =
                        '<link rel="stylesheet" href="' .
                        e(asset('css/smartbasket-localization.css')) .
                        '">' .
                        "\n";

                    $content = preg_replace(
                        '/<\/head>/i',
                        $localizationCss . '</head>',
                        $content,
                        1
                    ) ?? $content;
                }


                /*
                |--------------------------------------------------------------------------
                | Update response
                |--------------------------------------------------------------------------
                */

                $response->setContent($content);
            }
        }

        return $response;
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Current Locale
    |--------------------------------------------------------------------------
    */

    private function resolveLocale(
        Request $request,
        array $locales
    ): string {

        /*
        |--------------------------------------------------------------------------
        | Priority
        |
        | 1. Logged-in customer's saved language
        | 2. Session language
        | 3. Browser language
        | 4. English
        |--------------------------------------------------------------------------
        */

        $savedLocale = null;

        /*
        |--------------------------------------------------------------------------
        | Logged-in user language
        |--------------------------------------------------------------------------
        */

        if ($request->user()) {
            $savedLocale = $request->user()->language;
        }


        /*
        |--------------------------------------------------------------------------
        | Session language
        |--------------------------------------------------------------------------
        */

        $sessionLocale =
            $request->session()->get(
                'customer_language'
            );


        /*
        |--------------------------------------------------------------------------
        | Try saved user language first
        |--------------------------------------------------------------------------
        */

        $candidate =
            $this->normaliseLocale(
                $savedLocale,
                $locales
            );

        if (
            $candidate !== null &&
            isset($locales[$candidate])
        ) {
            return $candidate;
        }


        /*
        |--------------------------------------------------------------------------
        | Try session language
        |--------------------------------------------------------------------------
        */

        $candidate =
            $this->normaliseLocale(
                $sessionLocale,
                $locales
            );

        if (
            $candidate !== null &&
            isset($locales[$candidate])
        ) {
            return $candidate;
        }


        /*
        |--------------------------------------------------------------------------
        | Try browser language
        |--------------------------------------------------------------------------
        */

        foreach (
            $request->getLanguages()
            as $browserLocale
        ) {

            $candidate =
                $this->normaliseLocale(
                    $browserLocale,
                    $locales
                );

            if (
                $candidate !== null &&
                isset($locales[$candidate])
            ) {
                return $candidate;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | English fallback
        |--------------------------------------------------------------------------
        */

        if (isset($locales['en'])) {
            return 'en';
        }


        /*
        |--------------------------------------------------------------------------
        | First available configured language
        |--------------------------------------------------------------------------
        */

        $firstLocale = array_key_first($locales);

        if ($firstLocale !== null) {
            return $firstLocale;
        }


        /*
        |--------------------------------------------------------------------------
        | Absolute fallback
        |--------------------------------------------------------------------------
        */

        return 'en';
    }


    /*
    |--------------------------------------------------------------------------
    | Normalize Locale
    |--------------------------------------------------------------------------
    |
    | Handles:
    |
    | en
    | EN
    | en-US
    | en_US
    | English
    | Hindi
    | Gujarati
    |
    | And also checks configured locale keys so that the actual
    | 50+ language configuration remains untouched.
    |--------------------------------------------------------------------------
    */

    private function normaliseLocale(
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
        | Legacy language names
        |--------------------------------------------------------------------------
        */

        $legacy = [
            'english' => 'en',
            'hindi' => 'hi',
            'gujarati' => 'gu',
            'bengali' => 'bn',
            'marathi' => 'mr',
            'tamil' => 'ta',
            'telugu' => 'te',
            'kannada' => 'kn',
            'malayalam' => 'ml',
            'punjabi' => 'pa',
            'urdu' => 'ur',
            'arabic' => 'ar',
            'french' => 'fr',
            'german' => 'de',
            'spanish' => 'es',
            'portuguese' => 'pt',
            'italian' => 'it',
            'russian' => 'ru',
            'japanese' => 'ja',
            'korean' => 'ko',
            'chinese' => 'zh',
            'thai' => 'th',
            'vietnamese' => 'vi',
            'indonesian' => 'id',
            'turkish' => 'tr',
            'dutch' => 'nl',
            'polish' => 'pl',
            'ukrainian' => 'uk',
            'greek' => 'el',
            'hebrew' => 'he',
            'persian' => 'fa',
            'swedish' => 'sv',
            'norwegian' => 'no',
            'danish' => 'da',
            'finnish' => 'fi',
            'czech' => 'cs',
            'slovak' => 'sk',
            'romanian' => 'ro',
            'hungarian' => 'hu',
        ];


        $lower =
            strtolower($value);


        if (isset($legacy[$lower])) {
            $value = $legacy[$lower];
        }


        /*
        |--------------------------------------------------------------------------
        | Normalize separator
        |--------------------------------------------------------------------------
        */

        $value =
            str_replace(
                '-',
                '_',
                $value
            );


        /*
        |--------------------------------------------------------------------------
        | Exact configured locale
        |--------------------------------------------------------------------------
        */

        if (isset($locales[$value])) {
            return $value;
        }


        /*
        |--------------------------------------------------------------------------
        | Case-insensitive configured locale
        |--------------------------------------------------------------------------
        */

        foreach (
            array_keys($locales)
            as $configuredLocale
        ) {

            if (
                strtolower($configuredLocale)
                === strtolower($value)
            ) {
                return $configuredLocale;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Match base language
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | en_US -> en
        | hi_IN -> hi
        | pt_BR -> pt
        |
        |--------------------------------------------------------------------------
        */

        $base =
            explode(
                '_',
                $value
            )[0];


        if (isset($locales[$base])) {
            return $base;
        }


        /*
        |--------------------------------------------------------------------------
        | Case-insensitive base language match
        |--------------------------------------------------------------------------
        */

        foreach (
            array_keys($locales)
            as $configuredLocale
        ) {

            $configuredBase =
                explode(
                    '_',
                    str_replace(
                        '-',
                        '_',
                        $configuredLocale
                    )
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
        | Invalid language
        |--------------------------------------------------------------------------
        */

        return null;
    }
}