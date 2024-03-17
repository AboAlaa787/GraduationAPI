<?php

namespace Database\Factories;

use App\Enums\DeviceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model' => fake()->word,
            'code' => fake()->unique()->numberBetween(10000, 99999),
            'client_id' => fake()->numberBetween(1,50),
            'client_priority' => fake()->unique()->numberBetween(1, 100),
            'status' => fake()->randomElement(DeviceStatus::values()),
        ];
    }
}
