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
        'date_receipt_from_customer',
        'date_delivery_client',
        'date_delivery_customer',
        'client_date_warranty',
        'customer_date_warranty',
        'repaired_in_center',
        'customer_complaint',
        'payment_status',
    ];
    protected $relations = [
        'client',
        'user',
        'customer',
        'orders',
    ];
    protected array $searchAbleColumns = [
        'model',
        'imei',
        'code',
        'problem',
        'status',
        'client_name',
        'user_name',
        'client.name',
        'client.last_name',
        'client.phone',
        'user.name',
        'user.last_name',
        'user.phone',
        'customer.name',
        'customer.last_name',
        'customer.phone',
    ];
    protected static function boot(): void
    {
        parent::boot();
        static::creating(static function ($completedDevice) {
            $completedDevice->date_delivery_client = now();
        });
    }

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

    public function getSearchAbleColumns(): array
    {
        return $this->searchAbleColumns;
    }
}
