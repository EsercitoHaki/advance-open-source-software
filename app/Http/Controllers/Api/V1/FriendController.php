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
     * FriendController constructor.
     *
     * @param FriendService $friendService
     */
    public function __construct(FriendService $friendService)
    {
        $this->friendService = $friendService;
    }

    /**
     * Send a friend request to another user
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
                'message' => 'You cannot send a friend request to yourself.'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|string|exists:users,user_id'
        ], [
            'receiver_id.exists' => 'The specified user does not exist.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Check for existing pending friend request
        $existingRequest = FriendRequest::where('sender_id', $user->user_id)
            ->where('receiver_id', $request->receiver_id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending friend request to this user.'
            ], 422);
        }

        $result = $this->friendService->sendFriendRequest($request->receiver_id);

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Accept a friend request
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
     * Reject a friend request
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
     * Get pending friend requests
     *
     * @return JsonResponse
     */
    public function getPendingRequests(): JsonResponse
    {
        $result = $this->friendService->getPendingFriendRequests();

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    /**
     * Get sent friend requests
     *
     * @return JsonResponse
     */
    public function getSentRequests(): JsonResponse
    {
        $result = $this->friendService->getSentFriendRequests();

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    /**
     * Get user's friends list
     *
     * @return JsonResponse
     */
    public function getFriendsList(): JsonResponse
    {
        $result = $this->friendService->getFriendsList();

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    /**
     * Remove a friend
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
