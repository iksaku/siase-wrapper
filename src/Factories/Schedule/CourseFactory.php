<?php

use Carbon\Carbon;
use Faker\Generator as Faker;
use iksaku\SIASE\Factories\Factory;
use iksaku\SIASE\Models\Schedule\Course;

/* @var Factory $factory */

$factory->define(Course::class, function (Faker $faker) {
    $name = ucwords($faker->words(2, true));

    $words = preg_split('/\s+/', $name);
    $shortName = '';
    foreach ($words as $word) {
        $shortName .= $word[0];
    }

    $startsAt = now();
    $endsAt = $startsAt->addMinutes(50);

    return [
        'id' => $faker->numberBetween(),
        'name' => $name,
        'shortName' => $shortName,
        'days' => [Carbon::MONDAY, Carbon::WEDNESDAY, Carbon::FRIDAY],
        'startsAt' => $startsAt->format('H:i'),
        'endsAt' => $endsAt->format('H:i'),
        'group' => $faker->randomDigit,
        'room' => (string) $faker->numberBetween(1000, 11000),
    ];
});
