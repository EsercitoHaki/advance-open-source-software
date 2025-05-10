<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\QuestionServiceInterface;
use App\Services\Interfaces\LessonServiceInterface;
use App\Services\Interfaces\OptionServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Exceptions\DataNotFoundException;

class QuestionController extends Controller
{
    protected $questionService;
    protected $lessonService;
    protected $optionService;

    public function __construct(
        QuestionServiceInterface $questionService,
        LessonServiceInterface $lessonService,
        OptionServiceInterface $optionService
    ) {
        $this->questionService = $questionService;
        $this->lessonService = $lessonService;
        $this->optionService = $optionService;
    }

    /**
     * Lấy danh sách tất cả câu hỏi.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $questions = $this->questionService->getAllQuestions();

        return response()->json([
            'success' => true,
            'data' => $questions
        ]);
    }

    /**
     * Lấy thông tin chi tiết của câu hỏi.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $question = $this->questionService->getQuestionById($id);

            return response()->json([
                'success' => true,
                'data' => $question
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Lấy danh sách câu hỏi theo bài học.
     *
     * @param int $lessonId
     * @return JsonResponse
     */
    public function getByLessonId(int $lessonId): JsonResponse
    {
        try {
            // Kiểm tra bài học có tồn tại
            $this->lessonService->getLessonById($lessonId);

            // Lấy câu hỏi của bài học
            $questions = $this->questionService->getQuestionsByLessonId($lessonId);

            return response()->json([
                'success' => true,
                'data' => $questions
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Tạo câu hỏi mới.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lesson_id' => 'required|integer',
            'score' => 'numeric|min:0.01|max:100',
            'content' => 'nullable|string',
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
        ]);

        try {
            // Kiểm tra bài học có tồn tại
            $this->lessonService->getLessonById($validated['lesson_id']);

            // Tạo câu hỏi mới
            $question = $this->questionService->createQuestion($validated);

            return response()->json([
                'success' => true,
                'message' => 'Tạo câu hỏi thành công',
                'data' => $question
            ], 201);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Cập nhật câu hỏi.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'lesson_id' => 'integer',
            'score' => 'numeric|min:0.01|max:100',
            'content' => 'nullable|string',
            'question_text' => 'string',
            'explanation' => 'nullable|string',
        ]);

        try {
            // Nếu có lesson_id, kiểm tra bài học có tồn tại
            if (isset($validated['lesson_id'])) {
                $this->lessonService->getLessonById($validated['lesson_id']);
            }

            // Cập nhật câu hỏi
            $question = $this->questionService->updateQuestion($id, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật câu hỏi thành công',
                'data' => $question
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Xóa câu hỏi.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->questionService->deleteQuestion($id);

            return response()->json([
                'success' => true,
                'message' => 'Xóa câu hỏi thành công'
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Lấy nội dung bài học và danh sách câu hỏi kèm đáp án.
     *
     * @param int $lessonId
     * @return JsonResponse
     */
    public function getLessonWithQuestions(int $lessonId): JsonResponse
    {
        try {
            // Lấy thông tin bài học
            $lesson = $this->lessonService->getLessonById($lessonId);

            // Lấy danh sách câu hỏi của bài học
            $questions = $this->questionService->getQuestionsByLessonId($lessonId);

            // Thêm options cho mỗi câu hỏi
            $questionsWithOptions = $questions->map(function ($question) {
                $questionArray = $question->toArray();
                $options = $this->optionService->getOptionsByQuestionId($question->questionId);
                $questionArray['options'] = $options;
                return $questionArray;
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'lesson' => $lesson,
                    'questions' => $questionsWithOptions
                ]
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 404);
        }
    }
}