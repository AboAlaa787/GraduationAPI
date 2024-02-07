<?php

namespace App\Policies;

use App\Models\Device;
use App\Models\User;


class DevicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'استعلام عن جهاز')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'استعلام عن جهاز')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'اضافة جهاز')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'تعديل بيانات جهاز')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف جهاز')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Device $device): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return true;
    }
}
