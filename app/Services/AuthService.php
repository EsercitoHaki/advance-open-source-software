<?php

namespace App\Services;

use App\Services\AuthServiceInterface;
use App\Repositories\AuthRepositoryInterface;
use App\DTOs\AuthDTO;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    protected $authRepository;
    
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    
    public function register(AuthDTO $authDTO)
    {
        $userData = $authDTO->toArray();
        $user = $this->authRepository->create($userData);
        
        return [
            'message' => 'User registered successfully',
            'user' => $user
        ];
    }
    
    public function login(AuthDTO $authDTO)
    {
        $user = $this->authRepository->findByEmail($authDTO->email);
        
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