<?php

namespace App\Repositories;

use App\Models\FriendRequest;
use App\Models\Friend;
use App\Exceptions\InvalidParamException;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use App\Repositories\Interfaces\FriendRequestRepositoryInterface;
use Illuminate\Support\Facades\DB;

class FriendRequestRepository extends BaseRepository implements FriendRequestRepositoryInterface
{
    /**
     * @var FriendRepositoryInterface
     */
    protected $friendRepository;

    /**
     * FriendRequestRepository constructor.
     *
     * @param FriendRequest $model
     * @param FriendRepositoryInterface $friendRepository
     */
    public function __construct(FriendRequest $model, FriendRepositoryInterface $friendRepository)
    {
        parent::__construct($model);
        $this->friendRepository = $friendRepository;
    }

    /**
     * Send a friend request from one user to another
     *
     * @param string $senderId
     * @param string $receiverId
     * @return FriendRequest
     * @throws InvalidParamException
     */
    public function sendFriendRequest(string $senderId, string $receiverId): FriendRequest
    {
        // Check if sender and receiver are the same user
        if ($senderId === $receiverId) {
            throw new InvalidParamException('Không thể gửi lời mời kết bạn cho chính mình');
        }

        // Check if they are already friends
        if ($this->friendRepository->checkFriendshipExists($senderId, $receiverId)) {
            throw new InvalidParamException('Bạn đã là bạn bè với người này');
        }

        // Check if a friend request already exists
        if ($this->checkFriendRequestExists($senderId, $receiverId)) {
            throw new InvalidParamException('Lời mời kết bạn đã được gửi trước đó');
        }

        // Check if there's a pending request in the opposite direction
        $existingRequest = FriendRequest::where('sender_id', $receiverId)
            ->where('receiver_id', $senderId)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            throw new InvalidParamException('Bạn đã nhận lời mời kết bạn từ người này');
        }

        // Create the friend request
        return FriendRequest::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending'
        ]);
    }

    /**
     * Get all friend requests received by a user
     *
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReceivedFriendRequests(string $userId)
    {
        return FriendRequest::where('receiver_id', $userId)
            ->where('status', 'pending')
            ->with('sender')
            ->get();
    }

    /**
     * Get all friend requests sent by a user
     *
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSentFriendRequests(string $userId)
    {
        return FriendRequest::where('sender_id', $userId)
            ->where('status', 'pending')
            ->with('receiver')
            ->get();
    }

    /**
     * Accept a friend request
     *
     * @param string $requestId
     * @return bool
     * @throws InvalidParamException
     */
    public function acceptFriendRequest(string $requestId): bool
    {
        $request = $this->findFriendRequestById($requestId);

        if (!$request) {
            throw new InvalidParamException('Không tìm thấy lời mời kết bạn');
        }

        if ($request->status !== 'pending') {
            throw new InvalidParamException('Lời mời kết bạn đã được xử lý trước đó');
        }

        DB::beginTransaction();
        try {
            // Update request status
            $request->status = 'accepted';
            $request->save();

            // Create friendship
            $this->friendRepository->createFriendship($request->sender_id, $request->receiver_id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reject a friend request
     *
     * @param string $requestId
     * @return bool
     * @throws InvalidParamException
     */
    public function rejectFriendRequest(string $requestId): bool
    {
        $request = $this->findFriendRequestById($requestId);

        if (!$request) {
            throw new InvalidParamException('Không tìm thấy lời mời kết bạn');
        }

        if ($request->status !== 'pending') {
            throw new InvalidParamException('Lời mời kết bạn đã được xử lý trước đó');
        }

        // Delete the friend request instead of updating its status
        return $request->delete();
    }

    /**
     * Find a friend request by ID
     *
     * @param string $requestId
     * @return FriendRequest|null
     */
    public function findFriendRequestById(string $requestId): ?FriendRequest
    {
        return FriendRequest::find($requestId);
    }

    /**
     * Check if a friend request already exists between users
     *
     * @param string $senderId
     * @param string $receiverId
     * @return bool
     */
    public function checkFriendRequestExists(string $senderId, string $receiverId): bool
    {
        return FriendRequest::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Find a pending friend request between two users
     *
     * @param string $senderId
     * @param string $receiverId
     * @return FriendRequest|null
     */
    public function findPendingRequest(string $senderId, string $receiverId): ?FriendRequest
    {
        return FriendRequest::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->where('status', 'pending')
            ->first();
    }

    /**
     * Find a reverse pending friend request (from receiver to sender)
     *
     * @param string $senderId
     * @param string $receiverId
     * @return FriendRequest|null
     */
    public function findReversePendingRequest(string $senderId, string $receiverId): ?FriendRequest
    {
        return FriendRequest::where('sender_id', $receiverId)
            ->where('receiver_id', $senderId)
            ->where('status', 'pending')
            ->first();
    }
}