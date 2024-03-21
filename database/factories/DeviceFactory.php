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
            'imei' => fake()->optional()->numerify('###############'),
            'code' => fake()->unique()->regexify('[A-Z0-9]{10}'),
            'client_id' => fake()->numberBetween(1, 50),
            'user_id' => fake()->numberBetween(1, 50),
            'customer_id' => fake()->numberBetween(1, 50),
            'client_priority' => fake()->numberBetween(1, 20),
            'manager_priority' => fake()->optional()->numberBetween(1, 20),
            'info' => fake()->text,
            'problem' => fake()->sentence,
            'cost_to_client' => fake()->optional()->randomFloat(2, 10, 1000),
            'cost_to_customer' => fake()->optional()->randomFloat(2, 10, 1000),
            'fix_steps' => fake()->optional()->text,
            'status' => fake()->randomElement(DeviceStatus::values()),
            'client_approval' => fake()->boolean,
            'date_receipt' => fake()->dateTimeThisMonth(),
            'Expected_date_of_delivery' => fake()->optional()->dateTimeThisMonth(),
            'deliver_to_client' => fake()->boolean,
            'deliver_to_customer' => fake()->boolean,
            'repaired_in_center' => fake()->boolean,
        ];
    }
}
