<?php

namespace App\Repositories;

use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getCurrentUser(): User
    {
        return Auth::user();
    }

    public function updateProfile(User $user, UserDTO $userDTO): User
    {
        $updateData = array_filter([
            'username' => $userDTO->username,
            'email' => $userDTO->email,
            'first_name' => $userDTO->firstName,
            'last_name' => $userDTO->lastName,
        ], fn($value) => $value !== null);

        if ($updateData) {
            $user->update($updateData);
        }
        
        return $user;
    }

    public function updatePassword(User $user, string $password): bool
    {
        $user->password = bcrypt($password);
        return $user->save();
    }

    public function updateAvatar(User $user, string $avatarPath): User
    {
        $user->avatar = $avatarPath;
        $user->save();
        
        return $user;
    }

    public function updateStats(User $user, array $stats): User
    {
        $user->update($stats);
        return $user;
    }

    public function getUserById(string $userId): ?User
    {
        return User::find($userId);
    }
}