<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Order;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض الطلبات')->first();
        return (bool)$permissions
            || $user->rule()->first()->name === 'مدير';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Client $client, $user, Order $order): bool
    {
        $permissions = $user->permissions()->where('name', 'عرض الطلب')->first();
        return (bool)$permissions
            || $client->id === $order->client_id
            || $user->id === $order->user_id
            || $user->rule_id === $user->rule()->where('name', 'مدير')->first()->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user, Client $client): bool
    {
        $permissions = $user->permissions()->where('name', 'اضافة طلب')->first();
        $permissions_client = $client->permissions()->where('name', 'اضافة طلب')->first();
        return (bool)$permissions
            || (bool)$permissions_client;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Client $client, Order $order): bool
    {
        $permissions = $user->permissions()->where('name', 'تعديل طلب')->first();
        return (bool)$permissions
            || $client->id === $order->client_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Client $client, Order $order): bool
    {
        $permissions = $user->permissions()->where('name', 'حذف طلب')->first();
        return (bool)$permissions
            || $client->id === $order->client_id;
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
