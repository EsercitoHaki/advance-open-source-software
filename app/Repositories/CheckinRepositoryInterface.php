<?php

namespace App\Repositories;

use App\DTOs\CheckInDTO;
use App\Models\CheckIn;

interface CheckInRepositoryInterface
{
    public function create(CheckInDTO|array $data): CheckIn;
}
