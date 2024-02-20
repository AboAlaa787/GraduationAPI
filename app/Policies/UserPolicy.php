<?php

namespace App\Policies;

use App\Traits\PermissionCheckTrait;

class UserPolicy
{
    use PermissionCheckTrait;

    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'استعلام عن مستخدمين');
    }


    public function view($user): bool
    {
        return $this->hasPermission($user, 'استعلام عن مستخدم');
    }

    public function create($user): bool
    {
        return $this->hasPermission($user, 'اضافة مستخدم');
    }

    public function update($user): bool
    {
        return $this->hasPermission($user, 'تعديل بيانات مستخدم');
    }

    public function delete($user): bool
    {
        return $this->hasPermission($user, 'حذف مستخدم');
    }
}
