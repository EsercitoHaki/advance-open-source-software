<?php

namespace App\Repositories;

use App\Models\User;
use App\DTOs\UserDTO; 

interface UserRepositoryInterface
{
    public function getCurrentUser(): User;

    public function updateProfile(User $user, UserDTO $userDTO): User;

    public function updatePassword(User $user, string $password): bool;

    public function updateAvatar(User $user, string $avatarPath): User;

    public function updateStats(User $user, array $stats): User;

    public function getUserById(string $userId): ?User;

    public function getFriendIds(string $userId): array;
    
    public function getUsersWithScoreByIds(array $userIds): Collection;
}