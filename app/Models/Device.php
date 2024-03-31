<?php

namespace App\Models;

use DB;
use Illuminate\Support\Str;
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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($device) {
            //Automatic code generation
            do {
                $code = Str::random(6);
            } while (self::where('code', $code)->exists());
            $device->code = $code;
            //Automatic determination of client priority
            $client_priority = self::where('client_id', $device->client_id)->max('client_priority');
            $client_priority++;
            $device->client_priority = $client_priority;
            //Automatic selection of maintenance technician
            $usersWithDevicesCount = User::withCount('devices')->get();
            $minDevicesCount = $usersWithDevicesCount->min('devices_count');
            $userWithMinDevicesCount = $usersWithDevicesCount
                ->where('devices_count', $minDevicesCount)->shuffle()->first();
            $device->user_id = $userWithMinDevicesCount->id;
        });

        static::deleted(function ($device) {
            $clientId = $device->client_id;

            $devicesToUpdate = self::where('client_id', $clientId)
                ->where('client_priority', '>', $device->client_priority)
                ->get();

            foreach ($devicesToUpdate as $deviceToUpdate) {
                $deviceToUpdate->update(['client_priority' => $deviceToUpdate->client_priority - 1]);
            }
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
}
