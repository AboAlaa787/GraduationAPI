<?php

namespace Database\Seeders;

use App\Enums\RuleNames;
use App\Models\Rule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules=RuleNames::values();
        foreach ($rules as $rule) {
            Rule::create(['name' => $rule]);
        }
    }
}
