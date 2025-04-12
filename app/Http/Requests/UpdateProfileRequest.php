<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $user = Auth::user();
        
        return [
            'username' => 'string|max:50|unique:users,username,' . $user->user_id . ',user_id',
            'email' => 'email|max:100|unique:users,email,' . $user->user_id . ',user_id',
            'first_name' => 'string|max:50|nullable',
            'last_name' => 'string|max:50|nullable',
        ];
    }

    public function messages()
    {
        return [
            'username.string' => 'Tên đăng nhập phải là chuỗi.',
            'username.max' => 'Tên đăng nhập không được vượt quá 50 ký tự.',
            'username.unique' => 'Tên đăng nhập đã được sử dụng.',

            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 100 ký tự.',
            'email.unique' => 'Email đã được sử dụng.',

            'first_name.string' => 'Họ phải là chuỗi.',
            'first_name.max' => 'Họ không được vượt quá 50 ký tự.',

            'last_name.string' => 'Tên phải là chuỗi.',
            'last_name.max' => 'Tên không được vượt quá 50 ký tự.',
        ];
    }
}
