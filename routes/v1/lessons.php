<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\LessonController;


Route::middleware(['jwt.auth'])->group(function () {
    Route::group(['prefix' => 'lessons'], function () {
        // Lấy danh sách tất cả bài học
        Route::get('/', [LessonController::class, 'index']);
        // Lấy bài học theo danh mục
        Route::get('/category', [LessonController::class, 'getByCategory']);
        // Lấy bài học theo ID
        Route::get('/{id}', [LessonController::class, 'show']);
    });
    
});

Route::middleware(['jwt.auth', 'admin'])->group(function () {
    Route::group(['prefix' => 'lessons'], function () {
        // Tạo bài học mới
        Route::post('/', [LessonController::class, 'create']);
        // Cập nhật bài học
        Route::put('/{id}', [LessonController::class, 'update']);
        // Xóa bài học
        Route::delete('/{id}', [LessonController::class, 'destroy']);
    });
});
