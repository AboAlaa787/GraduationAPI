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
        return $this->hasPermission($user, 'الاسنعلام عن الخدمات');
    }

    public function view($user): bool
    {
        return $this->hasPermission($user, 'الاسنعلام عن خدمة');
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

}
