<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\UserService;
use App\DTOs\UserDTO;
use App\Exceptions\DataNotFoundException;
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
        try {
            $user = $this->userService->getCurrentUser();
            
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Không tìm thấy thông tin người dùng',
            ], 404);
        } 
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $userDTO = UserDTO::fromRequest($request);
            $updatedUser = $this->userService->updateProfile($userDTO);
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông tin thành công',
                'data' => $updatedUser
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Không tìm thấy người dùng để cập nhật',
            ], 404);
        }
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try
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
        catch (DataNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Không tìm thấy thông tin người dùng',
            ], 404);
        }
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
                'avatar_url' => asset('storage/' . $avatarPath),
                'avatar_path' => $avatarPath,
            ]
        ]);
    }

    public function getStats(): JsonResponse
    {
        try {
            $stats = $this->userService->getUserStats();
            
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (DataNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Không tìm thấy dữ liệu thống kê',
            ], 404);
        }
    }
}