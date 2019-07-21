<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Lat implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) :bool
    {
        return preg_match("/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,18}$/", (string) $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() :string
    {
        return trans('validation.lat');
    }
}
