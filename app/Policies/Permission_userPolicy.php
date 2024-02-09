<?php

namespace App\Policies;

use App\Models\Permission_user;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Permission_userPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'الاستعلام عن صلاحيات المستخدمين')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission_user $permissionUser): bool
    {
        $permissions = $user->permissions()->where('name', 'الاستعلام عن صلاحيات مستخدم')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'تعيين صلاحيات للمستخدمين')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission_user $permissionUser): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission_user $permissionUser): bool
    {
        $permissions = $user->permissions()->where('name', 'ازالة صلاحيات من المستخدمين')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permission_user $permissionUser): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Permission_user $permissionUser): bool
    {
        return true;
    }
}
