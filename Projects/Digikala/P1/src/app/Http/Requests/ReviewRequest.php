<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed providerId
 */
class ReviewRequest extends FormRequest
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
            'status' => ['sometimes', 'boolean'],
            'product_id' => ['sometimes', 'exists:products,id'],
            'sort_column' => ['sometimes', 'max:255', 'in:id,status,created_at,updated_at'],
            'is_sort_dir_desc' => ['sometimes'],
            'per_page' => ['sometimes', 'integer', 'min:5']
        ];

        $rules['post'] =[
            'product_id' => ['required', 'exists:products,id', 'integer'],
            'vote' => ['required', 'integer'],
            'comment' => ['required', 'min:10', 'max:800'],
        ];

        $rules['put'] =[
            'status' => ['required', 'boolean'],
        ];

        return  $rules[strtolower($this->method())];
    }
}
