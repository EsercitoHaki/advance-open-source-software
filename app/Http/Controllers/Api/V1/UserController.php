<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\UserService;
use App\DTOs\UserDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function profile(): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $userDTO = UserDTO::fromRequest($request);
        $updatedUser = $this->userService->updateProfile($userDTO);
        
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $updatedUser
        ]);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $result = $this->userService->changePassword(
            $request->get('current_password'),
            $request->get('new_password')
        );
        
        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 400);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $avatarPath = $this->userService->uploadAvatar($request->file('avatar'));
        
        return response()->json([
            'success' => true,
            'message' => 'Avatar uploaded successfully',
            'data' => [
                'avatar_path' => $avatarPath
            ]
        ]);
    }

    public function getStats(): JsonResponse
    {
        $stats = $this->userService->getUserStats();
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}