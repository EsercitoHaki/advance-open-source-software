<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\StoreItemController;
use App\Http\Controllers\Api\V1\UserPurchaseController;
use App\Http\Controllers\Api\V1\MascotPicController;
use App\Http\Middleware\JwtMiddleware;

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/store-items', [StoreItemController::class, 'getStoreItems']);
    Route::get('/store-items/status', [StoreItemController::class, 'getStoreItemsWithPurchaseStatus']); 
    Route::post('/purchase-item/{itemId}', [UserPurchaseController::class, 'purchaseItem']);
    Route::get('/purchase-history', [UserPurchaseController::class, 'getPurchaseHistory']);
    Route::get('/mascot-pics/{mascotId}', [MascotPicController::class, 'getMascotPics']);
    Route::get('/mascot-pics/main/{mascotId}', [MascotPicController::class, 'getMainMascotPic']);
});
