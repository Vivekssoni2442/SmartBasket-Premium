<?php

use App\Http\Controllers\CustomerAiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'throttle:30,1'])
    ->post('/customer-ai/message', [CustomerAiController::class, 'message'])
    ->name('customer-ai.message');
