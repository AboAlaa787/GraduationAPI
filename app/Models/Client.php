<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'center_id',
        'rule_id',
        'center_name',
        'phone',
        'devices_count',
        'user_name',
        'password',
        'address',
    ];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function devices_completed(): HasMany
    {
        return $this->hasMany(DeviceCompleted::class);
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission_user::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function rule(): HasOne
    {
        return $this->hasOne(Rule::class);
    }

    public function center(): HasOne
    {
        return $this->hasOne(Center::class);
    }
}
