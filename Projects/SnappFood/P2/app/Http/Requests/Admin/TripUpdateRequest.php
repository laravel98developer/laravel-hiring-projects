<?php

namespace App\Http\Requests\Admin;

use App\Enums\Tripe\Status;
use Illuminate\Foundation\Http\FormRequest;

class TripUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'in:' . implode(',', Status::VALUES),
            ],
        ];
    }
}
