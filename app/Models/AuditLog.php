<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'action', 'entity', 'entity_id', 'timestamp'];
    protected $casts = ['timestamp' => 'datetime'];

    /**
     * Get the user associated with this audit log
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
