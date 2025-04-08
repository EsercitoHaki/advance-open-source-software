<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\DTOs\UserStatsDTO;
use Illuminate\Http\UploadedFile;

interface UserServiceInterface
{
    public function getCurrentUser(): UserDTO;

    public function updateProfile(UserDTO $userDTO): UserDTO;

    public function changePassword(string $currentPassword, string $newPassword): bool;

    public function uploadAvatar(UploadedFile $avatar): string;

    public function getUserStats(): UserStatsDTO;

    public function updateStreak(int $streak, bool $isNewRecord = false): UserDTO;
}
