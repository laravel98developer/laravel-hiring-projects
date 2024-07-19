<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotSameChecker implements ValidationRule
{
    public function __construct(private mixed $otherField)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value == request()?->input($this->otherField)) {
            $fail('The :attribute and ' . $this->otherField . ' must be different.');
        }
    }
}
