<?php

namespace App\Rules;

use App\Models\Employee;
use Illuminate\Contracts\Validation\Rule;

class ValidDateOvertime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($employee_id, $date)
    {
        $this->employee_id = $employee_id;
        $this->date = $date;
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
        $employee = Employee::with('overtime')->find($this->employee_id);

        foreach($employee->overtime as $overtime) {
            if($overtime->date == date('Y-m-d', strtotime($this->date))) {
                return false;
            }
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
        return 'Date has been used';
    }
}
