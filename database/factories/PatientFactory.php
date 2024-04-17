<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName(),
            'middlename' => rand(0, 1) ? fake()->lastName() : '',
            'lastname' => fake()->lastName(),
            'suffix' => rand(0, 1) ? fake()->suffix() : '',
            'date_of_birth' => fake()->date(),
            'address' => fake()->address()
        ];
    }
}
