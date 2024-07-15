<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
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
        return [
            "name" => ["required", "string", "between:2,255"],
            "price" => ["required", "numeric", "min:1"],
            "inventory" => ["required", "integer"]
        ];
    }
}
