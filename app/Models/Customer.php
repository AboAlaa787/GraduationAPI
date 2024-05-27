<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = [
        'name',
        'last_name',
        'national_id',
        'client_id',
        'phone',
        'email',
        'devices_count',
    ];
    protected $relations=[
        'completed_devices',
        'devices',
        'client',
    ];

    protected array $searchAbleColumns = [
        'name',
        'last_name',
        'national_id',
    ];

    /**
     * Get the client that owns the customer.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function completed_devices(): HasMany
    {
        return $this->hasMany(CompletedDevice::class);
    }

    public function getSearchAbleColumns(): array
    {
        return $this->searchAbleColumns;
    }
}
