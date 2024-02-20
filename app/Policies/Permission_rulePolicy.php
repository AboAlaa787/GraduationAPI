<?php

namespace App\Policies;

use App\Models\Permission_rule;
use App\Models\User;
use App\Traits\PermissionCheckTrait;
use Illuminate\Auth\Access\Response;

class Permission_rulePolicy
{
    use PermissionCheckTrait;


    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'الاستعلام عن صلاحيات الادوار');
    }

    public function view(User $user, Permission_rule $permissionRule): bool
    {
        return $this->hasPermission($user, 'الاستعلام عن صلاحيات الدور');
    }

    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'تعيين صلاحيات للادوار');
    }

    public function update(User $user, Permission_rule $permissionRule): bool
    {
        return $this->hasPermission($user, 'تحديث صلاحيات الدور');
    }

    public function delete(User $user, Permission_rule $permissionRule): bool
    {
        return $this->hasPermission($user, 'ازالة صلاحيات من الادوار');
    }

    public function restore(User $user, Permission_rule $permissionRule): bool
    {
        return false;
    }

    public function forceDelete(User $user, Permission_rule $permissionRule): bool
    {
        return false;
    }
}
