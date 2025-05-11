<?php

namespace App\Services;

use App\Repositories\Interfaces\FriendRepositoryInterface;
use App\Repositories\Interfaces\FriendRequestRepositoryInterface;
use App\DTOs\UserDTO;
use App\Exceptions\InvalidParamException;
use App\Exceptions\PremissionDenyException;
use Illuminate\Support\Facades\Auth;

class FriendService
{

    protected $friendRepository;


    protected $friendRequestRepository;


    public function __construct(
        FriendRepositoryInterface $friendRepository,
        FriendRequestRepositoryInterface $friendRequestRepository
    ) {
        $this->friendRepository = $friendRepository;
        $this->friendRequestRepository = $friendRequestRepository;
    }


    public function sendFriendRequest(string $receiverId): array
    {
        $user = Auth::user();

        // Validate before sending request
        // Check if receiver exists
        $receiver = $this->friendRepository->findUserById($receiverId);
        if (!$receiver) {
            return [
                'success' => false,
                'message' => 'Người dùng không tồn tại'
            ];
        }

        // Check if sending request to self
        if ($user->user_id === $receiverId) {
            return [
                'success' => false,
                'message' => 'Bạn không thể gửi lời mời kết bạn cho chính mình'
            ];
        }

        // Check if already friends
        if ($this->friendRepository->areFriends($user->user_id, $receiverId)) {
            return [
                'success' => false,
                'message' => 'Các bạn đã là bạn bè của nhau'
            ];
        }

        // Check if request already exists
        $existingRequest = $this->friendRequestRepository->findPendingRequest($user->user_id, $receiverId);
        if ($existingRequest) {
            return [
                'success' => false,
                'message' => 'Lời mời kết bạn đã được gửi trước đó'
            ];
        }

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
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi lời mời kết bạn'
            ];
        }
    }

    protected function validateFriendRequest(string $requestId): ?array
    {
        $user = Auth::user();
        $request = $this->friendRequestRepository->findFriendRequestById($requestId);

        if (!$request) {
            return [
                'success' => false,
                'message' => 'Lời mời kết bạn không tồn tại'
            ];
        }

        if ($request->receiver_id !== $user->user_id) {
            return [
                'success' => false,
                'message' => 'Bạn không có quyền xử lý lời mời này'
            ];
        }

        return null;
    }

    public function acceptFriendRequest(string $requestId): array
    {
        $validationResult = $this->validateFriendRequest($requestId);
        if ($validationResult !== null) {
            return $validationResult;
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
                'message' => 'Có lỗi xảy ra khi chấp nhận lời mời kết bạn'
            ];
        }
    }

    /**
     *
     * @param string $requestId
     * @return array
     */
    public function rejectFriendRequest(string $requestId): array
    {
        // Validate the request
        $validationResult = $this->validateFriendRequest($requestId);
        if ($validationResult !== null) {
            return $validationResult;
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
                'message' => 'Có lỗi xảy ra khi từ chối lời mời kết bạn'
            ];
        }
    }

    /**
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
     * Cancel a friend request that the user has sent
     *
     * @param string $requestId
     * @return array
     */
    public function cancelFriendRequest(string $requestId): array
    {
        $user = Auth::user();

        try {
            $this->friendRequestRepository->cancelFriendRequest($requestId, $user->user_id);

            return [
                'success' => true,
                'message' => 'Đã xóa lời mời kết bạn thành công'
            ];
        } catch (InvalidParamException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa lời mời kết bạn'
            ];
        }
    }

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


    public function removeFriend(string $friendId): array
    {
        $user = Auth::user();

        // Validate before removing friend
        // Check if friend exists
        $friend = $this->friendRepository->findUserById($friendId);
        if (!$friend) {
            return [
                'success' => false,
                'message' => 'Người dùng không tồn tại'
            ];
        }

        // Check if trying to remove self
        if ($user->user_id === $friendId) {
            return [
                'success' => false,
                'message' => 'Bạn không thể xóa chính mình khỏi danh sách bạn bè'
            ];
        }

        // Check if they are actually friends
        if (!$this->friendRepository->areFriends($user->user_id, $friendId)) {
            return [
                'success' => false,
                'message' => 'Bạn không phải bạn bè với người này'
            ];
        }

        try {
            $result = $this->friendRepository->removeFriendship($user->user_id, $friendId);

            return [
                'success' => true,
                'message' => 'Xóa bạn bè thành công',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa bạn bè'
            ];
        }
    }
}