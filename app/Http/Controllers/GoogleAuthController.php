<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        $clientId = trim((string) config('services.google.client_id'));
        if ($clientId === '') {
            return redirect()->route('register')->with('error', 'Google sign-in is not configured yet. Please use email registration or contact support.');
        }

        $state = Str::random(64);
        $request->session()->put('google_oauth_state', $state);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?'.http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $this->redirectUri(),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
        ], '', '&', PHP_QUERY_RFC3986));
    }

    public function callback(Request $request): RedirectResponse
    {
        $state = (string) $request->session()->pull('google_oauth_state', '');
        if ($state === '' || ! hash_equals($state, (string) $request->query('state', ''))) {
            return redirect()->route('login')->with('error', 'Google sign-in session expired. Please try again.');
        }

        if ($request->filled('error') || ! $request->filled('code')) {
            return redirect()->route('register')->with('error', 'Google sign-in was cancelled. You can try again.');
        }

        $clientId = trim((string) config('services.google.client_id'));
        $clientSecret = trim((string) config('services.google.client_secret'));
        if ($clientId === '' || $clientSecret === '') {
            return redirect()->route('login')->with('error', 'Google sign-in is not configured yet.');
        }

        try {
            $tokenResponse = Http::asForm()->acceptJson()->timeout(15)->post('https://oauth2.googleapis.com/token', [
                'code' => (string) $request->query('code'),
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $this->redirectUri(),
                'grant_type' => 'authorization_code',
            ]);

            if (! $tokenResponse->successful() || ! $token = $tokenResponse->json('access_token')) {
                return redirect()->route('login')->with('error', 'Google sign-in could not be completed. Please try again.');
            }

            $profileResponse = Http::withToken($token)->acceptJson()->timeout(15)->get('https://openidconnect.googleapis.com/v1/userinfo');
            if (! $profileResponse->successful()) {
                return redirect()->route('login')->with('error', 'Google did not return a usable account profile. Please try again.');
            }
        } catch (Throwable $exception) {
            report($exception);
            return redirect()->route('login')->with('error', 'Google sign-in is temporarily unavailable. Please try again.');
        }

        $profile = $profileResponse->json();
        if (! is_array($profile)) {
            return redirect()->route('login')->with('error', 'Google returned an invalid account profile. Please try again.');
        }

        $googleId = trim((string) ($profile['sub'] ?? ''));
        $email = mb_strtolower(trim((string) ($profile['email'] ?? '')));
        $name = trim((string) ($profile['name'] ?? ''));

        if ($googleId === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL) || ($profile['email_verified'] ?? false) !== true) {
            return redirect()->route('login')->with('error', 'Google must provide a verified email address to create or access a customer account.');
        }

        $user = User::withTrashed()->where('google_id', $googleId)->first();
        if (! $user) {
            $user = User::withTrashed()->whereRaw('LOWER(email) = ?', [$email])->first();
        }

        if ($user?->trashed()) {
            return redirect()->route('login')->with('error', 'This customer account is unavailable. Please contact Smart Basket support.');
        }

        if ($user && $user->google_id && ! hash_equals((string) $user->google_id, $googleId)) {
            return redirect()->route('login')->with('error', 'This email is already connected to another Google account. Please use your usual sign-in method.');
        }

        if (! $user) {
            if (! app(SiteSettings::class)->enabled('customer_registration_enabled')) {
                return redirect()->route('login')->with('error', 'New customer registration is currently unavailable.');
            }

            $user = User::create([
                'name' => $name !== '' ? $name : Str::before($email, '@'),
                'email' => $email,
                'google_id' => $googleId,
                'email_verified_at' => now(),
                'password' => Str::random(64),
            ]);
        } elseif (! $user->google_id) {
            $user->forceFill([
                'google_id' => $googleId,
                'email_verified_at' => $user->email_verified_at ?: now(),
            ])->save();
        }

        if ($user->isBlocked()) {
            return redirect()->route('login')->with('error', 'This customer account is blocked. Please contact Smart Basket support for assistance.');
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended(route('products.index'));
    }

    private function redirectUri(): string
    {
        return trim((string) config('services.google.redirect')) ?: route('google.callback');
    }
}
