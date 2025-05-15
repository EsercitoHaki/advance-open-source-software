<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\LeaderboardController;

Route::middleware(['jwt.auth'])->group(function () {
    Route::prefix('leaderboard')->group(function () {
        Route::get('/', [LeaderboardController::class, 'index']);
        Route::get('/my-rank', [LeaderboardController::class, 'getCurrentUserRank']);
    });
});
