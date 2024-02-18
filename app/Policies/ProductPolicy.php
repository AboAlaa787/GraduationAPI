<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Product;

class ProductPolicy
{

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user, Client $client): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض المنتجات')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id
            || $client->rule_id === $client->rule()->where('name', 'عميل')->first()->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Client $client, Product $product): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض منتج')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id
            || $client->rule_id === $client->rule()->where('name', 'عميل')->first()->id;
    }


    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        $permissions = $user->permissions()->where('name', 'اضافة منتج')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Product $product): bool
    {
        $permissions = $user->permissions()->where('name', 'تعديل منتج')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Product $product): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف منتج')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Product $product): bool
    {
        $permissions = $user->permissions()->where('name', 'استرجاع منتج')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Product $product): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف منتج نهائيا')->first();
        return (bool)$permissions
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }
}
