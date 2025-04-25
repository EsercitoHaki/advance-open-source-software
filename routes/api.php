<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;

$version = config('api.version');

Route::prefix($version)->group(function () use ($version) {
    $routePath = base_path("routes/{$version}");

    foreach(glob("{$routePath}/*.php") as $file) {
        require $file;
    }
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('/check-in', [CheckInController::class, 'checkIn']);
});
