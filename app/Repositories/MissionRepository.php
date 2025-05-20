<?php

namespace App\Repositories;

use App\Models\Mission;
use App\Repositories\Interfaces\MissionRepositoryInterface;

class MissionRepository implements MissionRepositoryInterface
{
    public function getAll(): array
    {
        return Mission::all()->all();
    }

    public function getById(int $id): Mission
    {
        return Mission::findOrFail($id);
    }

    public function create(array $data): Mission
    {
        return Mission::create($data);
    }

    public function update(int $id, array $data): Mission
    {
        $mission = Mission::findOrFail($id);
        $mission->update($data);
        return $mission;
    }

    public function delete(int $id): void
    {
        $mission = Mission::findOrFail($id);
        $mission->delete();
    }
}
