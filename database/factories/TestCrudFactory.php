<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestCrudFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'test_name' => $this->faker->name(),
            'test_desc' => $this->faker->text(),
        ];
    }
}
