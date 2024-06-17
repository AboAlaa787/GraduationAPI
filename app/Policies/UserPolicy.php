<?php

namespace App\Policies;

use App\Traits\PermissionCheckTrait;

class UserPolicy
{
    use PermissionCheckTrait;

    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'الاسنعلام عن المستخدمين');
    }


    public function view($user, $targetData): bool
    {
        $isDataOwner = get_class($user) == get_class($targetData) && $targetData->id == $user->id;
        return $isDataOwner || $this->hasPermission($user, 'الاسنعلام عن مستخدم');
    }

    public function create($user): bool
    {
        return $this->hasPermission($user, 'اضافة مستخدم');
    }

    public function update($user): bool
    {
        return $this->hasPermission($user, 'تعديل بيانات مستخدم');
    }

    public function delete($user): bool
    {
        return $this->hasPermission($user, 'حذف مستخدم');
    }
}
