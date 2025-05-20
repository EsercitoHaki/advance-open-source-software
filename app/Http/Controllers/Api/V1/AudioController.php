<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\QuestionServiceInterface;
use App\Services\Interfaces\LessonServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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

            // Đảm bảo thư mục tồn tại
            $storageDir = storage_path('app/public/audios');
            if (!file_exists($storageDir)) {
                mkdir($storageDir, 0755, true);
            }

            // Lưu trực tiếp vào public/audios để đảm bảo chỉ có 1 bản sao
            $audioFile->storeAs('public/audios', $fileName);

            // Cập nhật câu hỏi với tên file âm thanh mới
            $updatedQuestion = $this->questionService->updateQuestion($questionId, ['audio_file' => $fileName]);
            // Cung cấp nhiều URL khác nhau để truy cập file
            $directUrl = url('storage/audios/' . $fileName);
            $apiUrl = url('/api/v1/audio/file/' . $fileName);
            $questionApiUrl = url('/api/v1/audio/question/' . $questionId);

            return response()->json([
                'success' => true,
                'message' => 'Tải lên file âm thanh thành công',
                'data' => [
                    'question_id' => $questionId,
                    'audio_file' => $fileName,
                    'audio_url' => $apiUrl,
                    'urls' => [
                        'direct' => $directUrl,
                        'api' => $apiUrl,
                        'question_api' => $questionApiUrl
                    ]
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
    /**
     * Stream audio file directly by question ID
     *
     * @param int $questionId
     * @return \Illuminate\Http\Response
     */
    public function streamAudio($questionId)
    {
        try {
            // Lấy thông tin câu hỏi
            $question = $this->questionService->getQuestionById($questionId);

            // Kiểm tra xem câu hỏi có tồn tại không
            if (!$question) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy câu hỏi'
                ], 404);
            }
            // Trích xuất tên file audio từ DTO - audioFile là tên property chính xác 
            $audioFile = $question->audioFile;

            // Nếu không có file audio
            if (empty($audioFile)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Câu hỏi này không có file âm thanh'
                ], 404);
            }
            $path = storage_path('app/public/audios/' . $audioFile);

            if (!File::exists($path)) {
                // Thử tìm ở các vị trí khác
                $possiblePaths = [
                    storage_path('app/public/audios/' . $audioFile),
                    storage_path('app/private/public/audios/' . $audioFile),
                    public_path('storage/audios/' . $audioFile)
                ];

                foreach ($possiblePaths as $possiblePath) {
                    if (File::exists($possiblePath)) {
                        $path = $possiblePath;
                        break;
                    }
                }

                if (!File::exists($path)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'File âm thanh không tồn tại: ' . $audioFile,
                        'paths_checked' => $possiblePaths
                    ], 404);
                }
            }

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            $response->header("Content-Disposition", "inline");
            $response->header("Access-Control-Allow-Origin", "*"); // Để xử lý vấn đề CORS

            return $response;
        } catch (\Exception $e) {
            Log::error('Lỗi khi phát file âm thanh: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi phát file âm thanh',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Stream audio file directly by filename
     *
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function streamAudioFile($filename)
    {
        $path = storage_path('app/public/audios/' . $filename);

        if (!File::exists($path)) {
            // Thử tìm ở các vị trí khác
            $possiblePaths = [
                storage_path('app/public/audios/' . $filename),
                storage_path('app/private/public/audios/' . $filename),
                public_path('storage/audios/' . $filename)
            ];

            foreach ($possiblePaths as $possiblePath) {
                if (File::exists($possiblePath)) {
                    $path = $possiblePath;
                    break;
                }
            }

            if (!File::exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File âm thanh không tồn tại: ' . $filename,
                    'paths_checked' => $possiblePaths
                ], 404);
            }
        }

        try {
            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            $response->header("Content-Disposition", "inline");
            $response->header("Access-Control-Allow-Origin", "*"); // Để xử lý vấn đề CORS

            return $response;
        } catch (\Exception $e) {
            Log::error('Lỗi khi phát file âm thanh: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi phát file âm thanh',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}