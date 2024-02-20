<?php

namespace App\Policies;

use App\Models\Permission_user;
use App\Traits\PermissionCheckTrait;

class Permission_userPolicy
{
    use PermissionCheckTrait;

    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'الاستعلام عن صلاحيات المستخدمين');
    }

    public function view($user, Permission_user $permission): bool
    {
        return $this->hasPermission($user, 'الاستعلام عن صلاحيات مستخدم');
    }

    public function create($user): bool
    {
        return $this->hasPermission($user, 'تعيين صلاحيات للمستخدمين');
    }

    public function update($user, Permission_user $permission): bool
    {
        return $this->hasPermission($user, 'تحديث صلاحيات المستخدم');
    }

    public function delete($user, Permission_user $permission): bool
    {
        return $this->hasPermission($user, 'ازالة صلاحيات من المستخدمين');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Permission_user $permission): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Permission_user $permission): bool
    {
        return true;
    }
}
