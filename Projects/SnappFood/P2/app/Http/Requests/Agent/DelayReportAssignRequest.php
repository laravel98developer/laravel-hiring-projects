<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;

class DelayReportAssignRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'agent_id' => [
                'required',
            ],
        ];
    }
}
