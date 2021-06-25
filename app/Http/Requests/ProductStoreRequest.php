<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => ['required'],
            'name' => ['required', 'string'],
            'expire_at' => ['required'],
            'initial_price' => ['required', 'numeric'],
            'closing_price' => ['required', 'numeric'],
            'bid_credit' => ['required', 'numeric'],
            'min_increment' => ['required', 'numeric'],
            'image' => ['required', 'array', 'max:4'],
            'image.*' => ['image', 'mimes:jpg,jpeg,png']
        ];
    }
}
