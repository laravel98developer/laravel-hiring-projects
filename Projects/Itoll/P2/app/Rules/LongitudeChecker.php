<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LongitudeChecker implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value)) {
            $fail('The :attribute must be numeric.');
        }

        if ($value > 180) {
            $fail('The :attribute must be less than 180.');
        }

        if ($value < -180) {
            $fail('The :attribute must be greater than -180.');
        }
    }
}
