<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SiteSettings
{
    private const DEFAULTS = [
        'customer_registration_enabled' => true,
        'seller_registration_enabled' => true,
        'return_requests_enabled' => true,
    ];

    public function all(): array
    {
        return Cache::remember('site-settings.all', 300, function () {
            $settings = self::DEFAULTS;
            foreach (SiteSetting::query()->whereIn('key', array_keys(self::DEFAULTS))->get() as $setting) {
                $settings[$setting->key] = filter_var($setting->value, FILTER_VALIDATE_BOOLEAN);
            }

            return $settings;
        });
    }

    public function enabled(string $key): bool
    {
        return (bool) ($this->all()[$key] ?? false);
    }

    public function saveFeatures(array $values): void
    {
        foreach (self::DEFAULTS as $key => $default) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => ! empty($values[$key]) ? '1' : '0'],
            );
        }

        Cache::forget('site-settings.all');
    }
}
