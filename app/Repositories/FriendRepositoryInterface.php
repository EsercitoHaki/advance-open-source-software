<?php

namespace App\Repositories;

use App\Models\Friend;
use App\Models\User;

interface FriendRepositoryInterface
{
    /**
     * Create a friendship between two users
     *
     * @param string $user1Id
     * @param string $user2Id
     * @return Friend
     */
    public function createFriendship(string $user1Id, string $user2Id): Friend;

    /**
     * Get all friends of a user
     *
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserFriends(string $userId);

    /**
     * Check if two users are friends
     *
     * @param string $user1Id
     * @param string $user2Id
     * @return bool
     */
    public function checkFriendshipExists(string $user1Id, string $user2Id): bool;

    /**
     * Remove a friendship between two users
     *
     * @param string $user1Id
     * @param string $user2Id
     * @return bool
     */
    public function removeFriendship(string $user1Id, string $user2Id): bool;
}