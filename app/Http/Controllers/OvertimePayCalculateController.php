<?php

namespace App\Http\Controllers;

use App\Helpers\GetCalculateOvertime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Get(
 *     path="/api/overtime-pays/calculate",
 *     description="Menampilkan hasil perhitungan dari `overtimes` yang ada pada setiap `employees`, berdasarkan bulan yang ditentukan, tanpa format pagination.",
 *     @OA\Parameter(
 *          description="Parameter bulan yang dicari",
 *          in="query",
 *          name="month",
 *          @OA\Schema(type="date")
 *      ),
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

class OvertimePayCalculateController extends Controller
{
    public function overtimePayCalculate(Request $request)
    {
        $validator = Validator::make($request->only('month'), [
            'month' => ['date_format:Y-m'],
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages(),
            ], 422);
        }

        $data_overtime = GetCalculateOvertime::calculateOvertime($request);

        return response()->json([
            'success' => true,
            'message' => $data_overtime,
        ], 200);
    }
}
