<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Lng implements Rule
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
        return preg_match("/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,18}$/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() :string
    {
        return trans('validation.lng');
    }
}
