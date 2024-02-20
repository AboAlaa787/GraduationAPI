<?php

namespace App\Policies;

use App\Models\Permission_client;
use App\Traits\PermissionCheckTrait;

class Permission_clientPolicy
{
    use PermissionCheckTrait;


    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'الاستعلام عن صلاحيات العملاء');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user): bool
    {
        return $this->hasPermission($user, 'الاستعلام عن صلاحيات عميل');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $this->hasPermission($user, 'تعيين صلاحيات للعملاء');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user): bool
    {
        return $this->hasPermission($user, 'تحديث صلاحيات العميل');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user): bool
    {
        return $this->hasPermission($user, 'ازالة صلاحيات من العملاء');
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Permission_client $permissionClient): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Permission_client $permissionClient): bool
    {
        return false;
    }
}
