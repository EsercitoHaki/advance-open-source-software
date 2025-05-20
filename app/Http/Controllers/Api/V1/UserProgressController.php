<?php

namespace App\Http\Controllers\Api\V1;


use App\Exceptions\DataNotFoundException;
use App\Exceptions\InvalidParamException;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\UserProgressServiceInterface;
use App\Services\Interfaces\StreakServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\UserDailyMissionService;

class UserProgressController extends Controller
{
    /**
     * @var UserProgressServiceInterface
     */
    protected $userProgressService;

    /**
     * @var StreakServiceInterface
     */
    protected $streakService;

    /**
     * Khởi tạo controller với service cần thiết
     * 
     * @param UserProgressServiceInterface $userProgressService
     * @param StreakServiceInterface $streakService
     */
    public function __construct(
        UserProgressServiceInterface $userProgressService,
        StreakServiceInterface $streakService
    ) {
        $this->userProgressService = $userProgressService;
        $this->streakService = $streakService;
    }

    /**
     * Lấy tiến độ học tập của người dùng hiện tại
     *
     * @return JsonResponse
     */
    public function getUserProgress(): JsonResponse
    {
        try {
            $userId = auth()->user()->user_id;
            $progress = $this->userProgressService->getAllUserProgress($userId);

            return response()->json([
                'success' => true,
                'message' => 'Lấy tiến độ học tập thành công',
                'data' => $progress
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy tiến độ học tập: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi lấy tiến độ học tập',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy tiến độ học tập cho một bài học cụ thể
     *
     * @param int $lessonId
     * @return JsonResponse
     */
    public function getLessonProgress(int $lessonId): JsonResponse
    {
        try {
            $userId = auth()->user()->user_id;
            $progress = $this->userProgressService->getUserProgress($userId, $lessonId);

            return response()->json([
                'success' => true,
                'message' => 'Lấy tiến độ bài học thành công',
                'data' => $progress
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy tiến độ bài học: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi lấy tiến độ bài học',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bắt đầu một bài học
     *
     * @param int $lessonId
     * @return JsonResponse
     */
    public function startLesson(int $lessonId): JsonResponse
    {
        try {
            $userId = auth()->user()->user_id;
            $progress = $this->userProgressService->startLesson($userId, $lessonId);

            return response()->json([
                'success' => true,
                'message' => 'Bắt đầu bài học thành công',
                'data' => $progress
            ]);
        } catch (InvalidParamException $e) {
            // Xử lý riêng cho trường hợp hết mạng
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403); // 403 Forbidden - không có quyền tiếp tục học
        } catch (\Exception $e) {
            Log::error('Lỗi khi bắt đầu bài học: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi bắt đầu bài học',
                'error' => $e->getMessage()
            ], 500);
        }
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
        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*' => 'integer|exists:options,option_id',
            'elapsed_time' => 'nullable|integer|min:0'
        ], [
            'answers.required' => 'Thiếu danh sách câu trả lời',
            'answers.array' => 'Danh sách câu trả lời phải ở dạng mảng',
            'answers.*.integer' => 'ID của đáp án phải là số nguyên',
            'answers.*.exists' => 'Đáp án không tồn tại',
            'elapsed_time.integer' => 'Thời gian phải là số nguyên',
            'elapsed_time.min' => 'Thời gian không được âm'
        ]);

        

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $userId = auth()->user()->user_id;
            $userAnswers = $request->input('answers');
            $elapsedTime = $request->input('elapsed_time', 0);
            $result = $this->userProgressService->completeLesson($userId, $lessonId, $userAnswers, $elapsedTime);

            return response()->json([
                'success' => true,
                'message' => 'Hoàn thành bài học thành công',
                'data' => $result
            ]);
        } catch (InvalidParamException $e) {
            // Xử lý riêng cho trường hợp hết thời gian
            if (strpos($e->getMessage(), 'Thời gian làm bài đã hết') !== false) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error_code' => 'TIME_LIMIT_EXCEEDED'
                ], 403); // 403 Forbidden - không cho phép tiếp tục làm bài
            }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Exception $e) {
            Log::error('Lỗi khi hoàn thành bài học: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi hoàn thành bài học',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Nộp một câu trả lời và nhận phản hồi ngay lập tức
     *
     * @param Request $request
     * @param int $lessonId
     * @param int $questionId
     * @return JsonResponse
     */
    public function submitAnswer(Request $request, int $lessonId, int $questionId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'option_id' => 'required|integer|exists:options,option_id',
            'elapsed_time' => 'nullable|integer|min:0'
        ], [
            'option_id.required' => 'Thiếu ID đáp án được chọn',
            'option_id.integer' => 'ID đáp án phải là số nguyên',
            'option_id.exists' => 'Đáp án không tồn tại',
            'elapsed_time.integer' => 'Thời gian phải là số nguyên',
            'elapsed_time.min' => 'Thời gian không được âm'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $userId = auth()->user()->user_id;
            $selectedOptionId = $request->input('option_id');
            $elapsedTime = $request->input('elapsed_time', 0);
            $result = $this->userProgressService->submitSingleAnswer(
                $userId,
                $lessonId,
                $questionId,
                $selectedOptionId,
                $elapsedTime
            );

            return response()->json([
                'success' => true,
                'message' => 'Nộp câu trả lời thành công',
                'data' => $result
            ]);
        } catch (InvalidParamException $e) {
            // Xử lý riêng cho trường hợp hết thời gian
            if (strpos($e->getMessage(), 'Thời gian làm bài đã hết') !== false) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error_code' => 'TIME_LIMIT_EXCEEDED'
                ], 403); // 403 Forbidden - không cho phép tiếp tục làm bài
            }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Exception $e) {
            Log::error('Lỗi khi nộp câu trả lời: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Hoàn thành bài học sau khi đã nộp tất cả câu trả lời
     *
     * @param int $lessonId
     * @return JsonResponse
     */
    public function finalizeLessonProgress(int $lessonId): JsonResponse
    {
        try {
            $userId = auth()->user()->user_id;
            $result = $this->userProgressService->finalizeLessonProgress($userId, $lessonId);

            UserDailyMissionService::recordAction($userId, 'complete_lesson');

            return response()->json([
                'success' => true,
                'message' => 'Hoàn thành bài học thành công',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi hoàn thành bài học: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Lấy thống kê học tập của người dùng
     *
     * @return JsonResponse
     */
    public function getLearningStats(): JsonResponse
    {
        try {
            $userId = auth()->user()->user_id;
            $stats = $this->userProgressService->getUserLearningStats($userId);

            return response()->json([
                'success' => true,
                'message' => 'Lấy thống kê học tập thành công',
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy thống kê học tập: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi lấy thống kê học tập',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test streak functionality and update user streak manually
     *
     * @return JsonResponse
     */
    public function updateStreak(): JsonResponse
    {
        try {
            $userId = auth()->user()->user_id;
            $streakInfo = $this->streakService->updateStreak($userId);

            return response()->json([
                'success' => true,
                'message' => 'Streak updated successfully',
                'data' => $streakInfo
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating streak: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating streak',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}