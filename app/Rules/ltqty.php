<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class ltqty implements Rule
{
    public $legalAge = 18;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($age)
    {
        $this->legalAge = $age;

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

        $formattedValue = new Carbon((int) $value);
        $legalAge = Carbon::now()->subYears($this->legalAge);
        return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You must be at least ' . $this->legalAge . ' years old!';

    }
}
