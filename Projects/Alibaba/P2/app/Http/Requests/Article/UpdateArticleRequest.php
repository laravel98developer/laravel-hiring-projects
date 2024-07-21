<?php

namespace App\Http\Requests\Article;


use Illuminate\Foundation\Http\FormRequest;


class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|string',
            'content' => 'nullable|string',
            'file' =>  'nullable|mimes:jpeg,png,bmp'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'title is required!',
            'content.required' => 'content is required!',
            'file.mime' => 'mime should be jpeg or png or jpg'
        ];
    }
}
