<?php

namespace App\Services;

class PersonalTrainerFactory
{
    public static array $trainers = [
        'DIET' => DietExpert::class,
        'FITNESS' => FitnessCoach::class,
    ];

    public static function make(string $type): ?TrainingProgram
    {
        if (self::$trainers[$type] instanceof TrainingProgram) {
            return new self::$trainers[$type];
        }

        return null;
    }
}
