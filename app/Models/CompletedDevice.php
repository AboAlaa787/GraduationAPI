<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CompletedDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'imei',
        'code',
        'client_id',
        'client_name',
        'user_id',
        'user_name',
        'customer_id',
        'info',
        'problem',
        'cost_to_client',
        'cost_to_customer',
        'status',
        'fix_steps',
        'deliver_to_client',
        'deliver_to_customer',
        'date_receipt',
        'date_delivery_client',
        'date_delivery_customer',
        'client_date_warranty',
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
        return $this->belongsToMany(Order::class, 'devices_orders');
    }
}
