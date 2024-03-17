<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'national_id' => fake()->unique()->numerify('###########'),
            'phone' => fake()->numerify('##########'),
            'email' => fake()->unique()->safeEmail,
            'devices_count' => fake()->numberBetween(1, 10),
            'client_id' => fake()->numberBetween(1,50),
        ];
    }
}
