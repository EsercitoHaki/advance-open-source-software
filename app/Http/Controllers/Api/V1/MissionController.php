<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MissionRequest;
use App\Services\Interfaces\MissionServiceInterface;
use App\Repositories\MissionRepository;

class MissionController extends Controller
{
    private MissionServiceInterface $missionService;

    public function __construct(MissionServiceInterface $missionService)
    {
        $this->missionService = $missionService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->missionService->getAll());
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->missionService->getById($id));
    }

    public function store(MissionRequest $request): JsonResponse
    {
        return response()->json($this->missionService->create($request->validated()));
    }

    public function update(MissionRequest $request, $id): JsonResponse
    {
        return response()->json($this->missionService->update($id, $request->validated()));
    }

    public function destroy($id): JsonResponse
    {
        $this->missionService->delete($id);
        return response()->json(['message' => 'Xóa thành công!']);
    }
}
