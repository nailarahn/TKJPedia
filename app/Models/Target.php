<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'roadmap_id', 'name', 'description', 'type',
        'target_value', 'current_value', 'start_date', 'deadline', 'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'deadline'   => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function roadmap(): BelongsTo
    {
        return $this->belongsTo(Roadmap::class);
    }

    public function getProgressPercent(): int
    {
        if ($this->target_value <= 0) return 0;
        return min(100, (int) round(($this->current_value / $this->target_value) * 100));
    }

    public function getStatusLabel(): string
    {
        return match($this->status) { 
            'active' => '🔵 Aktif',
            'done'   => '✅ Selesai',
            'failed' => '❌ Gagal',
            'default'  => $this->status,
        }; 
    }

    public function checkAndUpdateStatus(): void
    {
        if ($this->current_value >= $this->target_value && $this->status === 'active') {
            $this->update(['status' => 'done']);
        }
    }
}