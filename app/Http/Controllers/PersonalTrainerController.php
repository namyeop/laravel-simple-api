<?php

namespace App\Http\Controllers;

use App\Services\PersonalTrainerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class PersonalTrainerController extends Controller
{
    /**
     * Training Plan을 Return 합니다.
     * @param Request $request
     * @throws ValidationException
     */
    public function getTrainingPlan(Request $request, PersonalTrainerService $personalTrainerService): PersonalSolution|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'string|in:DIET,FITNESS',
            'tag' => 'required|array',
            'tag.*' => 'string|in:enough_money,strong_will,enough_time'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "data" => [
                    'solution' => $validator->errors(),
                    'message' => 'Parameter error',
                    'status' => '422'
                ]
            ], 422);
        }

        $validated = $validator->validated();
        $personalSolution = $personalTrainerService->getPersonalSolution($validated);
        /**
         * 맞춤형 솔루션을 응답합니다.
         */
        return new PersonalSolution($personalSolution);
    }
}
