<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Private access from phones on different networks

To keep Smart Basket off the public internet while opening it from mobile data or another Wi-Fi network, install Tailscale on the server PC and each phone, then sign every device into the same Tailscale account. In the Tailscale admin DNS settings, enable MagicDNS and HTTPS certificates. On the PC, run `start-private-network.bat`; use the printed `https://...ts.net` address on signed-in phones. The server PC, Laravel process, and Tailscale must stay online. Driver links copied from **Seller → Delivery partners** use that private address.

The private URL is reachable only from the same Tailscale network. A phone without Tailscale access cannot open the site. If public access is preferred, use a separately configured public HTTPS host.

## Google customer sign-in

Create a Google OAuth client with application type **Web application**. Add the exact callback URL `https://YOUR-HOST/auth/google/callback` (or the exact localhost URL used for local development) under **Authorized redirect URIs**. Set `GOOGLE_OAUTH_CLIENT_ID`, `GOOGLE_OAUTH_CLIENT_SECRET`, and `GOOGLE_OAUTH_REDIRECT_URI` in the server `.env`; the redirect URI must exactly match the Google Cloud value. Then run `php artisan migrate` to add the customer Google ID column and restart/clear Laravel's cached configuration if enabled. Google sign-in only requests `openid`, `email`, and `profile`.

## Seller device face unlock

Seller **Profile > Face unlock for seller login** registers a platform passkey. Login first checks the seller password, then asks the device to verify the user before granting the seller session. The device may use face recognition, fingerprint, or its screen-lock PIN depending on its OS/browser; the site never receives a face scan. WebAuthn requires HTTPS (or localhost), and passkeys are bound to the host used at registration. Use the stable Tailscale HTTPS hostname rather than a rotating quick-tunnel hostname. The two seller-passkey migrations are included in `php artisan migrate`.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
