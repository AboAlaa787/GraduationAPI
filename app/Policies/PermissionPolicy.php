<?php

namespace App\Policies;

use App\Models\Permission;
use App\Traits\PermissionCheckTrait;

class PermissionPolicy
{
    use PermissionCheckTrait;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'الاسنعلام عن الصلاحيات');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user): bool
    {
        return $this->hasPermission($user, 'الاسنعلام عن صلاحية');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $this->hasPermission($user, 'اضافة صلاحية');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user): bool
    {
        return $this->hasPermission($user, 'تعديل صلاحية');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user): bool
    {
        return $this->hasPermission($user, 'حذف صلاحية');
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
