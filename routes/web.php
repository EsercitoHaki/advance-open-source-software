<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
    ->name('password.reset');
