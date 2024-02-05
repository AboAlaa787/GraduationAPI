<?php

namespace App\Models;

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
        'center_id',
        'time_required',
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
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'service_orders');
    }
}
