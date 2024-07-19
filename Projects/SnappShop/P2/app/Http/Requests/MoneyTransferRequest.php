<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use App\Rules\CardNumberFormat;
use Illuminate\Foundation\Http\FormRequest;

class MoneyTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_card_number' => ['required', 'numeric', 'exists:cards,card_number', new CardNumberFormat],
            'destination_card_number' => ['required', 'numeric', 'exists:cards,card_number', new CardNumberFormat],
            'amount' => ['required', 'numeric', 'min:'.Transaction::MIN, 'max:'.Transaction::MAX],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'source_card_number' => convert2english($this->input('source_card_number')),
            'destination_card_number' => convert2english($this->input('destination_card_number')),
        ]);
    }
}
