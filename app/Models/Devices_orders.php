<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devices_orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'device_id',
        'order_id',
        'service_id',
        'info',
        'deliver_to_client',
        'deliver_time',
    ];

    protected $relations = [
        'order',
        'device',
        'service',
    ];
    protected static function boot(): void
    {
        parent::boot();
        static::updated(function ($devices_orders) {
            if ($devices_orders->isDirty('deliver_to_client')) {
                $order = $devices_orders->order;
                $undeliveredDevicesCount = $order->devices_orders()->where('deliver_to_client', false)->count();
                $undeliveredProductsCount = $order->products_orders()->where('deliver_to_client', false)->count();
                if ($undeliveredDevicesCount === 0 && $undeliveredProductsCount === 0) {
                    $order->update(['done' => true]);
                }
            }
            if ($devices_orders->isDirty('deliver_to_user')) {
                $order = $devices_orders->order;
                $undeliveredDevicesCount = $order->devices_orders()->where('deliver_to_user', false)->count();
                $undeliveredProductsCount = $order->products_orders()->where('deliver_to_user', false)->count();
                if ($undeliveredDevicesCount === 0 && $undeliveredProductsCount === 0) {
                    $order->update(['deliver_to_user' => true]);
                }
            }
        });
        static::updating(function ($devices_orders) {
            if ($devices_orders->isDirty('deliver_to_client')) {
                if ($devices_orders->deliver_to_client) {
                    $device = $devices_orders->device;
                    $device->deliver_to_client = true;
                    $device->save();
                    $devices_orders->deliver_time = now();
                }
            }
        });
    }
    /**
     * Get the device associated with the model.
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Get the order associated with the model.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the service associated with the model.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
