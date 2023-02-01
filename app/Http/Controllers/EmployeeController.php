<?php

namespace App\Http\Controllers;

use App\Helpers\StoreEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Post(
 *     path="/api/employees",
 *     summary="Membuat data `employees`.",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="salary",
 *                     type="integer"
 *                 ),
 *                 example={"name": "Jessica Smith", "salary": 5000000}
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

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->only('name', 'salary'), [
            'name' => ['string', 'min:2', 'unique:employees,name'],
            'salary' => ['integer', 'min:2000000', 'max:10000000'],
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages(),
            ], 422);
        }

        StoreEmployee::store($request);

        return response()->json([
            'success' => true,
            'message' => 'Success store employee data'
        ], 201);
    }
}
