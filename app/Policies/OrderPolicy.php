<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Order;
use App\Traits\PermissionCheckTrait;

class OrderPolicy
{
    use PermissionCheckTrait;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $this->hasPermission($user, 'الاسنعلام عن الطلبات');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user): bool
    {
        return $this->hasPermission($user, 'الاسنعلام عن طلب');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $this->hasPermission($user, 'اضافة طلب');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user): bool
    {
        return $this->hasPermission($user, 'تعديل طلب');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user): bool
    {
        return $this->hasPermission($user, 'حذف طلب');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Client $client, Order $order): bool
    {
        $permissions = $user->permissions()->where('name', 'استرجاع طلب')->first();
        return (bool)$permissions
            || $client->id === $order->client_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Client $client, Order $order): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف طلب نهائيا')->first();
        return (bool)$permissions
            || $client->id === $order->client_id;
    }
}
