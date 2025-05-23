<?php

use App\Http\Controllers\Api\V1\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.auth'])->group(function () {
    Route::prefix('lessons/{lessonId}')->group(function () {
        Route::get('/comments', [CommentController::class, 'getCommentsByLesson']);
        Route::post('/comments', [CommentController::class, 'store']);
        Route::put('/comments/{commentId}', [CommentController::class, 'update']);
        Route::delete('/comments/{commentId}', [CommentController::class, 'destroy']);
    });
});