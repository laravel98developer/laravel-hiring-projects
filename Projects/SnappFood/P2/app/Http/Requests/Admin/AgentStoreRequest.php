<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AgentStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'firstname' => [
                'required',
            ],
            'lastname' => [
                'required',
            ],
        ];
    }
}
