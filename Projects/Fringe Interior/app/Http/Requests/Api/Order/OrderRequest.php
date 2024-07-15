<?php

namespace App\Http\Requests\Api\Order;

use App\Http\Requests\BaseRequest;

class OrderRequest extends BaseRequest
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
            "products" => ["required", "array"],
            "products.*.id" => ["required", "string"],
            "products.*.quantity" => ["required", "integer", "min:1"]
        ];
    }
}
