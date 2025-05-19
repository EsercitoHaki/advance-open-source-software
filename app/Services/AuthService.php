<?php

namespace App\Services;

use App\Services\AuthServiceInterface;
use App\Repositories\AuthRepositoryInterface;
use App\DTOs\AuthDTO;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\DataNotFoundException;

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

        $user = $this->authRepository->findByEmail($authDTO->email);
        
        if (!$user || !Hash::check($authDTO->password, $user->password)) {
            throw new DataNotFoundException('Tài khoản hoặc mật khẩu không đúng!');
        }

        $token = JWTAuth::fromUser($user);
        
        if (!$token) {
            return [
                'error' => 'Không thể tạo được token!',
                'status' => 500
            ];
        }

        return [
            'message' => 'Đăng ký thành công!',
            'token' => $token,
            'user' => $user
        ];
    }
    
    public function login(AuthDTO $authDTO)
    {
        $user = $this->authRepository->findByEmail($authDTO->email);
        
        if (!$user || !Hash::check($authDTO->password, $user->password)) {
            throw new DataNotFoundException('Tài khoản hoặc mật khẩu không đúng!');
        }
        
        $token = JWTAuth::fromUser($user);
        
        if (!$token) {
            return [
                'error' => 'Không thể tạo được token!',
                'status' => 500
            ];
        }
        
        return [
            'message' => 'Đăng nhập thành công!',
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
        $newToken = JWTAuth::parseToken()->refresh();
        return [
            'token' => $newToken,
            'user' => JWTAuth::setToken($newToken)->toUser()
        ];
    }
}