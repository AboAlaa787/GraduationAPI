<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Service;
use App\Traits\PermissionCheckTrait;

class ServicePolicy
{
    use PermissionCheckTrait;

    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'عرض الخدمات');
    }

    public function view($user): bool
    {
        return $this->hasPermission($user, 'عرض خدمة');
    }

    public function create($user): bool
    {
        return $this->hasPermission($user, 'اضافة خدمة');
    }

    public function update($user): bool
    {
        return $this->hasPermission($user, 'تعديل خدمة');
    }

    public function delete($user): bool
    {
        return $this->hasPermission($user, 'حذف خدمة');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user): bool
    {
        $permissions = $user->permissions()->where('name', 'استرجاع خدمة')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف خدمة نهائيا')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }
}
