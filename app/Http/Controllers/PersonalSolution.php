<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalSolution extends JsonResource
{
    public array $solution;
    public function __construct(array $solution)
    {
        $this->solution = $solution;
    }

    public function toArray(Request $request): array
    {
        return [
            'status' => '200',
            'message' => 'Success',
            /* @var string[] $solution*/
            'solution' => $this->solution
        ];
    }
}
