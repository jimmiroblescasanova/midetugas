<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Project;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'rfc' => Str::random(12),
        'shortName' => $faker->userName,
        'reference' => $faker->numerify('#######'),
        'email' => $faker->unique()->email,
        'country_code' => '+52',
        'phone' => $faker->numerify('##########'),
        'project_id' => $faker->numberBetween(1, Project::count()),
    ];
});
