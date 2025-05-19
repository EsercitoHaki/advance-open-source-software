<?php

namespace App\Services;

use App\Repositories\Interfaces\MissionRepositoryInterface;
use App\DTOs\MissionDTO;
use App\Models\Mission;
use App\Services\Interfaces\MissionServiceInterface;

class MissionService implements MissionServiceInterface
{
    private MissionRepositoryInterface $repository;

    public function __construct(MissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        return array_map(fn($mission) => MissionDTO::fromModel($mission), $this->repository->getAll());
    }

    public function getById(int $id): MissionDTO
    {
        return MissionDTO::fromModel($this->repository->getById($id));
    }

    public function create(array $data): MissionDTO
    {
        $mission = $this->repository->create($data);
        return MissionDTO::fromModel($mission);
    }

    public function update(int $id, array $data): MissionDTO
    {
        $mission = $this->repository->update($id, $data);
        return MissionDTO::fromModel($mission);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}