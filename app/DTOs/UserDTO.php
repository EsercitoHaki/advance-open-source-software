<?php

namespace App\DTOs;

class UserDTO 
{
    public function __construct(
        public ?string $username,
        public ?string $email,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $avatar = null,
        public ?int $roleId = null,
        public ?int $coins = null,
        public ?int $lives = null,
        public ?int $currentStreak = null,
        public ?int $longestStreak = null,
        public ?bool $isActive = null
    ){}

    /**
     * Tạo một đối tượng DTO mới từ yêu cầu cập nhật hồ sơ.
     *
     * @param UpdateProfileRequest $request
     * @return self
     */

    public static function fromRequest(UpdateProfileRequest $request): self
    {
        return new self(
            username: $request->get('username'),
            email: $request->get('email'),
            firstname: $request->get('first_name'),
            lastname: $request->get('last_name')
        );
    }

    /**
     * Tạo một đối tượng DTO mới từ mô hình User.
     *
     * @param User $user
     * @return self
     */

    public static function fromModel($user): self
    {
        return new self(
            username: $user->username,
            email: $user->email,
            firstName: $user->first_name,
            lastName: $user->last_name,
            avatar: $user->avatar,
            roleId: $user->role_id,
            coins: $user->coins,
            lives: $user->lives,
            currentStreak: $user->current_streak,
            longestStreak: $user->longest_streak,
            isActive: $user->is_active
        );
    }

    /**
     * Chuyển đổi đối tượng DTO thành mảng.
     *
     * @return array
     */

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'avatar' => $this->avatar,
            'role_id' => $this->roleId,
            'coins' => $this->coins,
            'lives' => $this->lives,
            'current_streak' => $this->currentStreak,
            'longest_streak' => $this->longestStreak,
            'is_active' => $this->isActive,
        ];
    }
}