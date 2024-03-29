<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\CompletedDevice;
use App\Traits\PermissionCheckTrait;


class CompletedDevicePolicy
{
    use PermissionCheckTrait;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'عرض الاجهزة التي تم تسليمها');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user): bool
    {
        return $this->hasPermission($user, 'عرض الجهاز التي تم تسليمها');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $this->hasPermission($user, 'تسليم جهاز');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user): bool
    {
        return $this->hasPermission($user, 'تعديل بيانات جهاز تم تسليمه');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user): bool
    {
        return $this->hasPermission($user, 'حذف بيانات جهاز تم تسليمه');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user): bool
    {
        return false;
    }
}
