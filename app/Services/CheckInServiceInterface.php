<?php

namespace App\Services;

use App\Models\User;
use App\DTOs\CheckInDTO;

interface CheckInServiceInterface
{
    public function checkIn(User $user): CheckInDTO;
    public function getCheckInHistory(User $user): array;
}
