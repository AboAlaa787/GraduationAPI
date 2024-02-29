<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission_rule extends Model
{
    use HasFactory;
    protected $fillable = [
        'permission_id',
        'rule_id',
    ];

    protected $relations=[
        'permission',
        'rule',
    ];

    /**
     * Get the permission associated with the model.
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
    /**
     * Get the user associated with the model.
     */
    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class);
    }
}
