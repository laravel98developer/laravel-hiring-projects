<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255', // The name of the activity (optional)
            'description' => 'sometimes|required|string', // A description of the activity (optional)
            'location' => 'sometimes|required|string|max:255', // The location of the activity (optional)
            'price' => 'sometimes|required|numeric|min:0', // The price of the activity (optional)
            'available_slots' => 'sometimes|required|integer|min:1', // The number of available slots for the activity (optional)
            'start_date' => 'sometimes|required|date|after:now', // The start date and time of the activity (optional)
        ];
    }
}
