<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service_order extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'order_id',
    ];

    protected $relations=[
        'order',
        'service'
    ];

    /**
     * Get the service associated with the model.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the order associated with the model.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
