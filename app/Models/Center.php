<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Center extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'address',
        'start_work',
        'end_work',
        'logo'
    ];
    protected $relations = [
        'users',
        'services',
        'clients',
        'orders',
        'devices',
        'completed_devices'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function completed_devices(): HasMany
    {
        return $this->hasMany(CompletedDevice::class);
    }
}
