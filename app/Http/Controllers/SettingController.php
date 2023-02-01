<?php

namespace App\Http\Controllers;

use App\Helpers\UpdateSetting;
use App\Rules\ValidKeySetting;
use App\Rules\ValidValueSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

 /**
 * @OA\Patch(
 *     path="/settings",
 *     summary="Mengubah data `settings`.",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
*                     property="key",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="value",
 *                     type="integer"
 *                 ),
 *                 example={"key": "overtime_method", "value": 1}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */

class SettingController extends Controller
{
    public function update(Request $request) {
        $validator = Validator::make($request->only('key', 'value'), [
            'key' => new ValidKeySetting($request->key),
            'value' => new ValidValueSetting($request->value),
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }
        UpdateSetting::updateSetting($request);

        return response()->json([
            'success' => true,
            'message' => 'Setting changed'
        ], 200);
    }
}
