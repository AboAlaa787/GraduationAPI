<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض العملاء')->first();
        return $permissions
            || $user->rule()->first()->name === 'مدير';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض عميل')->first();
        return $permissions
            || $user->rule()->first()->name === 'مدير';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'اضافة عميل')->first();
        return $permissions
            || $user->rule()->first()->name === 'مدير';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Client $client): bool
    {
        $permissions = $user->permissions()->where('name', 'تعديل عميل')->first();
        return $permissions
            || $user->rule()->first()->name === 'مدير';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف عميل')->first();
        return $permissions
            || $user->rule()->first()->name === 'مدير';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Client $client): bool
    {
        $permissions = $user->permissions()->where('name', 'استرجاع عميل')->first();
        return $permissions
            || $user->rule()->first()->name === 'مدير';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Client $client): bool
    {
        $permissions = $user->permissions()->where('name', ' حذف عميل نهائيا')->first();
        return $permissions
            || $user->rule()->first()->name === 'مدير';
    }
}
