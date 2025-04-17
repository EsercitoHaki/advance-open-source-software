<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthServiceInterface;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\ExpiredTokenException;
use App\DTOs\AuthDTO;

class AuthController extends Controller
{
    protected $authService;
    
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }
    
    public function register(RegisterRequest $request)
    {
        try
        {
            $authDTO = AuthDTO::formArray($request->validated());
            $result = $this->authService->register($authDTO);

            return response()->json($result, 201);
        } catch (DataNotFoundException $e)
        {
            return response()->json([
                'error' => true,
                'message' => 'Không tìm thấy dữ liệu',
            ], 404);
        }
    }
    
    public function login(LoginRequest $request)
    {
        try
        {
            $authDTO = AuthDTO::formArray($request->validated());
            $result = $this->authService->login($authDTO);
        
            $statusCode = $result['status'] ?? 200;
            unset($result['status']);
        
            return response()->json($result, $statusCode);
        }
        catch (DataNotFoundException $e)
        {
            return response()->json([
                'error' => true,
                'message' => 'Không tìm thấy dữ liệu người dùng',
            ], 404);
        }
    }
    
    public function logout()
    {
        try {
            $result = $this->authService->logout();
            return response()->json($result);
        } catch (ExpiredTokenException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Phiên đăng nhập đã hết hạn',
            ], 401);
        }
    }
    
    public function refresh()
    {
        try {
            $result = $this->authService->refreshToken();
            return response()->json($result);
        } catch (ExpiredTokenException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Token đã hết hạn, vui lòng đăng nhập lại',
            ], 401);
        }
    }
}