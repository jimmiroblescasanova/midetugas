<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Factor;
use App\Measurer;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Measurer::class, function (Faker $faker) {
    return [
        'brand' => $faker->citySuffix,
        'model' => $faker->city,
        'serial_number' => $faker->numerify('######'),
        'actual_measure' => 0,
        'correction_factor' => $faker->numberBetween(1, Factor::count()),
        'active' => false,
    ];
});
