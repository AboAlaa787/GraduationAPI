<?php

namespace App\Models;

use App\Enums\RuleNames;
use App\Traits\FirebaseNotifiable;
use App\Traits\PermissionCheckTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use function PHPUnit\Framework\isEmpty;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,FirebaseNotifiable,PermissionCheckTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'rule_id',
        'center_id',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $relations = [
        'completed_devices',
        'devices',
        'permissions',
        'orders',
        'rule',
        'rule.permissions'
    ];

    protected array $searchAbleColumns = [
        'name',
        'last_name',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::deleting(static function ($user) {
            $userRule=$user->rule->name;
            //If technician has been deleted put his devices to another technician
            if (RuleNames::Technician->value==$userRule) {
                $userDevices = $user->devices;
                if ($userDevices->count() > 0) {
                    foreach ($userDevices as $userDevice) {
                        $usersWithDevicesCount = self::withCount('devices')->where('at_work', true)->where('id','!=',$user->id)->whereHas('rule', function ($query) {
                            $query->where('name', RuleNames::Technician);
                        })->get();
                        if (!isEmpty($usersWithDevicesCount)) {
                            $minDevicesCount = $usersWithDevicesCount->min('devices_count');
                            $userWithMinDevicesCount = $usersWithDevicesCount->where('devices_count', $minDevicesCount)->shuffle()->first();
                            $userDevice->user_id = $userWithMinDevicesCount->id;
                            $userDevice->save();
                        }
                    }
                }
            }elseif (RuleNames::Delivery->value==$userRule) {
                //If delivery has been deleted put his orders to another technician
                $userOrders = $user->orders()->where('deliver_to_user',false)->get();
                if ($userOrders->count() > 0) {
                    foreach ($userOrders as $userOrder) {
                        $newDelivery=self::getDelivery();
                        if (!is_null($newDelivery)) {
                            $userOrder->user_id = $newDelivery->id;
                            $userOrder->save();
                        }
                    }
                }
            }
        });
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function completed_devices(): HasMany
    {
        return $this->hasMany(CompletedDevice::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_users');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class);
    }

    public static function getDelivery(): ?User
    {
        $deliveriesWithDevicesCount = self::withCount('devices')->where('at_work', true)->whereHas('rule', function ($query) {
            $query->where('name', RuleNames::Delivery);
        })->get();
        if ($deliveriesWithDevicesCount) {
            $minDevicesCount = $deliveriesWithDevicesCount->min('devices_count');
            return $deliveriesWithDevicesCount->where('devices_count', $minDevicesCount)->shuffle()->first();
        }
        return null;
    }

    public function getSearchAbleColumns(): array
    {
        return $this->searchAbleColumns;
    }
}
