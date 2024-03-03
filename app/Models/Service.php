<?php

namespace App\Models;

use FFI;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'time_required',
    ];
    protected $relations=[
        'orders',
        'devices',
    ];

    /**
     * Get the orders associated with the model.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'devices_orders');
    }

    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(Device::class, 'devices_orders');
    }
}
