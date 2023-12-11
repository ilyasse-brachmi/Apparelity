<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => fake()->name(),
            'description' => fake()->text(7),
            'address' => fake()->text(5),
            'zipCode' => fake()->randomNumber(),
            'county' => fake()->country(),
            'city' => fake()->city(),
            'phone' => fake()->phoneNumber()
        ];
    }
}
