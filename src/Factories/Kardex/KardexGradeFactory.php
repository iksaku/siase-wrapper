<?php

use Faker\Generator as Faker;
use iksaku\SIASE\Factories\Factory;
use iksaku\SIASE\Models\Kardex\KardexGrade;

/* @var Factory $factory */

$factory->define(KardexGrade::class, function (Faker $faker) {
    return [
        'courseName' => $faker->streetName,
        'grade' => $faker->numberBetween(0, 100),
        'semester' => $faker->numberBetween(1, 10),
    ];
});
