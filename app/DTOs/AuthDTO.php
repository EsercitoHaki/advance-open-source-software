<?php

namespace App\DTOs;

class AuthDTO {
    public function __construct (
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $username = null,
        public readonly ?string $first_name = null,
        public readonly ?string $last_name = null
    ) {}

    public static function formLoginRequest(array $data): self {
        return new self(
            email: $data['email'],
            password: $data['password'],
            username: $data['username'] ?? null,
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null
        );
    }

    public static function formRegisterRequest(array $data): self {
        return new self(
            email: $data['email'],
            password: $data['password'],
            username: $data['username'] ?? null,
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null
        );
    }

    public function toArray(): array {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ];
    }
}