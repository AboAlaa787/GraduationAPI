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

    protected $relations=[
        'order',
        'device',
        'service',
    ];

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
