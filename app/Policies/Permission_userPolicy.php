<?php

namespace App\Policies;

use App\Models\Permission_user;

class Permission_userPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        $permissions = $user->permissions()->where('name', 'الاستعلام عن صلاحيات المستخدمين')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Permission_user $permission): bool
    {
        $permissions = $user->permissions()->where('name', 'الاستعلام عن صلاحيات مستخدم')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        $permissions = $user->permissions()->where('name', 'تعيين صلاحيات للمستخدمين')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Permission_user $permission): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Permission_user $permission): bool
    {
        $permissions = $user->permissions()->where('name', 'ازالة صلاحيات من المستخدمين')->first();
        return (bool)$permissions;
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
