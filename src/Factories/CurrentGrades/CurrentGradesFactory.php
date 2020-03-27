<?php

use Faker\Generator as Faker;
use iksaku\SIASE\Factories\Factory;
use iksaku\SIASE\Models\CurrentGrades\CurrentGrades;

/* @var Factory $factory */

$factory->define(CurrentGrades::class, function (Faker $faker) {
    return [
        'grades' => [],
    ];
});
