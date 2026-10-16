<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('virtual-tryon:cleanup', function () {
    $disk = Storage::disk('local');
    $expiredBefore = now()->subHours(24)->timestamp;
    foreach ($disk->files('virtual-tryon/results') as $path) {
        if ($disk->lastModified($path) < $expiredBefore) {
            $disk->delete($path);
        }
    }
})->purpose('Delete expired private virtual try-on results');

Schedule::command('virtual-tryon:cleanup')->hourly()->withoutOverlapping();
