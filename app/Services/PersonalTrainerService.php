<?php

namespace App\Services;

use Faker\Provider\ar_EG\Person;

abstract class PersonalTrainer
{
  abstract public function getTrainingPlan(array $tags);
}

class DietExpert extends PersonalTrainer
{
  private $tagSolutions = [
    "enough_time" => ["Intermittent Fasting"],
    "strong_will" => ["Intermittent Fasting"],
    "enough_money" => ["LCHF"]
  ];

  public function getTrainingPlan(array $tags)
  {
    $solutions = [];
    foreach ($tags as $tag) {
      if (isset($this->tagSolutions[$tag])) {
        $solutions = array_merge($solutions, $this->tagSolutions[$tag]);
      }
    }
    return array_unique($solutions);
  }
}

class FitnessCoach extends PersonalTrainer
{
  private $tagSolutions = [
    "enough_time" => ["Strength"],
    "strong_will" => ["Crossfit", "Cardio Exercise", 'Strength'],
    "enough_money" => ["Crossfit", "Spinning"]
  ];

  public function getTrainingPlan(array $tags)
  {
    $solutions = [];
    foreach ($tags as $tag) {
      if (isset($this->tagSolutions[$tag])) {
        $solutions = array_merge($solutions, $this->tagSolutions[$tag]);
      }
    }
    return array_unique($solutions);
  }
}

class PersonalTrainerFactory
{
  public static $trainers = [
    'DIET' => DietExpert::class,
    'FITNESS' => FitnessCoach::class,
  ];

  public static function make($type)
  {
    if (isset(self::$trainers[$type])) {
      return new self::$trainers[$type];
    } else {
      return;
    }
  }
}

class PersonalTrainerService
{
  /**
   * @param array  $validatedParams 
   * @return array
   */

  public function getPersonalSolution(array $validatedParams): array
  {
    $type = $validatedParams['type'] ?? null;
    $tag = $validatedParams['tag'];

    $originalSolution = ['Intermittent Fasting', 'LCHF', 'Strength', 'Crossfit', 'Cardio Exercise', 'Spinning'];

    if ($type) {
      $personalTrainer = PersonalTrainerFactory::make($type);
      $solution = $personalTrainer->getTrainingPlan($tag);

      $differedSolution = array_diff($originalSolution, $solution);

      $result = array_merge($solution, $differedSolution);

      return $solution;
    } else {
      $solutions = [];
      foreach (PersonalTrainerFactory::$trainers as $trainerClass) {
        $trainer = new $trainerClass;
        $solutions = array_merge($solutions, $trainer->getTrainingPlan($tag));

        $differedSolution = array_diff($originalSolution, $solutions);

        $result = array_merge($solutions, $differedSolution);
      }
      return array_unique($result);
    }
  }
}
