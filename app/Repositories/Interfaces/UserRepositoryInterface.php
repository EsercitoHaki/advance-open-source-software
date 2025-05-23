<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get the currently authenticated user
     *
     * @return User
     */
    public function getCurrentUser(): User;

    /**
     * Update user profile information
     *
     * @param User $user
     * @param UserDTO $userDTO
     * @return User
     */
    public function updateProfile(User $user, UserDTO $userDTO): User;

    /**
     * Update user password
     *
     * @param User $user
     * @param string $password
     * @return bool
     */
    public function updatePassword(User $user, string $password): bool;

    /**
     * Update user avatar
     *
     * @param User $user
     * @param string $avatarPath
     * @return User
     */
    public function updateAvatar(User $user, string $avatarPath): User;

    /**
     * Update user statistics
     *
     * @param User $user
     * @param array $stats
     * @return User
     */
    public function updateStats(User $user, array $stats): User;

    /**
     * Get user by ID
     *
     * @param string $userId
     * @return User|null
     */
    public function getUserById(string $userId): ?User;    /**
             * Get all users with optional username search
             *
             * @param string|null $username
             * @return Collection
             */
    public function getAllUsers(?string $username = null): Collection;

    /**
     * Search users by username
     *
     * @param string $username
     * @param int $limit
     * @return Collection
     */
    public function searchUsersByUsername(string $username, int $limit = 10): Collection;
    
    public function getUsersWithTotalScore();

    public function findUserWithScore(string $userId);
}