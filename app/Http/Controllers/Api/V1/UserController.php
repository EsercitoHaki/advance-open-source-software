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
        try {
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
        } catch (DataNotFoundException $e) {
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
    /**
     * Get all users with optional username search for friend requests
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllUsers(Request $request): JsonResponse
    {
        try {
            $username = $request->query('username');
            $users = $this->userService->getAllUsers($username);

            return response()->json([
                'success' => true,
                'message' => 'Lấy danh sách người dùng thành công',
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Có lỗi xảy ra khi lấy danh sách người dùng: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Search users by username for friend requests
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function searchUsers(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'username' => 'required|string|min:1',
                'limit' => 'nullable|integer|min:1|max:50'
            ]);

            $username = $request->query('username');
            $limit = $request->query('limit', 10);

            $users = $this->userService->searchUsersByUsername($username, $limit);

            return response()->json([
                'success' => true,
                'message' => 'Tìm kiếm người dùng thành công',
                'data' => $users
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Có lỗi xảy ra khi tìm kiếm người dùng: ' . $e->getMessage(),
            ], 500);
        }
    }
}