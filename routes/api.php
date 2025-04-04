<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;

$version = config('api.version');

// Route::get('/v1/test', [UserController::class, 'index']);

// Route::prefix($version)->group(function () {
//     Route::get('/test', [UserController::class, 'index']);
// });

Route::prefix($version)->group(function () use ($version) {
    $routePath = base_path("routes/{$version}");

    foreach(glob("{$routePath}/*.php") as $file) {
        require $file;
    }
});