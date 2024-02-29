<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_id',
        'user_id',
    ];
    protected $relations=[
        'users',
        'clients',
        'rules',
    ];
    /**
     * Get the users associated with the model.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'permission_users');
    }
    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'permission_clients');
    }
    public function rules(): BelongsToMany
    {
        return $this->belongsToMany(Rule::class, 'permission_rules');
    }
}
