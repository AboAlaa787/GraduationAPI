<?php

namespace App\Models;

use App\Enums\RuleNames;
use App\Events\ClientApproval;
use App\Events\DeleteDevice;
use App\Events\NotificationEvents\DeviceNotifications;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;


class Device extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'imei', 'code', 'client_id', 'user_id', 'client_priority', 'manager_priority', 'info', 'problem', 'cost_to_client', 'cost_to_customer', 'fix_steps', 'status', 'client_approval', 'date_receipt', 'customer_id', 'Expected_date_of_delivery', 'deliver_to_client', 'deliver_to_customer', 'repaired_in_center', 'at_work'];
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
            $usersWithDevicesCount = User::withCount('devices')->where('at_work', true)->whereHas('rule', function($query) { $query->where('name', RuleNames::Technician); })->get();
            if ($usersWithDevicesCount) {
                $minDevicesCount = $usersWithDevicesCount->min('devices_count');
                $userWithMinDevicesCount = $usersWithDevicesCount->where('devices_count', $minDevicesCount)->shuffle()->first();
                $device->user_id = $userWithMinDevicesCount->id;
            }
        });

        static::deleted(static function ($device) {
            $clientId = $device->client_id;

            $devicesToUpdate = self::where('client_id', $clientId)->where('client_priority', '>', $device->client_priority)->get();

            foreach ($devicesToUpdate as $deviceToUpdate) {
                $deviceToUpdate->update(['client_priority' => $deviceToUpdate->client_priority - 1]);
            }
        });
        static::updating(function ($device) {
            if ($device->isDirty('client_approval')) {
                event(new ClientApproval($device));
            }
            if ($device->isDirty('deliver_to_client') || $device->isDirty('deliver_to_customer')) {
                event(new DeleteDevice($device));
            }
            if ($device->isDirty('status')) {
                event(new DeviceNotifications($device));
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
