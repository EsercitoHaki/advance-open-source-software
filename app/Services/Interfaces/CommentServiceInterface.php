<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface CommentServiceInterface
{
    public function getNestedCommentsByLesson(int $lessonId): Collection;
    public function createComment(array $data): ?object;
    public function updateComment(int $id, array $data): ?object;
    public function deleteComment(int $id): bool;
    public function find(int $id): ?object;
}