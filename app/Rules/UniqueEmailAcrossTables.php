<?php

namespace App\Rules;

use Closure;
use App\Models\User;
use App\Models\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueEmailAcrossTables implements Rule
{
    public function passes($attribute, $value): bool
    {
        return !User::where('email', $value)->exists() && !Client::where('email', $value)->exists();
    }

    public function message(): string
    {
        return 'The email has already been taken.';
    }
}
