<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    public function getCommentsByLesson(int $lessonId): JsonResponse
    {
        $comments = $this->commentService->getNestedCommentsByLesson($lessonId);

        return response()->json([
            'cmtList' => $comments,
        ]);
    }

    public function store(Request $request, int $lessonId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'parent_id' => 'nullable|integer|exists:comments,comment_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = Auth::id();
        $data['lesson_id'] = $lessonId;

        $comment = $this->commentService->createComment($data);

        if ($comment) {
            return response()->json(['message' => 'Bình luận đã được thêm.', 'comment' => $comment], 201);
        } else {
            return response()->json(['message' => 'Không thể thêm bình luận.'], 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $comment = $this->commentService->find($id);
        if (!$comment || $comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Không tìm thấy bình luận hoặc bạn không có quyền sửa.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updatedComment = $this->commentService->updateComment($id, $validator->validated());

        if ($updatedComment) {
            return response()->json(['message' => 'Bình luận đã được cập nhật.', 'comment' => $updatedComment]);
        } else {
            return response()->json(['message' => 'Không thể cập nhật bình luận.'], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        $comment = $this->commentService->find($id);
        if (!$comment || $comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Không tìm thấy bình luận hoặc bạn không có quyền xóa.'], 404);
        }

        if ($this->commentService->deleteComment($id)) {
            return response()->json(['message' => 'Bình luận đã được xóa.']);
        } else {
            return response()->json(['message' => 'Không thể xóa bình luận.'], 500);
        }
    }
}