<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CheckInController;

Route::middleware('auth:api')->group(function () {
    Route::post('/check-in', [CheckInController::class, 'checkIn']);
    Route::get('/check-in/history', [CheckInController::class, 'getHistory']);
});


