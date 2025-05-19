<?php
namespace App\Repositories\Interfaces;

interface LeaderboardRepositoryInterface
{
    public function getLeaderboard(int $limit = 10, int $page = 1);
    public function getUserRank(string $userId);
    public function getTotalUsers();
}