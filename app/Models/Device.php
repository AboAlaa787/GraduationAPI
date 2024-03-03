<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'imei',
        'code',
        'client_id',
        'user_id',
        'client_priority',
        'manager_priority',
        'info',
        'problem',
        'cost',
        'fix_steps',
        'status',
        'client_approval',
        'date_receipt'
    ];
    protected $relations = [
        'client',
        'user',
        'customer',
        'orders',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class,'devices_orders');
    }
}
