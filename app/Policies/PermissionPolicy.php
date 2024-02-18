<?php

namespace App\Policies;

use App\Models\Permission;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض الصلاحيات')->first();
        return (bool)$permissions;
        // || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Permission $permission): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض صلاحية')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        $permissions = $user->permissions()->where('name', 'اضافة صلاحية')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Permission $permission): bool
    {
        $permissions = $user->permissions()->where('name', 'تعديل صلاحية')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Permission $permission): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف صلاحية')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Permission $permission): bool
    {
        $permissions = $user->permissions()->where('name', 'استرجاع صلاحية')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Permission $permission): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف صلاحية نهائيا')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }
}
