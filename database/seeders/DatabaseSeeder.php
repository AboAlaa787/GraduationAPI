<?php

namespace Database\Seeders;

use App\Models\Rule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            RuleSeeder::class,
            UserSeeder::class,
            ClientSeeder::class,
            PermissionSeeder::class,
            Permission_RuleSeeder::class,
            DeviceSeeder::class,
            ServiceSeeder::class,
            CustomerSeeder::class,
            CompletedDeviceSeeder::class,
        ]);
    }
}
