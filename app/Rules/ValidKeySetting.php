<?php

namespace App\Rules;

use App\Models\Setting;
use Illuminate\Contracts\Validation\Rule;

class ValidKeySetting implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($settingKey)
    {
        $this->settingKey = $settingKey;
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
        $checkKey = Setting::where('key', $this->settingKey)->first();
        if(!$checkKey) {
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
        return 'Key is not valid';
    }
}
