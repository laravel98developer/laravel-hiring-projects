<?php

namespace App\Http\Requests\DeliveryRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreDeliveryRequestRequest extends FormRequest
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
            'o_latitude' => 'required|numeric',
            'o_longitude' => 'required|numeric',
            'o_firstname' => 'required|max:25',
            'o_lastname' => 'required|max:25',
            'o_address' => 'required|max:255',
            'o_phone' => 'required|max:12',
            'd_latitude' => 'required|numeric',
            'd_longitude' => 'required|numeric',
            'd_firstname' => 'required|max:25',
            'd_lastname' => 'required|max:25',
            'd_address' => 'required|max:255',
            'd_phone' => 'required|max:12',
        ];
    }
}
