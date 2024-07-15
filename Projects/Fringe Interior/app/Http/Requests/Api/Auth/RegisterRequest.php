<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
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
            "name" => ["required", "string"],
            "email" => ["required", "string", "email", "unique:users,email"],
            "password" => ["required", "min:5"]
        ];
    }
}
