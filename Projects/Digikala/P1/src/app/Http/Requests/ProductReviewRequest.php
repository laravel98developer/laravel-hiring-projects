<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed providerId
 */
class ProductReviewRequest extends FormRequest
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
            'sort_column' => ['sometimes', 'max:255', 'in:id,vote_avg,review_count,created_at,updated_at'],
            'is_sort_dir_desc' => ['sometimes'],
            'per_page' => ['sometimes', 'integer', 'min:5']
        ];

        $rules['post'] =[
            'product_id' => ['required', 'exists:products,id', 'integer'],
            'only_user_that_bought_product' => ['required', 'boolean'],
            'is_reviewable' => ['required', 'boolean'],
        ];

        return  $rules[strtolower($this->method())];
    }
}
