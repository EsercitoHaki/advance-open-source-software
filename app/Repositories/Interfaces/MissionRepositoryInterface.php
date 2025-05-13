<?php

namespace App\Repositories\Interfaces;

use App\Models\Mission;

interface MissionRepositoryInterface
{
    public function getAll(): array;
    public function getById(int $id): Mission;
    public function create(array $data): Mission;
    public function update(int $id, array $data): Mission;
    public function delete(int $id): void;
}
