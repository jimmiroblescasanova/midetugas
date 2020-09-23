<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Measurer;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Measurer::class, function (Faker $faker) {
    return [
        'code' => $faker->numerify('PROD#####'),
        'model' => $faker->city,
        'serial_number' => Str::random('12'),
        'active' => false,
    ];
});
