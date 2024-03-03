<?php

namespace App\Policies;

use App\Traits\PermissionCheckTrait;

class CustomerPolicy
{
    use PermissionCheckTrait;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $this->hasPermission($user,'عرض الزبائن');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user): bool
    {
        return $this->hasPermission($user,'عرض زبون');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $this->hasPermission($user,'اضافة زبون');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user): bool
    {
        return $this->hasPermission($user,'تعديل زبون');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user): bool
    {
        return $this->hasPermission($user,'حذف زبون');
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
