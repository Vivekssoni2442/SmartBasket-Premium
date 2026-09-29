<?php

namespace App\Http\Middleware;

use App\Models\SellerProfile;
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
        if (!session('seller_login') || !session('seller_id')) {
            return redirect('/seller-login')->with('error', 'Please login as seller to access this page.');
        }

        $seller = SellerProfile::find(session('seller_id'));
        if (!$seller) {
            session()->forget(['seller_login', 'seller_email', 'seller_id']);

            return redirect('/seller-login')->with('error', 'Your seller session is no longer valid. Please sign in again.');
        }

        // Verification routes are deliberately available to a signed-in seller
        // so incomplete, pending, and rejected applications can be completed
        // or reviewed. Every other seller route requires administrator approval.
        if ($request->routeIs('seller.verification.*')) {
            return $next($request);
        }

        if ($seller->isApproved() || $seller->isActive()) {
            return $next($request);
        }

        if ($seller->isApplicationSubmitted() || $seller->isRejected() || $seller->isSuspended()) {
            return redirect()->route('seller.verification.status')
                ->with('error', 'Your seller application must be approved before the seller dashboard is available.');
        }

        return redirect()->route('seller.verification.index')
            ->with('info', 'Complete seller verification before accessing seller tools.');
    }
}
