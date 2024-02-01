<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_id',
        'user_id',
    ];

    /**
     * Get the users associated with the model.
     */
    public function users(): HasMany
    {
        return $this->hasMany(Permission_user::class);
    }
}
