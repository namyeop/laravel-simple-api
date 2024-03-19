<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface TrainingProgram
{
    function getTrainingPlan(Collection $tags): Collection;

}
