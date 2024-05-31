<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product_order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'order_id',
    ];


    protected $relations=[
        'product',
        'order',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::updated(function ($product_order) {
            if ($product_order->isDirty('deliver_to_client')) {
                $order = $product_order->order;
                $undeliveredDevicesCount = $order->devices_orders()->where('deliver_to_client', false)->count();
                $undeliveredProductsCount = $order->products_orders()->where('deliver_to_client', false)->count();
                if ($undeliveredDevicesCount === 0 && $undeliveredProductsCount === 0) {
                    $order->update(['done' => true]);
                }
            }
        });
        static::updating(function ($product_order) {
            if ($product_order->isDirty('deliver_to_client')) {
                if ($product_order->deliver_to_client) {
                    $product_order->deliver_time = now();
                }
            }
        });
    }


    /**
     * Get the product associated with the model.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the order associated with the model.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
