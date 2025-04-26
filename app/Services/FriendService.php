<?php

namespace App\Services;

use App\Repositories\FriendRepositoryInterface;
use App\Repositories\FriendRequestRepositoryInterface;
use App\DTOs\UserDTO;
use App\Exceptions\InvalidParamException;
use App\Exceptions\PremissionDenyException;
use Illuminate\Support\Facades\Auth;

class FriendService
{
    /**
     * @var FriendRepositoryInterface
     */
    protected $friendRepository;

    /**
     * @var FriendRequestRepositoryInterface
     */
    protected $friendRequestRepository;

    /**
     * FriendService constructor.
     *
     * @param FriendRepositoryInterface $friendRepository
     * @param FriendRequestRepositoryInterface $friendRequestRepository
     */
    public function __construct(
        FriendRepositoryInterface $friendRepository,
        FriendRequestRepositoryInterface $friendRequestRepository
    ) {
        $this->friendRepository = $friendRepository;
        $this->friendRequestRepository = $friendRequestRepository;
    }

    /**
     * Send a friend request
     *
     * @param string $receiverId
     * @return array
     */
    public function sendFriendRequest(string $receiverId): array
    {
        $user = Auth::user();

        try {
            $request = $this->friendRequestRepository->sendFriendRequest($user->user_id, $receiverId);

            return [
                'success' => true,
                'message' => 'Gửi lời mời kết bạn thành công',
                'data' => [
                    'request_id' => $request->friend_request_id,
                    'status' => $request->status
                ]
            ];
        } catch (InvalidParamException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Accept a friend request
     *
     * @param string $requestId
     * @return array
     */
    public function acceptFriendRequest(string $requestId): array
    {
        $user = Auth::user();
        $request = $this->friendRequestRepository->findFriendRequestById($requestId);

        if (!$request) {
            return [
                'success' => false,
                'message' => 'Lời mời kết bạn không tồn tại'
            ];
        }

        // Check if current user is the receiver of the request
        if ($request->receiver_id !== $user->user_id) {
            return [
                'success' => false,
                'message' => 'Bạn không có quyền chấp nhận lời mời này'
            ];
        }

        try {
            $this->friendRequestRepository->acceptFriendRequest($requestId);

            return [
                'success' => true,
                'message' => 'Lời mời kết bạn đã được chấp nhận thành công',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Reject a friend request
     *
     * @param string $requestId
     * @return array
     */
    public function rejectFriendRequest(string $requestId): array
    {
        $user = Auth::user();
        $request = $this->friendRequestRepository->findFriendRequestById($requestId);

        if (!$request) {
            return [
                'success' => false,
                'message' => 'Lời mời kết bạn không tồn tại'
            ];
        }

        // Check if current user is the receiver of the request
        if ($request->receiver_id !== $user->user_id) {
            return [
                'success' => false,
                'message' => 'You are not authorized to reject this request'
            ];
        }

        try {
            $this->friendRequestRepository->rejectFriendRequest($requestId);

            return [
                'success' => true,
                'message' => 'Lời mời kết bạn đã từ chối thành công',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get pending friend requests
     *
     * @return array
     */
    public function getPendingFriendRequests(): array
    {
        $user = Auth::user();
        $requests = $this->friendRequestRepository->getReceivedFriendRequests($user->user_id);

        $formattedRequests = $requests->map(function ($request) {
            return [
                'request_id' => $request->friend_request_id,
                'sender' => [
                    'user_id' => $request->sender->user_id,
                    'username' => $request->sender->username,
                    'full_name' => $request->sender->full_name,
                    'avatar' => $request->sender->avatar
                ],
                'created_at' => $request->created_at
            ];
        });

        return [
            'success' => true,
            'data' => [
                'requests' => $formattedRequests
            ]
        ];
    }

    /**
     * Get sent friend requests
     *
     * @return array
     */
    public function getSentFriendRequests(): array
    {
        $user = Auth::user();
        $requests = $this->friendRequestRepository->getSentFriendRequests($user->user_id);

        $formattedRequests = $requests->map(function ($request) {
            return [
                'request_id' => $request->friend_request_id,
                'receiver' => [
                    'user_id' => $request->receiver->user_id,
                    'username' => $request->receiver->username,
                    'full_name' => $request->receiver->full_name,
                    'avatar' => $request->receiver->avatar
                ],
                'created_at' => $request->created_at
            ];
        });

        return [
            'success' => true,
            'data' => [
                'requests' => $formattedRequests
            ]
        ];
    }

    /**
     * Get user's friends list
     *
     * @return array
     */
    public function getFriendsList(): array
    {
        $user = Auth::user();
        $friends = $this->friendRepository->getUserFriends($user->user_id);

        $formattedFriends = $friends->map(function ($friend) {
            return [
                'user_id' => $friend->user_id,
                'username' => $friend->username,
                'full_name' => $friend->full_name,
                'avatar' => $friend->avatar
            ];
        });

        return [
            'success' => true,
            'data' => [
                'friends' => $formattedFriends
            ]
        ];
    }

    /**
     * Remove a friend
     *
     * @param string $friendId
     * @return array
     */
    public function removeFriend(string $friendId): array
    {
        $user = Auth::user();

        try {
            $result = $this->friendRepository->removeFriendship($user->user_id, $friendId);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Xóa bạn bè thành công',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Bạn không phải bạn bè với người này'
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}