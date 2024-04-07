<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed providerId
 */
class ProviderRequest extends FormRequest
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
            'title' => ['required', Rule::unique('providers', 'title'), 'min:2', 'max:255'],
        ];
        $rules['put'] =[
            'title' => ['required', Rule::unique('providers', 'title')->ignore($this->providerId), 'min:2', 'max:255'],
        ];
        return  $rules[strtolower($this->method())];
    }
}
