<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'name' => fake()->words(3, true),
            'sku' => fake()->unique()->bothify('SKU-####??'),
            'description' => fake()->paragraph(3),
            'price' => fake()->numberBetween(10000, 500000),
            'stock' => fake()->numberBetween(1, 100),
            'image' => null,
            'is_active' => true,
            'is_featured' => fake()->boolean(30),
        ];
    }
}
