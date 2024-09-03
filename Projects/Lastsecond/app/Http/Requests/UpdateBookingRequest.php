<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
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
            'activity_id' => 'sometimes|required|exists:activities,id',
            'user_name' => 'sometimes|required|string|max:255',
            'user_email' => 'sometimes|required|email|max:255',
            'slots_booked' => 'sometimes|required|integer|min:1',
            'status' => 'sometimes|required|in:pending,confirmed,cancelled',
        ];
    }
}
