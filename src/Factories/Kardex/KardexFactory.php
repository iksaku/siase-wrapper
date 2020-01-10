<?php

use Faker\Generator as Faker;
use iksaku\SIASE\Factories\Factory;
use iksaku\SIASE\Models\Kardex\Kardex;

/* @var Factory $factory */

$factory->define(Kardex::class, function (Faker $faker) {
    return [
        'grades' => [],
    ];
});
