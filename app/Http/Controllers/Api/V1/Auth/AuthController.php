<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthServiceInterface;
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
        $authDTO = AuthDTO::formArray($request->validated());
        $result = $this->authService->register($authDTO);
        
        return response()->json($result, 201);
    }
    
    public function login(LoginRequest $request)
    {
        $authDTO = AuthDTO::formArray($request->validated());
        $result = $this->authService->login($authDTO);
        
        $statusCode = $result['status'] ?? 200;
        unset($result['status']);
        
        return response()->json($result, $statusCode);
    }
    
    public function getUser()
    {
        $user = $this->authService->getAuthenticatedUser();
        return response()->json($user);
    }
    
    public function logout()
    {
        $result = $this->authService->logout();
        return response()->json($result);
    }
    
    public function refresh()
    {
        $result = $this->authService->refreshToken();
        return response()->json($result);
    }
}