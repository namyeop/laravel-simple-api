<?php

namespace App\Services;

use Illuminate\Support\Collection;


class PersonalTrainerService
{
    private array $originalSolution = ['Intermittent Fasting', 'LCHF', 'Strength', 'Crossfit', 'Cardio Exercise', 'Spinning'];

    /**
     * @param array  $validatedParams
     * @return array
     */

    public function getPersonalSolution(array $validatedParams): array
    {
        $type = $validatedParams['type'] ?? null;
        $tag = collect($validatedParams['tag']?? null);
        $solutions = $this->getOriginalSolution();

        if ($this->isTypeValid($type)) {
            $newSolution = $this->getTrainingSolution($type, $tag);
            $solutions->add($newSolution);

            return $solutions->unique()->toArray();
        } else {
            $trainersCollection = collect(PersonalTrainerFactory::$trainers);

            $solutionsCollection = $trainersCollection->flatMap(function ($trainerClass) use ($tag) {
                $trainer = new $trainerClass;
                return $trainer->getTrainingPlan($tag);
            });

            return $solutions->merge($solutionsCollection)->unique->toArray();
        }
    }

    private function isTypeValid(?string $type): bool
    {
        return !is_null($type);
    }

    private function getOriginalSolution(): Collection
    {
        return collect($this->originalSolution);
    }
    private function getTrainingSolution(string $type, Collection $tag): Collection
    {
        $personalTrainer = PersonalTrainerFactory::make($type);

        if ($personalTrainer instanceof PersonalTrainer) {
            return $personalTrainer->getTrainingPlan($tag);
        }

        return new Collection();
    }

}
