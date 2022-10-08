<?php

namespace Database\Factories;

use App\Factor;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeasurerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'brand' => $this->faker->citySuffix,
            'model' => $this->faker->city,
            'serial_number' => $this->faker->numerify('######'),
            'actual_measure' => 0,
            'correction_factor' => Factor::inRandomOrder()->first()->value,
            'active' => false,
        ];
    }
}
