<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonalTrainerController extends Controller
{
    /**
     * Training Plan을 Return 합니다.
     * @param Request $request
     */
    public function getTrainingPlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'string|in:DIET,FITNESS',
            'tag' => 'required|array',
            'tag.*' => 'string|in:enough_money,strong_will,enough_time'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'message' => 'Error',
                'status' => '422'
            ], 422);
        }

        $validated = $validator->validated();

        $personalSolution = app('personalTrainer')->getPersonalSolution($validated);

        return $personalSolution;
    }
}
