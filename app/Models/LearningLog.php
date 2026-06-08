<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearningLog extends Model
{
    protected $fillable = [
        'user_id', 'stage_id', 'roadmap_id',
        'duration_minutes', 'log_date', 'activity',
    ];

    protected $casts = [
        'log_date' => 'date',
    ];

    public function user(): BelongsTo    { return $this->belongsTo(User::class); }
    public function stage(): BelongsTo   { return $this->belongsTo(Stage::class); }
    public function roadmap(): BelongsTo { return $this->belongsTo(Roadmap::class); }
}
