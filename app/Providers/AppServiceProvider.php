<?php

namespace App\Providers;

use App\Contracts\PaymentGatewayInterface;
use App\Services\RazorpayPaymentGateway;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Controllers may keep their concrete dependency while new payment
        // services depend on this gateway contract for future providers.
        $this->app->bind(PaymentGatewayInterface::class, RazorpayPaymentGateway::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
