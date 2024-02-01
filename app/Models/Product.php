<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'center_id',
        'price',
        'quantity',
    ];

    /**
     * Get the center associated with the model.
     */
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
    /**
     * Get the orders associated with the model.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Product_order::class);
    }
}
