<?php

namespace App\Repositories\Interfaces;

use App\Models\Mission;
use Illuminate\Support\Collection;

interface MissionRepositoryInterface
{
    public function getAll(): array;
    public function getById(int $id): Mission;
    public function create(array $data): Mission;
    public function update(int $id, array $data): Mission;
    public function delete(int $id): void;
    public function getRandomActiveMissions(int $limit): Collection;
}
