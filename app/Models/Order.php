<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'status',
        'date',
        'client_id',
        'user_id',
        'done',
        'deliver_to_user',
    ];
    protected $relations = [
        'client',
        'user',
        'devices',
        'products',
        'devices_orders',
        'products_orders',
    ];

    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(Device::class, 'devices_orders');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_orders');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function devices_orders(): HasMany
    {
        return $this->hasMany(Devices_orders::class);
    }

    public function products_orders(): HasMany
    {
        return $this->hasMany(Product_order::class);
    }
}
