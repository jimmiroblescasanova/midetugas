<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'reference' => $faker->country,
        'total_capacity' => $faker->numberBetween(1000, 5000),
    ];
});
