<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\StoreItemController;
use App\Http\Controllers\Api\V1\UserPurchaseController;

Route::middleware('auth:api')->group(function () {
    Route::get('/store-items', [StoreItemController::class, 'getStoreItems']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/purchase-item', [UserPurchaseController::class, 'purchaseItem']);
    Route::get('/purchase-history', [UserPurchaseController::class, 'getPurchaseHistory']);
});
