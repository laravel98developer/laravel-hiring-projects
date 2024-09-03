<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // The name of the activity
            'description' => 'required|string', // A description of the activity
            'location' => 'required|string|max:255', // The location of the activity
            'price' => 'required|numeric|min:0', // The price of the activity
            'available_slots' => 'required|integer|min:1', // The number of available slots for the activity
            'start_date' => 'required|date|after:now', // The start date and time of the activity
        ];
    }
}
