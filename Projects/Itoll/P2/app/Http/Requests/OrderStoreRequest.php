<?php

namespace App\Http\Requests;

use App\Rules\LatitudeChecker;
use App\Rules\LongitudeChecker;
use App\Rules\NotSameChecker;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_destination_latitude' => ['required', 'string', new LatitudeChecker()],
            'from_destination_longitude' => ['required', 'string', new LongitudeChecker()],
            'to_destination_latitude' => ['required', 'string', new LatitudeChecker()],
            'to_destination_longitude' => ['required', 'string', new LongitudeChecker()],
            'address' => ['required', 'string'],
            'supplier_name' => ['required', 'string'],
            'supplier_phone' => ['required', 'string', 'starts_with:09', 'size:11'],
            'receiver_name' => [
                'required',
                'string',
                new NotSameChecker('supplier_name'),
            ],
            'receiver_phone' => [
                'required',
                'string',
                'starts_with:09',
                'size:11',
                new NotSameChecker('supplier_phone'),
            ],
        ];
    }
}
