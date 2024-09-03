<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexActivityRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255', // The name of the activity
            'location' => 'nullable|string|max:255', // The location of the activity
            'max_price' => 'nullable|numeric|min:0|gt:min_price', // The price of the activity
            'min_price' => 'nullable|numeric|min:0', // The price of the activity
            "is_available" => 'nullable|boolean', // The availability of the activity
        ];
    }
}
