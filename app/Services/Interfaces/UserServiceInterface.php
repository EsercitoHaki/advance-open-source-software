<?php

namespace App\Services\Interfaces;

use App\DTOs\UserDTO;
use App\DTOs\UserStatsDTO;
use Illuminate\Http\UploadedFile;

interface UserServiceInterface
{
    /**
     * Get the current authenticated user
     *
     * @return UserDTO
     */
    public function getCurrentUser(): UserDTO;

    /**
     * Update user profile information
     *
     * @param UserDTO $userDTO
     * @return UserDTO
     */
    public function updateProfile(UserDTO $userDTO): UserDTO;

    /**
     * Change user password
     *
     * @param string $currentPassword
     * @param string $newPassword
     * @return bool
     */
    public function changePassword(string $currentPassword, string $newPassword): bool;

    /**
     * Upload user avatar
     *
     * @param UploadedFile $avatar
     * @return string
     */
    public function uploadAvatar(UploadedFile $avatar): string;

    /**
     * Get user statistics
     *
     * @return UserStatsDTO
     */
    public function getUserStats(): UserStatsDTO;

    /**
     * Update user streak
     *
     * @param int $streak
     * @param bool $isNewRecord
     * @return UserDTO
     */
    public function updateStreak(int $streak, bool $isNewRecord = false): UserDTO;    /**
                 * Get all users with optional username search
                 *
                 * @param string|null $username
                 * @return array
                 */
    public function getAllUsers(?string $username = null): array;

    /**
     * Search users by username
     *
     * @param string $username
     * @param int $limit
     * @return array
     */
    public function searchUsersByUsername(string $username, int $limit = 10): array;
}
