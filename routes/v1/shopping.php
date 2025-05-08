<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\StoreItemController;
use App\Http\Controllers\Api\V1\UserPurchaseController;
use App\Http\Middleware\JwtMiddleware;

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/store-items', [StoreItemController::class, 'getStoreItems']);
    // Route::get('/store-items/status/{userId}', [StoreItemController::class, 'getItemsWithPurchaseStatus']); // Thieu chuc nang
    Route::post('/purchase-item/{item_id}', [UserPurchaseController::class, 'purchaseItem']);
    Route::get('/purchase-history', [UserPurchaseController::class, 'getPurchaseHistory']);
});
