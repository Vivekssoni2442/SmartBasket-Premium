<?php

namespace App\Support;

use App\Models\DeliveryPartner;

class DriverPortalLink
{
    public static function for(DeliveryPartner $partner): string
    {
        $baseUrl = self::activeQuickTunnelUrl();
        $path = route('delivery.driver', $partner->portal_token, false);

        if ($baseUrl) {
            return rtrim($baseUrl, '/') . $path;
        }

        // Never hand a driver a link to the seller's localhost. APP_URL can be
        // a normal hosted domain or the private HTTPS name from Tailscale Serve.
        $configuredUrl = (string) config('app.url');
        $host = parse_url($configuredUrl, PHP_URL_HOST);
        if (parse_url($configuredUrl, PHP_URL_SCHEME) === 'https'
            && is_string($host)
            && ! in_array(strtolower($host), ['localhost', '127.0.0.1', '0.0.0.0', '::1'], true)
            && ! str_ends_with(strtolower($host), '.local')) {
            return rtrim($configuredUrl, '/') . $path;
        }

        return '';
    }

    private static function activeQuickTunnelUrl(): ?string
    {
        $path = storage_path('app/driver-public-url.txt');
        if (! is_file($path) || filemtime($path) < now()->subHours(12)->getTimestamp()) {
            return null;
        }

        $url = trim((string) file_get_contents($path));
        $host = parse_url($url, PHP_URL_HOST);

        if (parse_url($url, PHP_URL_SCHEME) !== 'https' || ! is_string($host)
            || ! preg_match('/^[a-z0-9-]+\.(?:trycloudflare\.com|ts\.net)$/i', $host)) {
            return null;
        }

        return rtrim($url, '/');
    }
}
