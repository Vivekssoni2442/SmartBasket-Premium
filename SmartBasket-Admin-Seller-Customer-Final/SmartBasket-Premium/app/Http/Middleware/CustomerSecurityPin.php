<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerSecurityPin
{
    public function handle(Request $request, Closure $next): Response
    {
        /*
        |--------------------------------------------------------------------------
        | Guest users
        |--------------------------------------------------------------------------
        */

        if (!Auth::check()) {
            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | SECURITY / AUTH ROUTES
        |--------------------------------------------------------------------------
        |
        | These routes must always be accessible without Security PIN
        | verification, otherwise PIN setup/verification can create
        | a redirect loop.
        |
        */

        if (
            $request->routeIs('login') ||
            $request->routeIs('login.submit') ||
            $request->routeIs('register') ||
            $request->routeIs('register.submit') ||

            // Login Security PIN
            $request->routeIs('security.verify') ||
            $request->routeIs('security.verify.page') ||

            // Security PIN create/update
            $request->routeIs('security.save') ||

            // Customer popup PIN verification
            $request->routeIs('security.customer.verify') ||

            // Security PIN disable
            $request->routeIs('security.disable') ||

            // Customer logout
            $request->routeIs('logout')
        ) {
            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | CURRENT USER
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | SECURITY SETTING
        |--------------------------------------------------------------------------
        */

        $security = $user->securitySetting;


        /*
        |--------------------------------------------------------------------------
        | NO SECURITY PIN CREATED
        |--------------------------------------------------------------------------
        |
        | Products page is allowed to load because the Products page
        | itself will display the "Create Security PIN" blocking popup.
        |
        | We do NOT redirect to security.setup.page because that route
        | does not exist in the current routes/web.php.
        |
        */

        if (!$security) {

            if ($request->routeIs('products.index')) {
                return $next($request);
            }

            /*
            |--------------------------------------------------------------------------
            | If the customer has not created a PIN yet, allow the request.
            | The Products page popup will ask the customer to create one.
            |--------------------------------------------------------------------------
            */

            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | SECURITY PIN DISABLED
        |--------------------------------------------------------------------------
        */

        if (!$security->security_enabled) {

            session([
                'security_pin_verified' => true
            ]);

            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | SECURITY PIN ALREADY VERIFIED
        |--------------------------------------------------------------------------
        */

        if (
            session('security_pin_verified') === true
        ) {
            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | PRODUCTS PAGE
        |--------------------------------------------------------------------------
        |
        | Products page contains the blocking Security PIN popup.
        |
        | If the PIN exists but has not been verified in this session,
        | allow Products page to load so the popup can appear.
        |
        */

        if ($request->routeIs('products.index')) {
            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | ALL OTHER CUSTOMER PAGES
        |--------------------------------------------------------------------------
        |
        | Customer must verify the Security PIN before accessing
        | protected customer pages.
        |
        */

        return redirect()
            ->guest(
                route('security.verify.page')
            );
    }
}