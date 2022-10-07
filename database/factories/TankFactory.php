<?php

namespace Database\Factories;

use App\Tank;
use App\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TankFactory extends Factory
{
    protected $model = Tank::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'brand' => $this->faker->word(),
            'model' => $this->faker->words(2, true),
            'serial_number' => $this->faker->numerify('#####'),
            'capacity' => $this->faker->randomNumber(4),
            'manufacturing_date' => $this->faker->dateTimeThisDecade(),
            'project_id' => Project::inRandomOrder()->first()->id,
        ];
    }
}
