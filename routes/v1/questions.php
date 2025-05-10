<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\QuestionController;

Route::middleware(['jwt.auth'])->group(function () {
    Route::group(['prefix' => 'questions'], function () {
        // Lấy danh sách tất cả câu hỏi
        Route::get('/', [QuestionController::class, 'index']);

        // Lấy câu hỏi theo ID
        Route::get('/{id}', [QuestionController::class, 'show']);

        // Lấy danh sách câu hỏi theo bài học
        Route::get('/lesson/{lessonId}', [QuestionController::class, 'getByLessonId']);

        // Tạo câu hỏi mới
        Route::post('/', [QuestionController::class, 'store']);

        // Cập nhật câu hỏi
        Route::put('/{id}', [QuestionController::class, 'update']);

        // Xóa câu hỏi
        Route::delete('/{id}', [QuestionController::class, 'destroy']);
    });

    // Lấy thông tin bài học kèm câu hỏi
    Route::get('/lessons/{lessonId}/with-questions', [QuestionController::class, 'getLessonWithQuestions']);
});