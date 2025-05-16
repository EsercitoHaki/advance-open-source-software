<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\QuestionServiceInterface;
use App\Services\Interfaces\LessonServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AudioController extends Controller
{
    protected $questionService;
    protected $lessonService;

    public function __construct(
        QuestionServiceInterface $questionService,
        LessonServiceInterface $lessonService
    ) {
        $this->questionService = $questionService;
        $this->lessonService = $lessonService;
    }

    /**
     * Upload file âm thanh cho câu hỏi
     *
     * @param Request $request
     * @param int $questionId
     * @return JsonResponse
     */
    public function uploadAudio(Request $request, int $questionId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'audio_file' => 'required|file|mimes:mp3,wav,ogg|max:10240', // Tối đa 10MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            // Tìm câu hỏi
            $question = $this->questionService->getQuestionById($questionId);
            
            if (!$question) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy câu hỏi'
                ], 404);
            }

            // Kiểm tra xem câu hỏi có thuộc bài Listening không
            $lesson = $this->lessonService->getLessonById($question->lessonId);
            if ($lesson->category !== 'Listening') {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ có thể tải file âm thanh cho câu hỏi thuộc bài Listening'
                ], 400);
            }
            
            // Xóa file cũ nếu có
            if (!empty($question->audioFile)) {
                $oldPath = storage_path('app/public/audios/' . $question->audioFile);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            // Lưu file và cập nhật tên file trong DB
            $audioFile = $request->file('audio_file');
            $fileName = 'question_' . $questionId . '_' . time() . '.' . $audioFile->getClientOriginalExtension();
            $audioFile->storeAs('public/audios', $fileName);
            
            // Cập nhật câu hỏi với tên file âm thanh mới
            $updatedQuestion = $this->questionService->updateQuestion($questionId, ['audio_file' => $fileName]);
            
            return response()->json([
                'success' => true,
                'message' => 'Tải lên file âm thanh thành công',
                'data' => [
                    'question_id' => $questionId,
                    'audio_file' => $fileName,
                    'audio_url' => url('storage/audios/' . $fileName)
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi tải lên file âm thanh: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi tải lên file âm thanh',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}