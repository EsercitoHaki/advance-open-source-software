<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'item_id' => 'required|integer|exists:store_items,item_id',
        ];
    }

    public function messages()
    {
        return [
            'item_id.required' => 'Bạn phải chọn một item để mua.',
            'item_id.integer' => 'ID item không hợp lệ.',
            'item_id.exists' => 'Item không tồn tại trong cửa hàng.',
        ];
    }
}