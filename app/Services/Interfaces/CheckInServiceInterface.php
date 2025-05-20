<?php

namespace App\Services\Interfaces;

use App\Models\User;
use App\DTOs\CheckInDTO;
use App\Repositories\Interfaces\CheckInRepositoryInterface;

interface CheckInServiceInterface
{
    public function checkIn(User $user): CheckInDTO;
    public function getCheckInHistory(User $user): array;
    public function getCheckInDateHistory(User $user): array;
}
