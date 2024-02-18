<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\CompletedDevice;


class CompletedDevicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض الاجهزة التي تم تسليمها')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id
            || $user->rule_id === $user->rule()->where('name', 'موظف')->first()->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Client $client, CompletedDevice $completedDevice): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض الجهاز التي تم تسليمها')->first();
        return (bool)$permissions
            || $client->id === $completedDevice->client_id
            || $user->rule_id === $user->rule()->where('name', 'موظف')->first()->id
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
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
