<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'amin' => ['sometimes'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => ['required', 'distinct', Rule::exists(table: Product::class, column: 'id')],
            'products.*.quantity' => ['required', 'int', 'min:0'],
            'products.*.price' => ['required', 'int', 'min:0'],
        ];
    }
}
