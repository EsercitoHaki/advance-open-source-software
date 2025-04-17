<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\LessonServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Exceptions\DataNotFoundException;

class LessonController extends Controller
{
    protected $lessonService;

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
        $lessons = $this->lessonService->getAllLessons();
    
        return response()->json([
            'success' => true,
            'data' => $lessons // không cần ->map(...)->toArray()
        ]);
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
                'data' => $lesson->toArray()
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 404);
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
        $category = $request->query('category');

        if (!$category) {
            return response()->json([
                'error' => true,
                'message' => 'Thiếu tham số category'
            ], 400);
        }

        $lessons = $this->lessonService->getLessonsByCategory($category);

        return response()->json([
            'success' => true,
            'data' => $lessons->toArray()
        ]);
    }
} 