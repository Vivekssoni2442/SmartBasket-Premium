<?php

use App\Http\Controllers\AICameraController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AI Camera Shopping Assistant - API Routes
|--------------------------------------------------------------------------
| These routes are loaded separately from web.php and are prefixed with
| /api by default. They do NOT affect any existing web route.
|
| Existing routes (products, cart, profile, seller, checkout, etc.) remain
| completely untouched and served from routes/web.php.
*/

Route::post('/ai-recommend', [AICameraController::class, 'recommend'])
    ->name('api.ai-recommend');