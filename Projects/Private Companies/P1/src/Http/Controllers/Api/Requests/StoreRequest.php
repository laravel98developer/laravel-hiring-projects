<?php

namespace AliSalehi\Task\Http\Controllers\Api\Requests;

use AliSalehi\Task\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $rules = [
            Task::TITLE        => 'required',
            Task::USER_ID      => ['required', 'exists:' . config('task.user.table', 'users') . ',id'],
            Task::DUE_DATE     => 'date',
            Task::ATTACHMENT   => 'nullable',
            Task::DESCRIPTION  => 'nullable',
            Task::IS_COMPLETED => ['nullable', 'boolean'],
        ];
        
        if (request()->method === 'PATCH') {
            $rules[Task::TITLE] = 'required';
            $rules[Task::USER_ID] = ['required', 'exists:' . config('task.user.table', 'users') . ',id'];
            $rules[Task::DUE_DATE] = 'date';
            $rules[Task::ATTACHMENT] = 'nullable';
            $rules[Task::DESCRIPTION] = 'nullable';
            $rules[Task::IS_COMPLETED] = ['nullable', 'boolean'];
        }
        
        return $rules;
    }
}
