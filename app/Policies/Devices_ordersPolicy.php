<?php

namespace App\Policies;

use App\Models\Devices_orders;
use App\Models\User;
use App\Traits\PermissionCheckTrait;
use Illuminate\Auth\Access\Response;

class Devices_ordersPolicy
{
    use PermissionCheckTrait;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'استعلام عن طلبات الاجهزة');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user): bool
    {
        return $this->hasPermission($user, 'استعلام عن طلب جهاز');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $this->hasPermission($user, 'اضافة طلب لجهاز');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user): bool
    {
        return $this->hasPermission($user, 'تعديل بيانات طلب لجهاز');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user): bool
    {
        return $this->hasPermission($user, 'حذف طلب جهاز');
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
