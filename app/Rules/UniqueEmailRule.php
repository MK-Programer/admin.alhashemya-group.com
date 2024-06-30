<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class UniqueEmailRule implements Rule
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function passes($attribute, $value)
    {
        // Check if email exists in the users table except for the current user
        return !DB::table('users')
                    ->where('email', $value)
                    ->where('id', '!=', $this->userId)
                    ->exists();
    }

    public function message()
    {
        return Lang::get('validation.unique', ['attribute' => 'email']);
    }
}

