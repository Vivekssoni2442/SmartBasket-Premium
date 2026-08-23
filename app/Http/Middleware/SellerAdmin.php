<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request; use Symfony\Component\HttpFoundation\Response;
class SellerAdmin { public function handle(Request $request, Closure $next): Response { $emails = array_filter(array_map(static fn (string $email): string => strtolower(trim($email)), explode(',', (string) config('services.seller_verification.admin_emails')))); abort_unless(auth()->check() && in_array(strtolower((string) auth()->user()->email), $emails, true), 403); return $next($request); } }
