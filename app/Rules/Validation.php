<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Validation implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == null){
            $fail('The :This field is required.');
        }
    }
}
