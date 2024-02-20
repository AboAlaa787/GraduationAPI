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
        return $this->hasPermission($user, 'عرض الطلبات');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Client $client, $user, Order $order): bool
    {
        return $this->hasPermission($user, 'عرض الطلب') || $client->id === $order->client_id || $user->id === $order->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user, Client $client): bool
    {
        return $this->hasPermission($user, 'اضافة طلب');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Client $client, Order $order): bool
    {
        return $this->hasPermission($user, 'تعديل طلب') || $client->id === $order->client_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Client $client, Order $order): bool
    {
        return $this->hasPermission($user, 'حذف طلب') || $client->id === $order->client_id;
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
