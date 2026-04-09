<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class DoesNotContainIdentifiableInformation implements ValidationRule
{
    /**
     * Create a new rule instance.
     *
     * @param  array<int, string>  $identifiableInformation
     */
    public function __construct(protected array $identifiableInformation)
    {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $password = strtolower($value);

        foreach ($this->identifiableInformation as $info) {
            if (empty($info)) {
                continue;
            }

            $info = strtolower($info);

            if (str_contains($password, $info)) {
                $fail(__('The :attribute may not contain your name or email.'));

                return;
            }

            // Also check for parts of the email before the @
            if (str_contains($info, '@')) {
                $usernamePart = explode('@', $info)[0];
                if (strlen($usernamePart) > 3 && str_contains($password, $usernamePart)) {
                    $fail(__('The :attribute may not contain parts of your email address.'));

                    return;
                }
            }
        }
    }
}
