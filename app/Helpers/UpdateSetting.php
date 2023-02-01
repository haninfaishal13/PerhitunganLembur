<?php
namespace App\Helpers;

use App\Models\Setting;

class UpdateSetting {
    public static function updateSetting($request) {
        Setting::where('key', $request->key)->update([
            'value' => $request->value,
        ]);

        return true;
    }
}
?>
