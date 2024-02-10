<?php

namespace App\Policies;

use App\Models\Rule;
use App\Models\User;

class RulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض الادوار')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Rule $rule): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض دور')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Rule $rule): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Rule $rule): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Rule $rule): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Rule $rule): bool
    {
        return false;
    }
}