<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Product;
use App\Traits\PermissionCheckTrait;

class ProductPolicy
{
    use PermissionCheckTrait;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'الاسنعلام عن المنتجات');
    }

    public function view($user): bool
    {
        return $this->hasPermission($user, 'الاسنعلام عن منتج');
    }

    public function create($user): bool
    {
        return $this->hasPermission($user, 'اضافة منتج');
    }

    public function update($user): bool
    {
        return $this->hasPermission($user, 'تعديل منتج');
    }

    public function delete($user): bool
    {
        return $this->hasPermission($user, 'حذف منتج');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user): bool
    {
        return $this->hasPermission($user, 'استرجاع منتج');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Product $product): bool
    {
        return $this->hasPermission($user, 'حذف منتج نهائيا');
    }
}
