<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\FriendController;

// Friend system routes - protected by JWT auth
Route::prefix('friends')->middleware(['jwt.auth'])->group(function () {
    // Friend requests
    Route::post('/requests', [FriendController::class, 'sendFriendRequest']);
    Route::get('/requests/received', [FriendController::class, 'getPendingRequests']);
    Route::get('/requests/sent', [FriendController::class, 'getSentRequests']);
    Route::post('/requests/{requestId}/accept', [FriendController::class, 'acceptFriendRequest']);
    Route::post('/requests/{requestId}/reject', [FriendController::class, 'rejectFriendRequest']);
    Route::delete('/requests/{requestId}/cancel', [FriendController::class, 'cancelFriendRequest']);

    // Friends management
    Route::get('/', [FriendController::class, 'getFriendsList']);
    Route::delete('/{friendId}', [FriendController::class, 'removeFriend']);
});