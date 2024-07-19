<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VendorStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'required',
            ],
        ];
    }
}
