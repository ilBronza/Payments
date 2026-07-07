<?php

namespace IlBronza\Payments\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreditCardNumber implements ValidationRule
{
    public const MESSAGE = 'Il numero della carta di credito non è valido.';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(! static::passes($value))
            $fail(static::MESSAGE);
    }

    public static function passes($value): bool
    {
        if($value === null)
            return true;

        $value = trim((string) $value);

        if($value === '')
            return true;

        $number = preg_replace('/[\s-]+/', '', $value);

        if(! preg_match('/^\d{12,19}$/', $number))
            return false;

        return static::passesLuhnCheck($number);
    }

    protected static function passesLuhnCheck(string $number): bool
    {
        $sum = 0;
        $shouldDouble = false;

        for($index = strlen($number) - 1; $index >= 0; $index --)
        {
            $digit = (int) $number[$index];

            if($shouldDouble)
            {
                $digit *= 2;

                if($digit > 9)
                    $digit -= 9;
            }

            $sum += $digit;
            $shouldDouble = ! $shouldDouble;
        }

        return $sum % 10 === 0;
    }
}
