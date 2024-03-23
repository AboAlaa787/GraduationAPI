<?php

namespace Database\Factories;

use App\Enums\DeviceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompletedDevice>
 */
class CompletedDeviceFactory extends Factory
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
            'imei' => fake()->numerify('###############'),
            'code' => fake()->unique()->word,
            'client_id' => fake()->numberBetween(1, 50),
            'client_name' => fake()->name,
            'user_id' => fake()->numberBetween(1, 50),
            'user_name' => fake()->name,
            'customer_id' => fake()->numberBetween(1, 50),
            'info' => fake()->paragraph,
            'problem' => fake()->sentence,
            'cost_to_client' => fake()->randomFloat(2, 1, 1000000),
            'cost_to_customer' => fake()->randomFloat(2, 1, 1000000),
            'status' => fake()->randomElement(DeviceStatus::values()),
            'fix_steps' => fake()->paragraph,
            'deliver_to_client' => fake()->boolean,
            'deliver_to_customer' => fake()->boolean(false),
            'date_receipt' => fake()->dateTimeThisYear(),
            'date_delivery' => fake()->dateTimeThisYear(),
            'date_warranty' => fake()->dateTimeBetween('+1 week', '+2 weeks')->format('Y-m-d'),
            'repaired_in_center' => fake()->boolean,
        ];
    }
}
