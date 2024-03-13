<?php

namespace App\Http\Requests\Product;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'start_date' => ['nullable','date','after_or_equal:now'],
            'end_date' => ['nullable','date','after:start_date'],
        ];
    }

    /**
     * set start_date and end_date if their value in null
     */
    public function passedValidation(): void
    {
        $now = Carbon::now();

        $this->merge([
            'start_date' => $this->start_date ?? $now->toDateTimeString(),
            'end_date' => $this->end_date ?? Carbon::parse($this->start_date)->addDays(14)->toDateTimeString(),//todo add it from config
        ]);
    }
}
