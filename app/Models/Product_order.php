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
