<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Services\UserProgressServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserProgressController extends Controller
{
    protected $userProgressService;

    public function __construct(UserProgressServiceInterface $userProgressService)
    {
        $this->userProgressService = $userProgressService;
    }

    /**
     * Lấy tiến độ học tập của người dùng hiện tại
     *
     * @return JsonResponse
     */
    public function getUserProgress(): JsonResponse
    {
        $userId = auth()->user()->user_id;
        $progress = $this->userProgressService->getAllUserProgress($userId);

        return response()->json([
            'status' => 'success',
            'data' => $progress
        ]);
    }

    /**
     * Lấy tiến độ học tập cho một bài học cụ thể
     *
     * @param int $lessonId
     * @return JsonResponse
     */
    public function getLessonProgress(int $lessonId): JsonResponse
    {
        $userId = auth()->user()->user_id;
        $progress = $this->userProgressService->getUserProgress($userId, $lessonId);

        return response()->json([
            'status' => 'success',
            'data' => $progress
        ]);
    }

    /**
     * Bắt đầu một bài học
     *
     * @param int $lessonId
     * @return JsonResponse
     */
    public function startLesson(int $lessonId): JsonResponse
    {
        $userId = auth()->user()->user_id;
        $progress = $this->userProgressService->startLesson($userId, $lessonId);

        return response()->json([
            'status' => 'success',
            'message' => 'Lesson started successfully',
            'data' => $progress
        ]);
    }

    /**
     * Hoàn thành bài học và nộp câu trả lời
     *
     * @param Request $request
     * @param int $lessonId
     * @return JsonResponse
     */
    public function completeLesson(Request $request, int $lessonId): JsonResponse
    {
        $userId = auth()->user()->user_id;
        $userAnswers = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'integer|exists:options,option_id'
        ])['answers'];

        $result = $this->userProgressService->completeLesson($userId, $lessonId, $userAnswers);

        return response()->json([
            'status' => 'success',
            'message' => 'Lesson completed successfully',
            'data' => $result
        ]);
    }

    /**
     * Lấy thống kê học tập của người dùng
     *
     * @return JsonResponse
     */
    public function getLearningStats(): JsonResponse
    {
        $userId = auth()->user()->user_id;
        $stats = $this->userProgressService->getUserLearningStats($userId);

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }
}