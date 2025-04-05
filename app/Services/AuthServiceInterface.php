<?php

namespace App\Services;

use App\DTOs\AuthDTO;

interface AuthServiceInterface
{
    public function register(AuthDTO $authDTO);
    public function login(AuthDTO $authDTO);
    public function getAuthenticatedUser();
    public function logout();
    public function refreshToken();
}