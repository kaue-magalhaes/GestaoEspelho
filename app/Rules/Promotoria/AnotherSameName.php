<?php

namespace App\Rules\Promotoria;

use App\Models\Promotoria;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AnotherSameName implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->existAnoutherPromotoriaWithSameName($value)) {
            $fail("The $attribute has already been taken.");
        }
    }

    private function existAnoutherPromotoriaWithSameName(string $value): bool
    {
        $promotoria = Promotoria::query()
            ->where('nome', $value)
            ->first();

        if ($promotoria) {
            return true;
        }

        return false;
    }
}
