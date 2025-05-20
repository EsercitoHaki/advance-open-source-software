<?php

namespace App\DTOs;

class AuthDTO {
    public function __construct (
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $username = null,
        public readonly ?string $full_name = null
    ) {}

    public static function formArray(array $data): self {
        return new self(
            email: $data['email'],
            password: $data['password'],
            username: $data['username'] ?? null,
            full_name: $data['full_name'] ?? null,
        );
    }

    public function toArray(): array {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'username' => $this->username,
            'full_name' => $this->full_name,
        ];
    }
}
