<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompletedDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'imei',
        'client_name',
        'client_id',
        'user_name',
        'user_id',
        'info',
        'problem',
        'cost',
        'status',
        'center_name',
        'center_id',
        'fix_steps',
        'date_receipt',
        'date_delivery',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}