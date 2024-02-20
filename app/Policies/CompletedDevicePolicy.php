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
    public function view($user, Client $client, CompletedDevice $completedDevice): bool
    {
        return $this->hasPermission($user, 'عرض الجهاز التي تم تسليمها')
            || $client->id === $completedDevice->client_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user, Client $client): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Client $client, CompletedDevice $completedDevice): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, CompletedDevice $completedDevice): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, CompletedDevice $completedDevice): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, CompletedDevice $completedDevice): bool
    {
        return false;
    }
}
