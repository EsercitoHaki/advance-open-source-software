<?php

namespace App\Services;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class CommentService implements CommentServiceInterface
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getNestedCommentsByLesson(int $lessonId): Collection
    {
        $rootComments = $this->commentRepository->getRootCommentsByLesson($lessonId);

        return $rootComments->map(function ($comment) {
            return $this->transformComment($comment);
        });
    }

    protected function transformComment($comment): array
    {
        return [
            'id' => $comment->comment_id,
            'name' => $comment->user->full_name ?? 'Unknown User',
            'username' => $comment->user->username ?? 'Unknown',
            'avatar' => $comment->user->avatar ?? 'default-avatar.png',
            'content' => $comment->content,
            'time' => $comment->created_date ? $comment->created_date->diffForHumans() : '',
            'replies' => $this->getNestedReplies($comment),
        ];
    }

    protected function getNestedReplies($parentComment): Collection
    {
        $replies = $this->commentRepository->getRepliesByParentId($parentComment->comment_id);

        return $replies->map(function ($reply) {
            return $this->transformComment($reply);
        });
    }

    public function createComment(array $data): ?object
    {
        $data['created_date'] = now();
        return $this->commentRepository->create($data);
    }

    public function updateComment(int $commentId, array $data): ?object
    {
        return $this->commentRepository->update($commentId, $data);
    }

    public function deleteComment(int $commentId): bool
    {
        return $this->commentRepository->delete($commentId);
    }

    public function find(int $commentId): ?object
    {
        return $this->commentRepository->find($commentId);
    }
}