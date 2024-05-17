<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Permission_rule;
use App\Models\Rule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Permission_RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rule = Rule::where('name', 'مدير')->firstOrFail();
        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            if ($rule->permissions->contains($permission->id)) {
                continue;
            }
            $rule->permissions()->attach($permission->id);
        }

        $rule = Rule::where('name', 'عميل')->firstOrFail();
        $permissions = [
            'الاسنعلام عن جهاز',
            'الاسنعلام عن الاجهزة',
            'اضافة جهاز',
            'تعديل بيانات جهاز',
            'حذف جهاز',
            'الاسنعلام عن الاجهزة التي تم تسليمها',
            'الاسنعلام عن جهاز تم تسليمه',
            'تعديل بيانات جهاز تم تسليمه',
            'تسليم جهاز',
            'اضافة زبون',
            'الاسنعلام عن الزبائن',
            'الاسنعلام عن زبون',
        ];
        foreach ($permissions as $permissionName) {

            $permission = Permission::where('name', $permissionName)->firstOrFail();
            if ($rule->permissions->contains($permission->id)) {
                continue;
            }
            $rule->permissions()->attach($permission->id);
        }
    }
}
