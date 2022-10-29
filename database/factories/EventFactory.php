<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->address(),
            'start_date' => $this->faker->unique()->dateTimeBetween('-2 week', '+3 week'),
            'end_date' => $this->faker->unique()->dateTimeBetween('-2 week', '+3 week'),
        ];
    }
}
