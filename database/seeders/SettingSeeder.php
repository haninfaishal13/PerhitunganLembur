<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = [
            [
                'key' => 'overtime_method',
                'value' => 1,
            ],
        ];

        foreach($setting as $key => $value) {
            Setting::create($value);
        }
    }
}
