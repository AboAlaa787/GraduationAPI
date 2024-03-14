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
        'cost_to_client',
        'cost_to_customer',
        'fix_steps',
        'status',
        'client_approval',
        'date_receipt',
        'customer_id',
        'Expected_date_of_delivery',
        'deliver_to_client',
        'deliver_to_customer',
        'repaired_in_center',
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
