<?php

namespace App\Models;

use App\Enums\RuleNames;
use App\Events\AddDevice;
use App\Events\ClientApproval;
use App\Events\DeleteDevice;
use App\Events\NotificationEvents\DeviceStateNotifications;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;


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
        'at_work',
        'client_date_warranty',
        'customer_date_warranty',
    ];
    protected $relations = ['client', 'user', 'customer', 'orders',];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(static function ($device) {
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
            $usersWithDevicesCount = User::withCount('devices')->where('at_work', true)->whereHas('rule', function ($query) {
                $query->where('name', RuleNames::Technician);
                $query->where('name', RuleNames::Delivery);
             })->get();
                if ($usersWithDevicesCount->count() > 0) {
                $minDevicesCount = $usersWithDevicesCount->min('devices_count');
                $userWithMinDevicesCount = $usersWithDevicesCount->where('devices_count', $minDevicesCount)->shuffle()->first();
                $device->user_id = $userWithMinDevicesCount->id;
            }
        });

        static::deleted(static function ($device) {
            $clientId = $device->client_id;
            $client = Client::find($clientId);
            if ($client) {
                $client->decrement('devices_count');
            }

            $devicesToUpdate = self::where('client_id', $clientId)->where('client_priority', '>', $device->client_priority)->get();

            foreach ($devicesToUpdate as $deviceToUpdate) {
                $deviceToUpdate->update(['client_priority' => $deviceToUpdate->client_priority - 1]);
            }
        });
        static::updated(function ($device) {
            if ($device->isDirty('client_approval')) {
                event(new ClientApproval($device));
            }
            if ($device->isDirty('deliver_to_customer')) {
                event(new DeleteDevice($device));
            }
            if ($device->isDirty('status')) {
                event(new DeviceStateNotifications($device));
            }
        });
        static::created(function ($device) {
            event(new AddDevice($device->client_id));
        });

        static::updating(function ($device) {
            if ($device->isDirty('client_id')) {
                $oldClientId = $device->getOriginal('client_id');
                $oldClient = Client::find($oldClientId);
                $newClient = $device->client;
                $maxPriority = $newClient->devices()->max('client_priority');
                $device->client_priority = $maxPriority + 1;
                $oldClient->decrement('devices_count');
                $newClient->increment('devices_count');
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
