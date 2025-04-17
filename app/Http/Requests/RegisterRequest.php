<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'full_name'        => 'nullable|string|max:50',
            'email'            => 'required|email|max:100|unique:users',
            'username'         => 'required|string|max:50|unique:users',
            'password'         => 'required|string|min:6|max:32',
            'confirm_password' => 'required|same:password',
            'gender'           => 'nullable|in:male,female,other',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Tên đăng nhập là bắt buộc.',
            'username.string'   => 'Tên đăng nhập phải là chuỗi.',
            'username.max'      => 'Tên đăng nhập không được vượt quá 50 ký tự.',
            'username.unique'   => 'Tên đăng nhập đã tồn tại.',

            'email.required' => 'Email là bắt buộc.',
            'email.email'    => 'Email không hợp lệ.',
            'email.max'      => 'Email không được vượt quá 100 ký tự.',
            'email.unique'   => 'Email đã được sử dụng.',

            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string'   => 'Mật khẩu phải là chuỗi.',
            'password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.max'      => 'Mật khẩu không được vượt quá 32 ký tự.',

            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu.',
            'confirm_password.same'     => 'Mật khẩu xác nhận không khớp.',

            'full_name.string' => 'Họ và tên phải là chuỗi.',
            'full_name.max'    => 'Họ và tên không được vượt quá 50 ký tự.',

            'gender.in' => 'Giới tính phải là male, female hoặc other.',
        ];
    }
}