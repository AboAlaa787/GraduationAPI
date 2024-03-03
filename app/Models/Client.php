<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'rule_id',
        'center_name',
        'phone',
        'devices_count',
        'email',
        'password',
        'address',
    ];

    protected $relations=[
        'completed_devices',
        'devices',
        'permissions',
        'orders',
        'rule',
        'customers',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

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
        return $this->belongsToMany(Permission::class, 'permission_clients');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class);
    }

     /**
     * Get the customers for the client.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
