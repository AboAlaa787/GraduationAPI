<?php

namespace App\Policies;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        $permissions = $user->permissions()->where('name', 'استعلام عن مستخدمين')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user): bool
    {
        $permissions = $user->permissions()->where('name', 'استعلام عن مستخدم')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        $permissions = $user->permissions()->where('name', 'اضافة مستخدم')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user): bool
    {
        $permissions = $user->permissions()->where('name', 'تعديل بيانات مستخدم')->first();
        return (bool)$permissions;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف مستخدم')->first();
        return (bool)$permissions;
    }
}
