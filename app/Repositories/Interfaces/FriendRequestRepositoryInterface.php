<?php

namespace App\Repositories\Interfaces;


use App\Models\FriendRequest;

interface FriendRequestRepositoryInterface
{
    /**
     * Send a friend request from one user to another
     *
     * @param string $senderId
     * @param string $receiverId
     * @return FriendRequest
     */
    public function sendFriendRequest(string $senderId, string $receiverId): FriendRequest;

    /**
     *
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReceivedFriendRequests(string $userId);

    /**
     *
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSentFriendRequests(string $userId);

    /**
     *
     * @param string $requestId
     * @return bool
     */
    public function acceptFriendRequest(string $requestId): bool;

    /**
     *
     * @param string $requestId
     * @return bool
     */
    public function rejectFriendRequest(string $requestId): bool;

    /**
     *
     * @param string $requestId
     * @return FriendRequest|null
     */
    public function findFriendRequestById(string $requestId): ?FriendRequest;

    /**
     *
     * @param string $senderId
     * @param string $receiverId
     * @return bool
     */
    public function checkFriendRequestExists(string $senderId, string $receiverId): bool;

    /**
     *
     * @param string $senderId
     * @param string $receiverId
     * @return FriendRequest|null
     */
    public function findPendingRequest(string $senderId, string $receiverId): ?FriendRequest;

    /**
     *
     * @param string $senderId
     * @param string $receiverId
     * @return FriendRequest|null
     */
    public function findReversePendingRequest(string $senderId, string $receiverId): ?FriendRequest;
}