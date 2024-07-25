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
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


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
        'date_receipt_from_customer',
        'customer_id',
        'Expected_date_of_delivery',
        'deliver_to_client',
        'deliver_to_customer',
        'repaired_in_center',
        'at_work',
        'client_date_warranty',
        'customer_date_warranty',
        'customer_complaint'
    ];
    protected $relations = ['client', 'user', 'customer', 'orders',];

    protected array $searchAbleColumns = [
        'model',
        'imei',
        'code',
        'problem',
        'status',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(static function ($device) {
            $device->date_receipt_from_customer = now();
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
            if ($device->repaired_in_center) {
                $usersWithDevicesCount = User::withCount('devices')->where('at_work', true)->whereHas('rule', function ($query) {
                    $query->where('name', RuleNames::Technician);
                })->get();
                if ($usersWithDevicesCount->count() > 0) {
                    $minDevicesCount = $usersWithDevicesCount->min('devices_count');
                    $userWithMinDevicesCount = $usersWithDevicesCount->where('devices_count', $minDevicesCount)->shuffle()->first();
                    $device->user_id = $userWithMinDevicesCount->id;
                }
            }
        });
        static::deleting(static function ($device) {
            $clientId = $device->client_id;
            $client = Client::find($clientId);
            $alreadyExists = CompletedDevice::where('code', $device->code)->exists();
            if (!$alreadyExists && $client) {
                $client->decrement('devices_count');
            }
        });
        static::deleted(static function ($device) {
            $clientId = $device->client_id;

            $devicesToUpdate = self::where('client_id', $clientId)->where('client_priority', '>', $device->client_priority)->get();

            foreach ($devicesToUpdate as $deviceToUpdate) {
                $deviceToUpdate->update(['client_priority' => $deviceToUpdate->client_priority - 1]);
            }
        });
        static::updated(function ($device) {
            if ($device->isDirty('deliver_to_client')) {
                if (!CompletedDevice::where('code', $device->code)->exists()) {
                    $completedDevice = $device->toArray();
                    $completedDevice['client_name'] = $device->client?->name;
                    $completedDevice['user_name'] = $device->user?->name ?? 'فني صيانة';
                    $completedDevice = CompletedDevice::create($completedDevice);
                    if ($completedDevice) {
                        $device->client->decrement('devices_count');
                    }
                }
                $dateReceipt = Carbon::parse($device->date_receipt);
                $difference = now()->diff($dateReceipt);
                $diffString = ($difference->days > 0 ? $difference->days . ' days and ' : '') . $difference->h . ' hours';
                $ser = Service::where('name', $device->problem)->where('device_model', $device->model)->first();
                if ($ser === null) {
                    if ($device->problem != null && $device->cost_to_client != null) {
                        $ser = Service::create([
                            'name' => $device->problem,
                            'price' => $device->cost_to_client,
                            'time_required' => $diffString,
                            'device_model' => $device->model
                        ]);
                    }
                } else {
                    if ($device->cost_to_client != null) {
                        $ser->update([
                            'price' => $device->cost_to_client,
                            'time_required' => $diffString,
                        ]);
                    }
                }
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
            if($device->customer!=null){
                $device->customer->increment('devices_count');
            }
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

    public function getSearchAbleColumns(): array
    {
        return $this->searchAbleColumns;
    }
}
