<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface CommentServiceInterface
{
    public function getNestedCommentsByLesson(int $lessonId): Collection;
    public function createComment(array $data): ?object;
    public function updateComment(int $commentId, array $data): ?object;
    public function deleteComment(int $commentId): bool;
    public function find(int $commentId): ?object;
}