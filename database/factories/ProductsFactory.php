<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(5, true),
            'colour' => $this->faker->hexcolor(),
            'category' => $this->faker->randomElement(['cameras', 'laptops', 'tv', 'printers', 'phones', 'tablets']),
            'image' => $this->faker->numberBetween($min = 1, $max = 14) . ".jpg",
            'description' => $this->faker->realText(200),
            'featured' => $this->faker->boolean(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'quantity' => $this->faker->randomDigit(),
            'user_id' => \App\Models\User::all()->random()->id
        ];
    }
}
