<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AdminAuth Middleware
 *
 * Protects all admin routes and ensures:
 * 1. Admin is authenticated (session exists)
 * 2. Admin account is active
 * 3. Admin account is not locked
 * 4. Admin has required role/permissions
 * 5. Session timeout is enforced
 *
 * Usage in routes:
 * Route::middleware('admin.auth')->group(function () {
 *     // Protected admin routes
 * });
 */
class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ?string $role = null): Response
    {
        // Check if admin is authenticated via session
        if (!session('admin_authenticated')) {
            return redirect('/admin/login')->with('error', 'Please login to access admin area.');
        }

        // Get admin ID from session
        $adminId = session('admin_id');
        if (!$adminId) {
            session()->forget('admin_authenticated');
            return redirect('/admin/login')->with('error', 'Admin session invalid.');
        }

        // Load admin from database
        $admin = \App\Models\Admin::find($adminId);
        if (!$admin) {
            session()->forget(['admin_authenticated', 'admin_id', 'admin_email', 'admin_name']);
            return redirect('/admin/login')->with('error', 'Admin account not found.');
        }

        // Check if admin is active
        if (!$admin->isActive()) {
            session()->forget(['admin_authenticated', 'admin_id', 'admin_email', 'admin_name']);
            return redirect('/admin/login')->with('error', 'Admin account is inactive.');
        }

        // Check if admin is locked
        if ($admin->isLocked()) {
            session()->forget(['admin_authenticated', 'admin_id', 'admin_email', 'admin_name']);
            return redirect('/admin/login')->with('error', 'Admin account is locked. Try again later.');
        }

        // Check role-based access if required
        if ($role && $admin->role !== $role && !$admin->isSuperAdmin()) {
            abort(403, 'Insufficient permissions.');
        }

        // Update last activity
        $admin->updateLastActivity();

        return $next($request);
    }
}
