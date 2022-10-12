<?php

namespace Database\Factories;

use App\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'rfc' => $this->faker->regexify('[A-Z]{3}[0-9]{6}[A-Z]{3}'),
            'shortName' => $this->faker->userName,
            'reference' => $this->faker->numerify('#######'),
            'email' => $this->faker->unique()->email,
            'country_code' => '+52',
            'phone' => $this->faker->numerify('##########'),
            'project_id' => Project::inRandomOrder()->first()->id,
            'line_1' => $this->faker->streetAddress(),
            'line_2' => $this->faker->streetName(),
            'line_3' => $this->faker->secondaryAddress(),
        ];
    }
}
