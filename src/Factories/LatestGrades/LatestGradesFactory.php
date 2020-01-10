<?php

use Faker\Generator as Faker;
use iksaku\SIASE\Factories\Factory;
use iksaku\SIASE\Models\LatestGrades\LatestGrades;

/* @var Factory $factory */

$factory->define(LatestGrades::class, function (Faker $faker) {
    return [
        'grades' => [],
    ];
});
