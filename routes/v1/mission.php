<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\MissionController;
use App\Http\Controllers\Api\V1\UserDailyMissionController;

Route::middleware(['jwt.auth'])->group(function () {
    Route::group(['prefix' => 'missions'], function () {
        Route::get('/', [MissionController::class, 'index']);
        Route::get('/{id}', [MissionController::class, 'show']);
        Route::post('/', [MissionController::class, 'store']);
        Route::put('/{id}', [MissionController::class, 'update']);
        Route::delete('/{id}', [MissionController::class, 'destroy']);
    }); 
});
