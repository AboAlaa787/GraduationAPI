<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function orders()
    {
        return $this->hasMany(User::class);
    }

    public function deveices()
    {
        return $this->hasMany(Device::class);
    }

    public function devices_completed()
    {
        return $this->hasMany(DeviceCompleted::class);
    }
}
