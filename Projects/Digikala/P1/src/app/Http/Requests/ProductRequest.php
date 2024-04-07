<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed providerId
 */
class ProductRequest extends FormRequest
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
            'title' =>  ['sometimes', 'max:255'],
            'sort_column' => ['sometimes', 'max:255', 'in:id,title,created_at,updated_at'],
            'is_sort_dir_desc' => ['sometimes'],
            'per_page' => ['sometimes', 'integer', 'min:5']
        ];
        $rules['post'] =[
            'title' => ['required', Rule::unique('products')->where('provider_id', $this->provider_id), 'min:2', 'max:255'],
            'provider_id' => ['required', 'exists:providers,id', 'integer']
        ];
        $rules['put'] =[
            'title' => ['required', Rule::unique('products')->ignore($this->id)->where('provider_id', $this->provider_id), 'min:2', 'max:255'],
            'provider_id' => ['required', 'exists:providers,id', 'integer']
        ];

        return  $rules[strtolower($this->method())];
    }
}
