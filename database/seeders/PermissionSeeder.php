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
            'حذف جهاز',
            'تعديل بيانات جهاز',
            'استعلام عن جهاز',
            'اضافة مستخدم',
            'حذف مستخدم',
            'تعديل بيانات مستخدم',
            'استعلام عن مستخدم',
            ];
        foreach ($permissions as $permission) {
            Permission::create(['name'=>$permission]);
        }
    }
}
    
