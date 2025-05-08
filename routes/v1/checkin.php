<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CheckInController;
use App\Http\Middleware\JwtMiddleware;

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/check-in', [CheckInController::class, 'checkIn']);
    Route::get('/check-in/history', [CheckInController::class, 'getHistory']);
});


