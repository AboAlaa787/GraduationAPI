<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'email',
        'password',
        'address',
    ];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function devices_completed(): HasMany
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

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
