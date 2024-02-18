<?php

namespace App\Policies;

use App\Models\Rule;

class RulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض الادوار')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Rule $rule): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض دور')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
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
    public function update($user, Rule $rule): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Rule $rule): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Rule $rule): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Rule $rule): bool
    {
        return false;
    }
}
