<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use App\Models\Client;

class ServicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Client $client): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض الخدمات')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id
            || $client->rule_id === $client->rule()->where('name', 'عميل')->first()->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Client $client, Service $service): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض خدمة')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id
            || $client->rule_id === $client->rule()->where('name', 'عميل')->first()->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'اضافة خدمة')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): bool
    {
        $permissions = $user->permissions()->where('name', 'تعديل خدمة')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف خدمة')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        $permissions = $user->permissions()->where('name', 'استرجاع خدمة')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف خدمة نهائيا')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }
}
