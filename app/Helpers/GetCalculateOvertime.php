<?php
namespace App\Helpers;

use App\Models\Employee;
use App\Models\Setting;

class GetCalculateOvertime {
    public static function calculateOvertime($request)
    {
        $date_first = date('Y-m-d', strtotime('1-'.$request->month));
        $date_last = date('Y-m-t', strtotime('1-'.$request->month));

        $data_overtime = Employee::with([
            'overtime' => function($q) use($date_first, $date_last) {
                $q->where('date', '>=', $date_first)->orWhere('date', '<=', $date_last);
            }
        ])->whereHas('overtime')->get();

        $settingExpression = Setting::with('reference')->first();
        $expression = $settingExpression->reference->expression;

        $employee = [];
        foreach($data_overtime as $data) {
            $employee['id'] = $data->id;
            $employee['name'] = $data->name;
            $employee['salary'] = $data->salary;

            if($settingExpression->value == 1) {
                $expression = str_replace('salary', $data->salary, $expression);
            }

            $overtime_data = [];
            $overtime_duration_total = 0;
            foreach($data->overtime as $overtime) {
                $interval = (int)floor(abs(strtotime($overtime->time_started) - strtotime($overtime->time_ended)) / 3600);
                $ovt_tmp = [
                    'id' => $overtime->id,
                    'date' => $overtime->date,
                    'time_started' => $overtime->time_started,
                    'time_ended' => $overtime->time_ended,
                    'overtime_duration' => $interval
                ];
                array_push($overtime_data, $ovt_tmp);

                $employee['overtimes'] = $overtime_data;
                $overtime_duration_total += $interval;
            }

            $expression = str_replace('overtime_duration_total', $overtime_duration_total, $expression);
            $amount = eval('return '.$expression.';');

            $employee['overtime_duration_total'] = $overtime_duration_total;
            $employee['amount'] = $amount;
        }

        return $employee;
    }
}
?>
