<?php

namespace App\Services\Interfaces;

use App\DTOs\MissionDTO;

interface MissionServiceInterface
{
    public function getAll(): array;
    public function getById(int $id): MissionDTO;
    public function create(array $data): MissionDTO;
    public function update(int $id, array $data): MissionDTO;
    public function delete(int $id): void;
}
