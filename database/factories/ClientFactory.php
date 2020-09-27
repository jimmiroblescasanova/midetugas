<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Clients;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Clients::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'rfc' => Str::random(12),
        'email' => $faker->unique()->email,
        'country_code' => '+52',
        'phone' => $faker->numerify('##########'),
        'measurer_id' => NULL,
    ];
});
