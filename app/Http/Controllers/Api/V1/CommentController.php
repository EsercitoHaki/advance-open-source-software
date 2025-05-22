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


    public function update(int $lessonId, int $commentId, Request $request): JsonResponse
    {
        $comment = $this->commentService->find($commentId);

        // Kiểm tra xem comment có tồn tại và thuộc về người dùng hiện tại không
        if (!$comment) {
            return response()->json(['message' => 'Không tìm thấy bình luận.'], 404);
        }
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Bạn không có quyền sửa bình luận này.'], 403); // 403 Forbidden thay vì 404
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $updatedComment = $this->commentService->updateComment($commentId, $validator->validated());

        if ($updatedComment) {
            return response()->json(['message' => 'Bình luận đã được cập nhật.', 'comment' => $updatedComment], 200); // Thêm mã 200 OK
        } else {
            return response()->json(['message' => 'Không thể cập nhật bình luận.'], 500);
        }
    }

    public function destroy(int $lessonId, int $commentId): JsonResponse
    {


        $deleted = $this->commentService->deleteComment($commentId);

        if ($deleted) {
            return response()->json(['message' => 'Comment deleted successfully'], 200);
        }

        return response()->json(['message' => 'Failed to delete comment'], 500);
    }


}