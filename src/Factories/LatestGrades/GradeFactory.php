<?php

use Faker\Generator as Faker;
use iksaku\SIASE\Factories\Factory;
use iksaku\SIASE\Models\LatestGrades\Grade;

/* @var Factory $factory */

$factory->define(Grade::class, function (Faker $faker) {
    return [
        'courseName' => $faker->streetName,
        'grade' => $faker->numberBetween(0, 100),
        'opportunity' => $faker->numberBetween(1, 6),
    ];
});
