<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    protected $model;

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    public function getRootCommentsByLesson(int $lessonId): Collection
    {
        return $this->model->where('lesson_id', $lessonId)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('created_date', 'desc')
            ->with('user')
            ->get();
    }

    public function getRepliesByParentId(int $parentId): Collection
    {
        return $this->model->where('parent_id', $parentId)
            ->where('is_active', true)
            ->orderBy('created_date', 'asc')
            ->with('user')
            ->get();
    }

    public function create(array $data): Comment
    {
        return $this->model->create($data);
    }

    public function find(int $commentId): ?Comment
    {
        // Đây là đúng, dùng findOrFail sẽ tự động ném 404 nếu không tìm thấy
        return $this->model->findOrFail($commentId);
    }

    public function update(int $commentId, array $data): ?Comment
    {
        // Sửa lỗi ở đây: Chỉ truyền ID vào phương thức find của repository
        $comment = $this->find($commentId); 
        // Kiểm tra xem comment có tồn tại không trước khi update
        if ($comment) {
            $comment->update($data);
        }
        return $comment;
    }

    public function delete(int $commentId): bool
    {
        
        return $this->model->destroy($commentId); 

    }
}