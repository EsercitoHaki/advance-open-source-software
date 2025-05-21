<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\LessonServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Exceptions\DataNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    /**
     * @var LessonServiceInterface
     */
    protected $lessonService;

    /**
     * Khởi tạo controller với service cần thiết
     * 
     * @param LessonServiceInterface $lessonService
     */
    public function __construct(LessonServiceInterface $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    /**
     * Lấy danh sách tất cả bài học.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $lessons = $this->lessonService->getAllLessons();

            return response()->json([
                'success' => true,
                'message' => 'Lấy danh sách bài học thành công',
                'data' => $lessons
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách bài học: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi lấy danh sách bài học',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy bài học theo ID.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $lesson = $this->lessonService->getLessonById($id);

            return response()->json([
                'success' => true,
                'message' => 'Lấy thông tin bài học thành công',
                'data' => $lesson
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy thông tin bài học: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi lấy thông tin bài học',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy danh sách bài học theo danh mục.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getByCategory(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string'
        ], [
            'category.required' => 'Thiếu tham số category'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $category = $request->query('category');
            $lessons = $this->lessonService->getLessonsByCategory($category);

            return response()->json([
                'success' => true,
                'message' => 'Lấy danh sách bài học theo danh mục thành công',
                'data' => $lessons
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách bài học theo danh mục: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi lấy danh sách bài học theo danh mục',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tạo bài học mới
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:Grammar,Vocabulary,Listening,Reading'
        ], [
            'title.required' => 'Thiếu tiêu đề bài học',
            'title.max' => 'Tiêu đề bài học không được vượt quá 255 ký tự',
            'category.required' => 'Thiếu danh mục bài học',
            'category.in' => 'Danh mục bài học không hợp lệ'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $lessonData = $request->only(['title', 'category']);
            $lesson = $this->lessonService->createLesson($lessonData);

            return response()->json([
                'success' => true,
                'message' => 'Tạo bài học mới thành công',
                'data' => $lesson
            ], 201);
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo bài học mới: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi tạo bài học mới',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255'
        ], [
            'title.required' => 'Thiếu tiêu đề bài học',
            'title.max' => 'Tiêu đề bài học không được vượt quá 255 ký tự'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $updatedLesson = $this->lessonService->updateLesson($id, $request->only('title'));
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật bài học thành công',
                'data' => $updatedLesson
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật bài học: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi cập nhật bài học',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->lessonService->deleteLesson($id);
            return response()->json([
                'success' => true,
                'message' => 'Xóa bài học thành công'
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa bài học: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xóa bài học',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}