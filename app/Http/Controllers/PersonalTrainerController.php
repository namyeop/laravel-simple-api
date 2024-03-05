<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class PersonalSolution extends JsonResource
{
    public $solution;
    public function __construct($solution)
    {
        $this->solution = $solution;
    }

    public function toArray(Request $request)
    {
        return [
            'status' => '200',
            'message' => 'Success',
            /* @var string[] $solution*/
            'solution' => $this->solution
        ];
    }
}


class PersonalTrainerController extends Controller
{
    /**
     * Training Plan을 Return 합니다.
     * @param Request $request
     */
    public function getTrainingPlan(Request $request): PersonalSolution
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

        $personalSolution = app('personalTrainer')->getPersonalSolution($validated);
        /**
         * 맞춤형 솔루션을 응답합니다.
         */
        return new PersonalSolution($personalSolution);
    }
}
