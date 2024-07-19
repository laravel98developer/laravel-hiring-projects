<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class DelayReportStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id' => [
                'required',
            ],
        ];
    }
}
