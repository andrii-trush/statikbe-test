<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AbonnementNumberRule implements ValidationRule
{
    /**
     * Validate AbonnementNumber is follow regex and validate checksum.
     *
     * @param  Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match("/^\d{4}-\d{4}-\d{2}+$/", $value)) {
            $fail('The :attribute is not a valid number.');
        }

        $valueElements = explode('-', $value);

        $base = (int) ($valueElements[0] . $valueElements[1]);
        $checksum = (int) $valueElements[2];

        // TODO: move "98" to config
        if (($base % 98) !== $checksum) {
            $fail('The :attribute is not a valid number.');
        }
    }
}
