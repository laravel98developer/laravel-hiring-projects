<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DelayReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->order->user_id == auth()->id();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'delivery_estimation' => $this->order->created_at->addMinutes($this->order->delivery_time),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'delivery_estimation' => ['date', 'before:now'],
        ];
    }
}
