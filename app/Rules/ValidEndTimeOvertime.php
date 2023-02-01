<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidEndTimeOvertime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($time_started, $time_ended)
    {
        $this->time_started = $time_started;
        $this->time_ended = $time_ended;
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
        $start_time = date('H:i', strtotime($this->time_started));
        $end_time = date('H:i', strtotime($this->time_ended));

        if($start_time > $end_time) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
