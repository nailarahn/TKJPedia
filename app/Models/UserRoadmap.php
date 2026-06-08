<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRoadmap extends Model
{
    protected $fillable = [
        'user_id', 'roadmap_id', 'progress', 'status',
        'started_at', 'completed_at',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo     { return $this->belongsTo(User::class); }
    public function roadmap(): BelongsTo  { return $this->belongsTo(Roadmap::class); }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'active'    => 'Sedang Belajar',
            'completed' => 'Selesai',
            'paused'    => 'Dijeda',
            default     => $this->status,
        };
    }
}