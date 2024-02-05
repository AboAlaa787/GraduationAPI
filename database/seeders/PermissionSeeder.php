<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions=[
            'اضافة جهاز',
            'تسليم جهاز',
            'تعديل جهاز',
            ];
        foreach ($permissions as $permission) {
            Permission::create(['name'=>$permission]);
        }
    }
}
