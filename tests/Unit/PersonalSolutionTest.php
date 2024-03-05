<?php

use App\Services\PersonalTrainerService;

it('맞춤형 솔루션을 응답합니다.', function () {
    $personalTrainerService = new PersonalTrainerService();

    $params = [
        'type' => 'FITNESS',
        'tag' => ['enough_time']
    ];

    $result = $personalTrainerService->getPersonalSolution($params);

    //"enough_time"이라는 라이프 스타일을 갖고, "FITNESS"를 선호하는 고객이라면 "Strength" 솔루션을 응답받을 것입니다.
    $expectedResult = ['Strength'];

    expect($result)->toBe($expectedResult);
});
