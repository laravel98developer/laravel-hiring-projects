<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vendor_id' => [
                'required',
                'exists:vendors,id',
            ],
        ];
    }
}
