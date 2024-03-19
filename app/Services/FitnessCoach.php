<?php

namespace App\Services;

class FitnessCoach extends PersonalTrainer
{
    public array $tagSolutions = [
        "enough_time" => ["Strength"],
        "strong_will" => ["Crossfit", "Cardio Exercise", 'Strength'],
        "enough_money" => ["Crossfit", "Spinning"]
    ];
}
