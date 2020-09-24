<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Measurer;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Measurer::class, function (Faker $faker) {
    return [
        'serial_number' => Str::random('12'),
        'model' => $faker->city,
        'actual_measure' => 0,
        'active' => false,
    ];
});
