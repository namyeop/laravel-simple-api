<?php

namespace App\Services;

use Illuminate\Support\Collection;

class PersonalTrainer implements TrainingProgram
{
    use Solution;

    public function getTrainingPlan(Collection $tags): Collection
    {
        return $tags
            ->map(function (string $tag) {
                return $this->getTagSolution($tag);
            })
            ->filter()
            ->unique();
    }

}
