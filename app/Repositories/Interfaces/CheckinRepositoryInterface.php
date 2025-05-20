<?php

namespace App\Repositories\Interfaces;

use App\DTOs\CheckInDTO;
use App\Models\CheckIn;
use App\Models\User;
use Illuminate\Support\Collection;


interface CheckInRepositoryInterface
{
    public function create(CheckInDTO|array $data): CheckIn;
    public function getCheckInHistory(User $user): Collection;
    public function getCheckInDateHistory(User $user): Collection;
}
