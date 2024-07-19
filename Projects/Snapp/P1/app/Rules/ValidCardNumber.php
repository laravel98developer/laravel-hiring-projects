<?php

namespace App\Rules;

use App\Facades\Inquiry;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCardNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Inquiry::validateCardNumber($value)) {
            $fail('validation.valid_card_number')->translate();
        }
    }
}
