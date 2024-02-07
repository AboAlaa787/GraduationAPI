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
        $permissions = [
            'اضافة جهاز',
            'تسليم جهاز',
            'تعديل جهاز',
            'عرض العملاء',
            'عرض عميل',
            'اضافة عميل',
            'تعديل عميل',
            'حذف عميل',
            'استرجاع عميل',
            ' حذف عميل نهائيا',
            'عرض الاجهزة التي تم تسليمها',
            'عرض الجهاز التي تم تسليمها',
            'عرض الطلبات',
            'عرض الطلب',
            'اضافة طلب',
            'تعديل طلب',
            'حذف طلب',
            'استرجاع طلب',
            'حذف طلب نهائيا',
            'عرض الصلاحيات',
            'عرض صلاحية',
            'اضافة صلاحية',
            'تعديل صلاحية',
            'حذف صلاحية',
            'استرجاع صلاحية',
            'حذف صلاحية نهائيا',
            'عرض المنتجات',
            'عرض منتج',
            'اضافة منتج',
            'تعديل منتج',
            'حذف منتج',
            'استرجاع منتج',
            'حذف منتج نهائيا',
            'عرض الادوار',
            'عرض دور',
            'عرض الخدمات',
            'عرض خدمة',
            'اضافة خدمة',
            'تعديل خدمة',
            'حذف خدمة',
            'استرجاع خدمة',
            'حذف خدمة نهائيا',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
