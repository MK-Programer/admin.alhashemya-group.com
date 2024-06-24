<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
class CurrentPasswordRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Get the authenticated user's current password
        $authUserPassword = Auth::user()->password;

        // Check if the provided password matches the authenticated user's password
        return Hash::check($value, $authUserPassword);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return lang::get('translation.current_password_doesnot_match_provided_password');
    }
}

