<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Seller Authentication Middleware
 *
 * Checks if the seller is logged in via session('seller_login').
 * If not, redirects to the seller login page.
 *
 * This middleware protects seller routes (dashboard, products, orders).
 * It does NOT affect customer/user authentication.
 */
class SellerAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('seller_login')) {
            return redirect('/seller-login')->with('error', 'Please login as seller to access this page.');
        }

        return $next($request);
    }
}