<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
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
        $middleware->appendToGroup('web', \App\Http\Middleware\RejectBlockedCustomer::class);

        // Register seller auth and admin middleware aliases
        $middleware->alias([
            'seller.auth' => \App\Http\Middleware\SellerAuth::class,
            'seller.admin' => \App\Http\Middleware\SellerAdmin::class,
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function (PostTooLargeException $exception, Request $request) {
            if (! $request->is('seller-product-store', 'seller-product-update/*')) {
                return null;
            }

            $requestId = (string) \Illuminate\Support\Str::uuid();
            \Illuminate\Support\Facades\Log::warning('Seller product request exceeded PHP post_max_size.', [
                'request_id' => $requestId,
                'route' => $request->route()?->getName(),
                'content_length' => (int) $request->server('CONTENT_LENGTH', 0),
                'post_max_size' => ini_get('post_max_size'),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
            ]);

            $message = 'The upload is larger than the server accepts. Reduce the video or total selected files and try again.';

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'errors' => ['upload' => [$message]],
                    'request_id' => $requestId,
                ], 413);
            }

            return redirect()->back()->withInput()->withErrors(['upload' => $message]);
        });
    })->create();
