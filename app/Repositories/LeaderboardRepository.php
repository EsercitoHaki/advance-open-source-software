<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Leaderboard;
use App\Models\UserProgress;
use App\Repositories\Interfaces\LeaderboardRepositoryInterface;
use Illuminate\Support\Facades\DB;

class LeaderboardRepository implements LeaderboardRepositoryInterface
{
    public function getLeaderboard(int $limit = 10, int $page = 1)
    {
        $offset = ($page - 1) * $limit;

        return DB::table('users')
            ->select(
                'users.user_id',
                'users.username',
                'users.full_name',
                'users.avatar',
                'leaderboard.rank',
                DB::raw('SUM(user_progress.score) as total_score')
            )
            ->leftJoin('leaderboard', 'users.user_id', '=', 'leaderboard.user_id')
            ->leftJoin('user_progress', 'users.user_id', '=', 'user_progress.user_id')
            ->where('users.is_active', true)
            ->groupBy('users.user_id', 'users.username', 'users.full_name', 'users.avatar', 'leaderboard.rank')
            ->orderBy('total_score', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    public function getUserRank(string $userId)
    {
        $userRankSubquery = DB::table('users')
            ->select(
                'users.user_id',
                'users.username',
                'users.full_name',
                'users.avatar',
                'leaderboard.rank',
                DB::raw('SUM(user_progress.score) as total_score'),
                DB::raw('RANK() OVER (ORDER BY SUM(user_progress.score) DESC) as position')
            )
            ->leftJoin('leaderboard', 'users.user_id', '=', 'leaderboard.user_id')
            ->leftJoin('user_progress', 'users.user_id', '=', 'user_progress.user_id')
            ->where('users.is_active', true)
            ->groupBy('users.user_id', 'users.username', 'users.full_name', 'users.avatar', 'leaderboard.rank');
            
        return DB::table(DB::raw("({$userRankSubquery->toSql()}) as ranked_users"))
            ->mergeBindings($userRankSubquery)
            ->where('user_id', $userId)
            ->first();
    }

    public function getTotalUsers()
    {
        return User::where('is_active', true)->count();
    }
}