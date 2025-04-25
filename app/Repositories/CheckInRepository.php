<?php 

namespace App\Repositories;

use App\Models\CheckIn;
use Carbon\Carbon;

class CheckInRepository
{
    public function hasCheckedInToday($userId)
    {
        return CheckIn::where('user_id', $userId)
                      ->whereDate('check_in_date', Carbon::today())
                      ->exists();
    }

    public function createCheckIn($userId, $coins = 10)
    {
        return CheckIn::create([
            'user_id' => $userId,
            'check_in_date' => Carbon::today(),
            'coins_earned' => $coins
        ]);
    }
}

?>