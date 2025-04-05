<?php

namespace App\Services;

use App\Services\AuthServiceInterface;
use App\Repositories\UserRepositoryInterface;
use App\DTOs\AuthDTO;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    protected $userRepository;
    
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function register(AuthDTO $authDTO)
    {
        $userData = $authDTO->toArray();
        $user = $this->userRepository->create($userData);
        
        return [
            'message' => 'User registered successfully',
            'user' => $user
        ];
    }
    
    public function login(AuthDTO $authDTO)
    {
        $user = $this->userRepository->findByEmail($authDTO->email);
        
        if (!$user || !Hash::check($authDTO->password, $user->password)) {
            return [
                'error' => 'Invalid credentials',
                'status' => 401
            ];
        }
        
        $token = JWTAuth::fromUser($user);
        
        if (!$token) {
            return [
                'error' => 'Could not create token',
                'status' => 500
            ];
        }
        
        return [
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
            'status' => 200
        ];
    }
    
    public function getAuthenticatedUser()
    {
        return JWTAuth::user();
    }
    
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return ['message' => 'Successfully logged out'];
    }
    
    public function refreshToken()
    {
        return [
            'token' => JWTAuth::refresh(JWTAuth::getToken())
        ];
    }
}