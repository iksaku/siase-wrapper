<?php

use Carbon\Carbon;
use Faker\Generator as Faker;
use iksaku\SIASE\Factories\Factory;
use iksaku\SIASE\Models\Schedule\Schedule;

/* @var Factory $factory */

$factory->define(Schedule::class, function (Faker $faker) {
    return [
        'period' => Carbon::createFromTimestamp(
            $faker->dateTimeThisDecade()->getTimestamp()
        )->diffForHumans(),
        'courses' => [],
    ];
});
