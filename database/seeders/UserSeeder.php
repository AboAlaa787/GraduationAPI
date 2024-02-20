<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Permission_user;
use App\Models\Rule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rule=Rule::where('name','مدير')->first();
        $user = User::create([
            'email' => 'admin@gmail.com',
            'name' => 'admin',
            'last_name' => 'admin',
            'rule_id'=>$rule->id,
            'password' => Hash::make('#123456789H'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        User::factory()
            ->count(50)
            ->create();
    }
}
