<?php

namespace App\Rules;

use App\Models\Reference;
use Illuminate\Contracts\Validation\Rule;

class ValidValueSetting implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($settingValue)
    {
        $this->settingValue = $settingValue;
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
        $checkReference = Reference::where('id', $this->settingValue)->first();

        if(!$checkReference) {
            return false;
        }

        if($checkReference->code != 'overtime_method') {
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
        return 'Setting value is not valid';
    }
}
