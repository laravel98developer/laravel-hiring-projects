<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CardNumberFormat implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $iranCardsNumberRegex = [
            '/^(603799)\d+$/',
            '/^(621986)\d+$/',
            '/^(589210)\d+$/',
        ];

        foreach ($iranCardsNumberRegex as $regex) {
            if (preg_match($regex, $value)) {
                return;
            }
        }

        $fail('The :attribute format is not supported by iranian banks.');
    }
}
