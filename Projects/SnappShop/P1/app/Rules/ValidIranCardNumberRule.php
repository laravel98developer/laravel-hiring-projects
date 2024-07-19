<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidIranCardNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        // algorythm to check th validation of card numbers

        $value = str_split($value);

        $sum = 0;

        foreach($value as $key => $digit) {

            if($key % 2 === 0){

                $digit = $digit * 2;

                if($digit > 9) {

                    $digit = $digit - 9;
                }
            }

            $sum = $sum + $digit;
        }

        if($sum % 10 !== 0){

            $fail('The :attribute must be a valid Iranian card number.');
        }
    }
}
