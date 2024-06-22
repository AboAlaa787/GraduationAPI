<?php

namespace App\Policies;

use App\Models\Client;
use App\Traits\PermissionCheckTrait;

class ClientPolicy
{
    use PermissionCheckTrait;
    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'الاسنعلام عن العملاء');
    }

    public function view($user, $targetData): bool
    {
        $isDataOwner = get_class($user) == get_class($targetData) && $targetData->id == $user->id;
        return $isDataOwner || $this->hasPermission($user, 'الاسنعلام عن عميل');
    }

    public function create($user): bool
    {
        return $this->hasPermission($user, 'اضافة عميل');
    }

    public function update($user, $targetData): bool
    {
        $isDataOwner = get_class($user) == get_class($targetData) && $targetData->id == $user->id;
        return $isDataOwner || $this->hasPermission($user, 'تعديل عميل');
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
