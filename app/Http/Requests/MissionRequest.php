<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'reward_coins' => 'required|integer|min:0',
            'required_action' => 'required|string|max:100',
            'required_count' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ];
    }
}
