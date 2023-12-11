<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => function () {
                // Ensure that a valid company_id is used
                return \App\Models\Company::factory()->create()->id;
            },
            'category_id' => function () {
                // Ensure that a valid category_id is used
                return \App\Models\Category::factory()->create()->id;
            },
            'name' => fake()->name(),
            'price' => fake()->randomDigit(),
            'description' => fake()->text(20),
            'production_date' => fake()->date()
        ];
    }
}
