<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'استعلام عن مستخدم')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        $permissions = $user->permissions()->where('name', 'استعلام عن مستخدم')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'اضافة مستخدم')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'تعديل بيانات مستخدم')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف مستخدم')->first();
        return (bool)$permissions;
    }
}
