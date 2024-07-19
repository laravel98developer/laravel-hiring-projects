<?php

namespace App\Http\Requests;

use App\Rules\LatitudeChecker;
use App\Rules\LongitudeChecker;
use Illuminate\Foundation\Http\FormRequest;

class OrderDeliveryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'delivery_latitude' => ['required', 'string', new LatitudeChecker()],
            'delivery_longitude' => ['required', 'string', new LongitudeChecker()],
        ];
    }
}
