<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\FriendService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Exceptions\DataNotFoundException;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\FriendRequest;

class FriendController extends Controller
{
    /**
     * @var FriendService
     */
    protected $friendService;

    /**
     *
     * @param FriendService $friendService
     */
    public function __construct(FriendService $friendService)
    {
        $this->friendService = $friendService;
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendFriendRequest(Request $request): JsonResponse
    {
        $user = auth()->user();

        // Prevent sending friend request to yourself
        if ($request->receiver_id === $user->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không thể gửi lời mời kết bạn cho chính mình.'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|string|exists:users,user_id'
        ], [
            'receiver_id.exists' => 'Người dùng không tồn tại.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $existingRequest = FriendRequest::where('sender_id', $user->user_id)
            ->where('receiver_id', $request->receiver_id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã gửi lời mời kết bạn cho người này trước đó.'
            ], 422);
        }

        $result = $this->friendService->sendFriendRequest($request->receiver_id);

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     *
     * @param string $requestId
     * @return JsonResponse
     */
    public function acceptFriendRequest(string $requestId): JsonResponse
    {
        $result = $this->friendService->acceptFriendRequest($requestId);

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     *
     * @param string $requestId
     * @return JsonResponse
     */
    public function rejectFriendRequest(string $requestId): JsonResponse
    {
        $result = $this->friendService->rejectFriendRequest($requestId);

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     *
     * @return JsonResponse
     */
    public function getPendingRequests(): JsonResponse
    {
        $result = $this->friendService->getPendingFriendRequests();

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     *
     * @return JsonResponse
     */
    public function getSentRequests(): JsonResponse
    {
        $result = $this->friendService->getSentFriendRequests();

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     *
     * @return JsonResponse
     */
    public function getFriendsList(): JsonResponse
    {
        $result = $this->friendService->getFriendsList();

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     *
     * @param string $friendId
     * @return JsonResponse
     */
    public function removeFriend(string $friendId): JsonResponse
    {
        $result = $this->friendService->removeFriend($friendId);

        return response()->json($result, $result['success'] ? 200 : 400);
    }
}
