<?php

$passkeyOrigin = trim((string) env('PASSKEYS_ORIGIN', ''));
$driverUrlFile = storage_path('app/driver-public-url.txt');
$driverUrl = is_file($driverUrlFile) ? trim((string) file_get_contents($driverUrlFile)) : '';
$passkeyBaseUrl = trim((string) env('PASSKEYS_APP_URL', '')) ?: ($driverUrl ?: (string) config('app.url'));
$passkeyRpId = trim((string) env('PASSKEYS_RP_ID', '')) ?: (string) parse_url($passkeyBaseUrl, PHP_URL_HOST);

return [
    'relying_party_id' => $passkeyRpId,
    'allowed_origins' => array_values(array_unique(array_filter([
        $passkeyOrigin !== '' ? $passkeyOrigin : null,
        $passkeyBaseUrl,
        (string) config('app.url'),
    ]))),
    'user_handle_secret' => env('PASSKEYS_USER_HANDLE_SECRET', config('app.key')),
    'timeout' => 60000,
    'guard' => 'seller',
    'middleware' => ['web', App\Http\Middleware\ConfigurePasskeyOrigin::class],
    'management_middleware' => ['seller.auth'],
    'throttle' => 'throttle:6,1',
    'redirect' => '/seller/dashboard',
];
