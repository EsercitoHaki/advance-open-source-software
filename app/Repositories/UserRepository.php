<?php

namespace App\Repositories;

use App\Models\User;
use App\DTOs\UserDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'avatar'
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

    public function getUsersWithTotalScore()
    {
        return User::select('users.user_id', 'users.username', 'users.avatar', DB::raw('COALESCE(SUM(user_progress.score), 0) as total_score'))
            ->leftJoin('user_progress', 'users.user_id', '=', 'user_progress.user_id')
            ->groupBy('users.user_id', 'users.username', 'users.avatar')
            ->get();
    }

    public function findUserWithScore(string $userId)
    {
        return User::select('users.user_id', 'users.username', 'users.avatar', DB::raw('COALESCE(SUM(user_progress.score), 0) as total_score'))
            ->leftJoin('user_progress', 'users.user_id', '=', 'user_progress.user_id')
            ->where('users.user_id', $userId)
            ->groupBy('users.user_id', 'users.username', 'users.avatar')
            ->first();
    }

    public function getFriendIds(string $userId): array
    {
        $friends = DB::table('friends')
            ->where(function ($query) use ($userId) {
                $query->where('user1_id', $userId)
                      ->orWhere('user2_id', $userId);
            })
            ->get();

        $friendIds = [];
        foreach ($friends as $friend) {
            if ($friend->user1_id === $userId) {
                $friendIds[] = $friend->user2_id;
            } else {
                $friendIds[] = $friend->user1_id;
            }
        }

        return $friendIds;
    }

    public function getUsersWithScoreByIds(array $userIds): Collection
    {
        return User::select('users.user_id', 'users.username', 'users.avatar', 
                           DB::raw('COALESCE(SUM(user_progress.score), 0) as total_score'))
            ->leftJoin('user_progress', 'users.user_id', '=', 'user_progress.user_id')
            ->whereIn('users.user_id', $userIds)
            ->groupBy('users.user_id', 'users.username', 'users.avatar')
            ->get();
    }
}