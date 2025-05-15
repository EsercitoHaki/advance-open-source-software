<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserDailyMissionController;

Route::middleware(['jwt.auth'])->group(function () {
    Route::prefix('daily-missions')->group(function () {
        Route::get('/', [UserDailyMissionController::class, 'getDailyMissions']);
        Route::patch('/{missionId}/progress', [UserDailyMissionController::class, 'updateProgress']);
        Route::post('/{userMissionId}/claim', [UserDailyMissionController::class, 'claimReward']);
    });
});
