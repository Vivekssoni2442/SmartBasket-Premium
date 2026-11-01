<?php

namespace App\Providers;

use App\Contracts\PaymentGatewayInterface;
use App\Services\RazorpayPaymentGateway;
use App\Models\SellerProfile;
use App\Passkeys\SellerPlatformPasskeyOptions;
use App\Http\Responses\SellerFaceUnlockResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Laravel\Passkeys\Contracts\PasskeyLoginResponse;
use Laravel\Passkeys\Passkeys;
use Laravel\Passkeys\Actions\GenerateRegistrationOptions;

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
        Passkeys::useUserModel(SellerProfile::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(PasskeyLoginResponse::class, SellerFaceUnlockResponse::class);
        $this->app->bind(GenerateRegistrationOptions::class, SellerPlatformPasskeyOptions::class);
        Passkeys::authorizeLoginUsing(static function (Request $request, $user): bool {
            return $user instanceof SellerProfile
                && (int) $request->session()->get('seller_face_pending_id', 0) === (int) $user->getKey()
                && $user->face_unlock_enabled
                && ! $user->isBlocked()
                && ! $user->trashed();
        });
    }
}
