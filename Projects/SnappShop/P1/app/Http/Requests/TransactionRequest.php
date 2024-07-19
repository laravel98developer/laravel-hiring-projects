<?php

namespace App\Http\Requests;

use App\Models\Card;
use App\Rules\ValidIranCardNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class TransactionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        return [
            'card_number' => [
                'required',
                'numeric',
                'digits:16',
                new ValidIranCardNumberRule(), 
                new Exists(Card::class, 'card_number'),
            ],
            'destination_card_number' => [
                'required',
                'numeric',
                'digits:16',
                new ValidIranCardNumberRule(), 
                new Exists(Card::class, 'card_number'),
            ],
            'amount' => [
                'required',
                'numeric',
                'min:10000',
                'max:500000000',
            ]
        ];
    }
}
