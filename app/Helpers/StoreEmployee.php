<?php
namespace App\Helpers;

use App\Models\Employee;

class StoreEmployee {
    public static function store($request)
    {
        Employee::create([
            'name' => $request->name,
            'salary' => $request->salary,
        ]);

        return true;

    }
}
?>
