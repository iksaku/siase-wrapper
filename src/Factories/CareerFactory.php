<?php

use Faker\Generator as Faker;
use iksaku\SIASE\Factories\Factory;
use iksaku\SIASE\Models\Career;

/* @var Factory $factory */

$factory->define(Career::class, function (Faker $faker) {
    $jobTitle = ucwords($faker->words(3, true));

    $words = preg_split('/\s+/', $jobTitle);
    $shortTitle = '';
    foreach ($words as $word) {
        $shortTitle .= $word[0];
    }

    return [
        'cve' => dechex($faker->numberBetween()),
        'name' => $jobTitle,
        'shortName' => $shortTitle,
    ];
});
