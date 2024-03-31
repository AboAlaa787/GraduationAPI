<?php

namespace Database\Seeders;

use App\Models\CompletedDevice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompletedDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompletedDevice::factory()->count(1000)->create();
    }
}
