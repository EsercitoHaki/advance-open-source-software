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

    public function find(int $id): ?Comment
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data): ?Comment
    {
        $comment = $this->find($id);
        $comment->update($data);
        return $comment;
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id);
    }
}