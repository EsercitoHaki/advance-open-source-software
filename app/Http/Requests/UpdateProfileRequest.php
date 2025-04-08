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
}
