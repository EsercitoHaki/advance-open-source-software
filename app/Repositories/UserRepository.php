<?php

namespace App\Repositories;

use App\Models\User;
use App\DTOs\UserDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

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
            'full_name' => $userDTO->fullName,
            'gender' => $userDTO->gender,
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

    /**
     * Get all users with optional username search
     *
     * @param string|null $username
     * @return Collection
     */
    public function getAllUsers(?string $username = null): Collection
    {
        $query = User::query()->where('user_id', '!=', Auth::id());

        if ($username) {
            $query->where('username', 'like', '%' . $username . '%');
        }

        return $query->select([
            'user_id',
            'username',
            'email',
            'full_name',
            'avatar',
            'gender',
            'current_streak',
            'longest_streak',
            'coins',
            'created_at',
        ])->get();
    }

    /**
     * Search users by username
     *
     * @param string $username
     * @param int $limit
     * @return Collection
     */
    public function searchUsersByUsername(string $username, int $limit = 10): Collection
    {
        return User::query()
            ->where('user_id', '!=', Auth::id())
            ->where('username', 'like', '%' . $username . '%')
            ->select([
                'user_id',
                'username',
                'email',
                'full_name',
            ])
            ->limit($limit)
            ->get();
    }
}