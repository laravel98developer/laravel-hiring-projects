<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed providerId
 */
class BasketRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules['get'] =[
            'user_id' => ['sometimes', 'integer'],
            'sort_column' => ['sometimes', 'max:255', 'in:id,user_id,created_at,updated_at'],
            'is_sort_dir_desc' => ['sometimes'],
            'per_page' => ['sometimes', 'integer', 'min:5']
        ];
        $rules['post'] =[
            'product_id' => ['required', 'exists:products,id', 'integer'],
            'user_id' => ['required', 'exists:users,id', 'integer']
        ];
        $rules['put'] =[
            'product_id' => ['required', 'exists:products,id', 'integer'],
            'user_id' => ['required', 'exists:users,id', 'integer']
        ];

        return  $rules[strtolower($this->method())];
    }
}
