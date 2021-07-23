<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class equalToZero implements Rule
{

    public function __construct()
    {
        //
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // if ($value !== 0) {
            // return false;
        // }
        return '0' === (string) $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid DR Qty and CR Qty must be equal!';

    }
}
