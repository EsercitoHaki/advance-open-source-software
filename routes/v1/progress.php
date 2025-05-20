<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserProgressController;

Route::middleware(['jwt.auth'])->group(function () {
    Route::group(['prefix' => 'progress'], function () {
        // Lấy toàn bộ tiến độ học tập của người dùng hiện tại
        Route::get('/', [UserProgressController::class, 'getUserProgress']);

        // Lấy tiến độ học tập cho một bài học cụ thể
        Route::get('/lesson/{lessonId}', [UserProgressController::class, 'getLessonProgress']);

        // Bắt đầu một bài học
        Route::post('/lesson/{lessonId}/start', [UserProgressController::class, 'startLesson']);

        // Hoàn thành bài học và gửi đáp án
        Route::post('/lesson/{lessonId}/complete', [UserProgressController::class, 'completeLesson']);

        // Nộp một câu trả lời và nhận phản hồi ngay lập tức
        Route::post('/lesson/{lessonId}/question/{questionId}/submit', [UserProgressController::class, 'submitAnswer']);

        // Hoàn thành bài học sau khi đã nộp tất cả câu trả lời
        Route::post('/lesson/{lessonId}/finalize', [UserProgressController::class, 'finalizeLessonProgress']);        // Lấy thống kê học tập
        Route::get('/stats', [UserProgressController::class, 'getLearningStats']);
        
        // Test streak functionality
        Route::post('/update-streak', [UserProgressController::class, 'updateStreak']);
    });
});