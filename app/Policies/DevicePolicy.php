<?php

namespace App\Policies;

use App\Models\Device;
use App\Traits\PermissionCheckTrait;


class DevicePolicy
{
    use PermissionCheckTrait;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'استعلام عن اجهزة');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user): bool
    {
        return $this->hasPermission($user, 'استعلام عن جهاز');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $this->hasPermission($user, 'اضافة جهاز');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user): bool
    {
        return $this->hasPermission($user, 'تعديل بيانات جهاز');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user): bool
    {
        return $this->hasPermission($user, 'حذف جهاز');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user): bool
    {
        return true;
    }
}
