<?php

namespace App\Http\Requests\v1\Todo;

use App\Rules\FutureDate;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "description" => ["required", "string", "min:1"],
            "category_id" => ["nullable", "integer", "exists:categories,id"],
            "due_date" => ["required", "date", new FutureDate]
        ];
    }
}
