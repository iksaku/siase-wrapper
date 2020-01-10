<?php

use Faker\Generator as Faker;
use iksaku\SIASE\Factories\Factory;
use iksaku\SIASE\Models\Student;

/* @var Factory $factory */

$factory->define(Student::class, function (Faker $faker) {
    return [
        'id' => $faker->numberBetween(),
        'name' => $faker->name,
        'token' => (string) $faker->unixTime,
        'careers' => [],
    ];
});
