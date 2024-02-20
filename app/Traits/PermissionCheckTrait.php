<?php

namespace App\Traits;


trait PermissionCheckTrait
{
    public function hasPermission($user, $permissionName): bool
    {
        return $user->permissions()->where('name', $permissionName)->exists() || ($user->rule_id && $user->rule()->first()->permissions()->where('name', $permissionName)->exists());
    }
}
