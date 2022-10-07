<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city,
            'reference' => $this->faker->country,
            'total_capacity' => $this->faker->numberBetween(1000, 5000),
        ];
    }
}
