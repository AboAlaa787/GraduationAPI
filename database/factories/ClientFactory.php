<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'center_name' => 'test',
            'email' => fake()->email(),
            'national_id' => fake()->unique()->numerify('###########'),
            'name' => fake()->name(),
            'last_name' => fake()->name(),
            'password' => Hash::make("#123456789H"),
            'address' => fake()->address(),
        ];
    }
}
