<?php

namespace App\Repositories;

use App\Models\Friend;
use App\Models\User;
use App\Models\FriendRequest;
use App\Exceptions\InvalidParamException;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use Illuminate\Support\Facades\DB;

class FriendRepository extends BaseRepository implements FriendRepositoryInterface
{
    /**
     * FriendRepository constructor.
     *
     * @param Friend $model
     */
    public function __construct(Friend $model)
    {
        parent::__construct($model);
    }

    /**
     * Create a friendship between two users
     *
     * @param string $user1Id
     * @param string $user2Id
     * @return Friend
     * @throws InvalidParamException
     */
    public function createFriendship(string $user1Id, string $user2Id): Friend
    {
        // Check if users exist
        $user1Exists = User::where('user_id', $user1Id)->exists();
        $user2Exists = User::where('user_id', $user2Id)->exists();

        if (!$user1Exists || !$user2Exists) {
            throw new InvalidParamException('One or both users do not exist');
        }

        // Check if they are already friends
        if ($this->checkFriendshipExists($user1Id, $user2Id)) {
            throw new InvalidParamException('Users are already friends');
        }

        // Create the friendship (always store with the lower user_id as user1_id to simplify lookup)
        return Friend::create([
            'user1_id' => min($user1Id, $user2Id),
            'user2_id' => max($user1Id, $user2Id),
            'created_date' => now()
        ]);
    }

    /**
     * Get all friends of a user
     *
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserFriends(string $userId)
    {
        $friendshipsAsUser1 = Friend::where('user1_id', $userId)
            ->with('user2')
            ->get();

        $friendshipsAsUser2 = Friend::where('user2_id', $userId)
            ->with('user1')
            ->get();

        $friends = collect();

        foreach ($friendshipsAsUser1 as $friendship) {
            $friends->push($friendship->user2);
        }

        foreach ($friendshipsAsUser2 as $friendship) {
            $friends->push($friendship->user1);
        }

        return $friends;
    }

    /**
     * Check if two users are friends
     *
     * @param string $user1Id
     * @param string $user2Id
     * @return bool
     */
    public function checkFriendshipExists(string $user1Id, string $user2Id): bool
    {
        $minId = min($user1Id, $user2Id);
        $maxId = max($user1Id, $user2Id);

        return Friend::where('user1_id', $minId)
            ->where('user2_id', $maxId)
            ->exists();
    }

    /**
     *
     * @param string $user1Id
     * @param string $user2Id
     * @return bool
     */
    public function removeFriendship(string $user1Id, string $user2Id): bool
    {
        $result = false;

        DB::beginTransaction();
        try {
            $minId = min($user1Id, $user2Id);
            $maxId = max($user1Id, $user2Id);

            // Delete the friendship
            $friendship = Friend::where('user1_id', $minId)
                ->where('user2_id', $maxId)
                ->first();

            if ($friendship) {
                $friendship->delete();
                $result = true;
            }

            // Delete any friend requests between these users (in both directions)
            FriendRequest::where(function ($query) use ($user1Id, $user2Id) {
                $query->where('sender_id', $user1Id)
                    ->where('receiver_id', $user2Id);
            })->orWhere(function ($query) use ($user1Id, $user2Id) {
                $query->where('sender_id', $user2Id)
                    ->where('receiver_id', $user1Id);
            })->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $result;
    }

    /**
     *
     * @param string $userId
     * @return User|null
     */
    public function findUserById(string $userId): ?User
    {
        return User::where('user_id', $userId)->first();
    }

    /**
     *
     * @param string $user1Id
     * @param string $user2Id
     * @return bool
     */
    public function areFriends(string $user1Id, string $user2Id): bool
    {
        return $this->checkFriendshipExists($user1Id, $user2Id);
    }
}