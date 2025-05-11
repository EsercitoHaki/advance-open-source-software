<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Exceptions\DataNotFoundException;
use Illuminate\Support\Facades\Password;
use App\Exceptions\ExpiredTokenException;
use Illuminate\Support\Facades\Hash;
use App\DTOs\AuthDTO;
use Illuminate\Support\Str;

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

    public function sendResetLink(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            // Kiểm tra xem email có tồn tại trong hệ thống không
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'error' => true,
                    'message' => 'Email không tồn tại trong hệ thống'
                ], 404);
            }

            $status = Password::sendResetLink($request->only('email'));

            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'message' => 'Đường dẫn đặt lại mật khẩu đã được gửi vào email của bạn'
                ]);
            }

            return response()->json([
                'error' => true,
                'message' => __($status)
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Có lỗi xảy ra khi gửi email đặt lại mật khẩu',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function reset(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:8',
            ]);

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, $password) {
                    $user->password = Hash::make($password);
                    $user->save();

                    event(new \Illuminate\Auth\Events\PasswordReset($user));
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return response()->json([
                    'message' => 'Đặt lại mật khẩu thành công'
                ]);
            }

            return response()->json([
                'error' => true,
                'message' => __($status)
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Có lỗi xảy ra khi đặt lại mật khẩu',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Trong app/Http/Controllers/Api/V1/Auth/AuthController.php
    public function showResetForm(Request $request, $token)
    {
        // Chuyển hướng đến URL frontend React kèm token và email
        $frontendUrl = config('app.frontend_url') . '/reset-password';
        $queryParams = http_build_query([
            'token' => $token,
            'email' => $request->email
        ]);
        
        return redirect()->away($frontendUrl . '?' . $queryParams);
    }
}