<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\DTOs\UserDTO;
use App\DTOs\UserStatsDTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getCurrentUser(): UserDTO
    {
        return UserDTO::fromModel($this->userRepository->getCurrentUser());
    }

    public function updateProfile(UserDTO $userDTO): UserDTO
    {
        $updatedUser = $this->userRepository->updateProfile($this->userRepository->getCurrentUser(), $userDTO);
        return UserDTO::fromModel($updatedUser);
    }

    public function changePassword(string $currentPassword, string $newPassword): bool
    {
        $user = $this->userRepository->getCurrentUser();

        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }

        return $this->userRepository->updatePassword($user, $newPassword);
    }

    public function uploadAvatar(UploadedFile $avatar): string
    {
        $user = $this->userRepository->getCurrentUser();

        if ($user->avatar !== 'default-avatar.png') {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        $filename = time() . '_' . $user->user_id . '.' . $avatar->getClientOriginalExtension();
        $path = $avatar->storeAs('avatars', $filename, 'public');

        $this->userRepository->updateAvatar($user, $filename);

        return $path;
    }

    public function getUserStats(): UserStatsDTO
    {
        $user = $this->userRepository->getCurrentUser();

        $learningProgress = [
            'completed_lessons' => 0, // Placeholder
            'mastered_words' => 0,    // Placeholder
        ];

        return UserStatsDTO::fromUser($user, $learningProgress);
    }

    public function updateStreak(int $streak, bool $isNewRecord = false): UserDTO
    {
        $user = $this->userRepository->getCurrentUser();

        $updateData = ['current_streak' => $streak];

        if ($isNewRecord && $streak > $user->longest_streak) {
            $updateData['longest_streak'] = $streak;
        }

        $updatedUser = $this->userRepository->updateStats($user, $updateData);

        return UserDTO::fromModel($updatedUser);
    }

    /**
     * Get all users with optional username search
     *
     * @param string|null $username
     * @return array
     */
    public function getAllUsers(?string $username = null): array
    {
        $users = $this->userRepository->getAllUsers($username);

        return $users->map(function ($user) {
            return [
                'user_id' => $user->user_id,
                'username' => $user->username,
                'full_name' => $user->full_name ?? '',
                'avatar' => $user->avatar,
                'email' => $user->email
            ];
        })->toArray();
    }
}
