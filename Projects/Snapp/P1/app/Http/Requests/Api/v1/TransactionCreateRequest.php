<?php

namespace App\Http\Requests\Api\v1;

use App\Rules\ValidCardNumber;
use Illuminate\Foundation\Http\FormRequest;

class TransactionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['receiver_card_number' => change_digits_to_english($this->receiver_card_number)]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'receiver_card_number' => ['required', 'string', new ValidCardNumber, 'exists:bank_account_cards,card_number'],
            'amount' => ['required', 'integer', 'between:10000,500000000'],
        ];
    }
}
