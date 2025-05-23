<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Required check
        if (empty($value)) {
            $fail('The :attribute field is required.');

            return;
        }

        // Must be string
        if (! is_string($value)) {
            $fail('The :attribute must be a string.');

            return;
        }

        // Valid email format
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('The :attribute must be a valid email address.');

            return;
        }

        // Length check
        if (strlen($value) > 255) {
            $fail('The :attribute must not be greater than 255 characters.');

            return;
        }

        // Disposable email domain block (optional)
        $disposableDomains = ['mailinator.com', 'tempmail.com', '10minutemail.com'];
        $domain = substr(strrchr($value, '@'), 1);

        if (in_array($domain, $disposableDomains)) {
            $fail('The :attribute domain is not allowed.');

            return;
        }

    }
}
