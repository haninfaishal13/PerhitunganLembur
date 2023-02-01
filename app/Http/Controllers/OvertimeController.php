<?php

namespace App\Http\Controllers;

use App\Helpers\StoreOvertime;
use App\Rules\ValidDateOvertime;
use App\Rules\ValidEndTimeOvertime;
use App\Rules\ValidStartTimeOvertime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Post(
 *     path="/api/overtimes",
 *     summary="Membuat data `overtimes`.",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="employee_id",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="date",
 *                     type="date"
 *                 ),
 *                @OA\Property(
 *                     property="time_started",
 *                     type="time"
 *                 ),
 *                @OA\Property(
 *                     property="time_ended",
 *                     type="time"
 *                 ),
 *                 example={"name": "1", "date": "10-11-2021", "time_started": "19:00", "time_ended": "22:00"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Created",
 *         @OA\JsonContent(
 *             @OA\Examples(example="result", value={"success": true}, summary="An result object."),
 *             @OA\Examples(example="bool", value=false, summary="A boolean value."),
 *         )
 *     )
 * )
 */

class OvertimeController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->except('_token'), [
            'employee_id' => ['integer', 'exists:employees,id'],
            'date' => ['date', new ValidDateOvertime($request->employee_id, $request->date)],
            'time_started' => ['date_format:H:i', new ValidStartTimeOvertime($request->time_started, $request->time_ended)],
            'time_ended' => ['date_format:H:i', new ValidEndTimeOvertime($request->time_started, $request->time_ended)],

        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages(),
            ], 422);
        }

        StoreOvertime::store($request);

        return response()->json([
            'success' => true,
            'message' => 'Success store overtime data',
        ], 201);
    }
}
