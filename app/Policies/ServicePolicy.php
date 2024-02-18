<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Service;

class ServicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user, Client $client): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض الخدمات')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id
            || $client->rule_id === $client->rule()->where('name', 'عميل')->first()->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Client $client, Service $service): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض خدمة')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id
            || $client->rule_id === $client->rule()->where('name', 'عميل')->first()->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        $permissions = $user->permissions()->where('name', 'اضافة خدمة')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Service $service): bool
    {
        $permissions = $user->permissions()->where('name', 'تعديل خدمة')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Service $service): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف خدمة')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Service $service): bool
    {
        $permissions = $user->permissions()->where('name', 'استرجاع خدمة')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Service $service): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف خدمة نهائيا')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }
}
