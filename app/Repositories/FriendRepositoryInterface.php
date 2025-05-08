<?php

namespace App\Repositories;

use App\Models\Friend;
use App\Models\User;

interface FriendRepositoryInterface
{
    /**
     *
     * @param string $user1Id
     * @param string $user2Id
     * @return Friend
     */
    public function createFriendship(string $user1Id, string $user2Id): Friend;

    /**
     *
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserFriends(string $userId);

    /**
     *
     * @param string $user1Id
     * @param string $user2Id
     * @return bool
     */
    public function checkFriendshipExists(string $user1Id, string $user2Id): bool;

    /**
     *
     * @param string $user1Id
     * @param string $user2Id
     * @return bool
     */
    public function removeFriendship(string $user1Id, string $user2Id): bool;

    /**
     *
     * @param string $userId
     * @return User|null
     */
    public function findUserById(string $userId): ?User;

    /**
     *
     * @param string $user1Id
     * @param string $user2Id
     * @return bool
     */
    public function areFriends(string $user1Id, string $user2Id): bool;
}