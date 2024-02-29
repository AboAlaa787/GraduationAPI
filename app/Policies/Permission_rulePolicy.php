<?php

namespace App\Policies;

use App\Models\Permission_rule;
use App\Models\User;
use App\Traits\PermissionCheckTrait;
use Illuminate\Auth\Access\Response;

class Permission_rulePolicy
{
    use PermissionCheckTrait;


    public function viewAny( $user): bool
    {
        return $this->hasPermission($user, 'الاستعلام عن صلاحيات الادوار');
    }

    public function view( $user): bool
    {
        return $this->hasPermission($user, 'الاستعلام عن صلاحيات الدور');
    }

    public function create( $user): bool
    {
        return $this->hasPermission($user, 'تعيين صلاحيات للادوار');
    }

    public function update( $user): bool
    {
        return $this->hasPermission($user, 'تحديث صلاحيات الدور');
    }

    public function delete( $user): bool
    {
        return $this->hasPermission($user, 'ازالة صلاحيات من الادوار');
    }

    public function restore( $user): bool
    {
        return false;
    }

    public function forceDelete(User $user, Permission_rule $permissionRule): bool
    {
        return false;
    }
}
