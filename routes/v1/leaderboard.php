<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\LeaderboardController;

Route::middleware(['jwt.auth'])->group(function () {
    Route::prefix('leaderboard')->group(function () {
        Route::get('/', [LeaderboardController::class, 'index']);
        Route::get('/user', [LeaderboardController::class, 'getUserRank']);
        Route::get('/friends', [LeaderboardController::class, 'getFriendsLeaderboard']);
        Route::get('/friends/compare', [LeaderboardController::class, 'compareFriendsRank']);
    });
});
