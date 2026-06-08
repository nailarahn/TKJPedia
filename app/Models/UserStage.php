<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserStage extends Model
{
    protected $fillable = [
        'user_id', 'stage_id', 'roadmap_id',
        'is_completed', 'completed_at', 'time_spent_minutes',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo   { return $this->belongsTo(User::class); }
    public function stage(): BelongsTo  { return $this->belongsTo(Stage::class); }
    public function roadmap(): BelongsTo { return $this->belongsTo(Roadmap::class); }
}