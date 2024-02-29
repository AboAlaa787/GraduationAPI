<?php

namespace App\Policies;

use App\Models\Client;
use App\Traits\PermissionCheckTrait;

class ClientPolicy
{
    use PermissionCheckTrait;
    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'عرض العملاء');
    }

    public function view($user): bool
    {
        return $this->hasPermission($user, 'عرض عميل');
    }

    public function create($user): bool
    {
        return $this->hasPermission($user, 'اضافة عميل');
    }

    public function update($user): bool
    {
        return $this->hasPermission($user, 'تعديل عميل');
    }

    public function delete($user): bool
    {
        return $this->hasPermission($user, 'حذف عميل');
    }

    public function restore($user): bool
    {
        return $this->hasPermission($user, 'استرجاع عميل');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user): bool
    {
        $permissions = $user->permissions()->where('name', ' حذف عميل نهائيا')->first();
        return $permissions
            || $user->rule()->first()->name === 'مدير';
    }
}
