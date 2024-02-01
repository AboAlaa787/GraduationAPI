<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Device extends Model
{
    use HasFactory;
    protected $fillable=[
        'model',
        'imei',
        'client_id',
        'user_id',
        'client_piority',
        'manager_piority',
        'info',
        'problem',
        'cost',
        'fix_steps',
        'status',
        'client_approval',
        'center_id',
        'date_receipt'
    ];

    public function client():HasOne
    {
        return $this->hasOne(Client::class);
    }
    public function user():HasOne
    {
        return $this->hasOne(User::class);
    }
    public function center():HasOne
    {
        return $this->hasOne(Center::class);
    }
}
