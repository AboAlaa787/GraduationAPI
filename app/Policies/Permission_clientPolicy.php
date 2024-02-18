<?php

namespace App\Policies;

use App\Models\Permission_client;

class Permission_clientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Permission_client $permissionClient): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Permission_client $permissionClient): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Permission_client $permissionClient): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Permission_client $permissionClient): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Permission_client $permissionClient): bool
    {
        //
    }
}
