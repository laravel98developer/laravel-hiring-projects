<?php

namespace App\Http\Requests\Admin;

use App\Enums\Tripe\Status;
use Illuminate\Foundation\Http\FormRequest;

class TripStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id' => [
                'required',
                'exists:orders,id',
            ],
            'status' => [
                'required',
                'in:' . implode(',', Status::VALUES),
            ],
        ];
    }
}
