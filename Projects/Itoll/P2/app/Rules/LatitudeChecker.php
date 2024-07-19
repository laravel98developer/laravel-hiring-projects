<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LatitudeChecker implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value)) {
            $fail('The :attribute must be numeric.');
        }

        if ($value > 90) {
            $fail('The :attribute must be less than 90.');
        }

        if ($value < -90) {
            $fail('The :attribute must be greater than -90.');
        }
    }
}
