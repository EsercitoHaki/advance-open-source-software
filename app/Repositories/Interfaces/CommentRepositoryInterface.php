<?php

namespace App\Repositories\Interfaces;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    public function getRootCommentsByLesson(int $lessonId): Collection;
    public function getRepliesByParentId(int $parentId): Collection;
    public function create(array $data): Comment;
    public function find(int $id): ?Comment;
    public function update(int $id, array $data): ?Comment;
    public function delete(int $id): bool;
}