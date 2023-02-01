<?php
namespace App\Helpers;

use App\Models\Employee;
use App\Models\Overtime;

class StoreOvertime {
    public static function store($request)
    {
        // Employee::with('overtime')->find($request->employee_id);
        Overtime::create([
            'employee_id' => $request->employee_id,
            'date' => date('Y-m-d', strtotime($request->date)),
            'time_started' => date('H:i', strtotime($request->time_started)),
            'time_ended' => date('H:i', strtotime($request->time_ended)),
        ]);

        return true;

    }
}
?>
