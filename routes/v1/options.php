<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\OptionController;

Route::middleware(['jwt.auth'])->group(function () {
    Route::group(['prefix' => 'options'], function () {
        // Lấy danh sách tất cả options cho một câu hỏi
        Route::get('/question/{questionId}', [OptionController::class, 'getByQuestionId']);
    });

    // Tạo nhiều options cho một câu hỏi
    Route::post('/questions/{questionId}/options', [OptionController::class, 'createOptionsForQuestion']);
});

Route::middleware(['jwt.auth', 'admin'])->group(function () {
    Route::group(['prefix' => 'options'], function () {
        // Tạo option mới
        Route::post('/', [OptionController::class, 'create']);

        // Cập nhật option
        Route::put('/{optionId}', [OptionController::class, 'update']);

        // Xóa option
        Route::delete('/{optionId}', [OptionController::class, 'delete']);
    });
    
    Route::post('/questions/{questionId}/options', [OptionController::class, 'createOptionsForQuestion']);
});