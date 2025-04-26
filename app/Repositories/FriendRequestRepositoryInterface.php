<?php

namespace App\Repositories;

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
     * Get all friend requests received by a user
     *
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReceivedFriendRequests(string $userId);

    /**
     * Get all friend requests sent by a user
     *
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSentFriendRequests(string $userId);

    /**
     * Accept a friend request
     *
     * @param string $requestId
     * @return bool
     */
    public function acceptFriendRequest(string $requestId): bool;

    /**
     * Reject a friend request
     *
     * @param string $requestId
     * @return bool
     */
    public function rejectFriendRequest(string $requestId): bool;

    /**
     * Find a friend request by ID
     *
     * @param string $requestId
     * @return FriendRequest|null
     */
    public function findFriendRequestById(string $requestId): ?FriendRequest;

    /**
     * Check if a friend request already exists between users
     *
     * @param string $senderId
     * @param string $receiverId
     * @return bool
     */
    public function checkFriendRequestExists(string $senderId, string $receiverId): bool;
}