<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',       // AI Camera Shopping Assistant API (additive)
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Resolve the authenticated customer preference (or a safe guest fallback)
        // before any controller or Blade view is executed.
        $middleware->appendToGroup('web', \App\Http\Middleware\SetUserLocale::class);

        // Register seller auth and admin middleware aliases
        $middleware->alias([
            'seller.auth' => \App\Http\Middleware\SellerAuth::class,
            'seller.admin' => \App\Http\Middleware\SellerAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
