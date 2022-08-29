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
    public function definition()
    {
        return [
            'code' => fake()->bothify('?????-#####'),
            'name' => fake()->word(),
            'price' => fake()->randomFloat(2,1.00,9999.99),
            'weight' => fake()->randomFloat(2, .5, 10),
        ];
    }
}
