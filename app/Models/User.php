<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
    'name', 'username', 'email', 'password', 'role', 'avatar', 'jurusan', 'foto',
    'xp', 'streak_days', 'last_active_date',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
    'email_verified_at'  => 'datetime',
    'password'           => 'hashed',
    'last_active_date'   => 'date',
    ];

    // ── RELATIONS ──────────────────────────────────────
    public function userRoadmaps(): HasMany
    {
        return $this->hasMany(UserRoadmap::class);
    }

    public function enrolledRoadmaps(): BelongsToMany
    {
        return $this->belongsToMany(Roadmap::class, 'user_roadmaps')
                    ->withPivot('progress', 'status', 'started_at', 'completed_at')
                    ->withTimestamps();
    }

    public function userStages(): HasMany
    {
        return $this->hasMany(UserStage::class);
    }

    public function completedStages(): HasMany
    {
        return $this->hasMany(UserStage::class)->where('is_completed', true);
    }

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    public function activeTargets(): HasMany
    {
        return $this->hasMany(Target::class)->where('status', 'active');
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withPivot('earned_at')
                    ->withTimestamps();
    }

    public function learningLogs(): HasMany
    {
        return $this->hasMany(LearningLog::class);
    }

    // ── HELPERS ────────────────────────────────────────
    public function getRoleLabel(): string
    {
        return match($this->role) {
            'admin'   => 'Admin',
            'teacher' => 'Guru',
            default   => 'Pelajar',
        };
    }

    public function getTotalLearningHours(): float
    {
        $minutes = $this->learningLogs()->sum('duration_minutes');
        return round($minutes / 60, 1);
    }

    public function getStreakDays(): int
    {
        $logs = $this->learningLogs()
                     ->selectRaw('DATE(log_date) as date')
                     ->distinct()
                     ->orderByDesc('date')
                     ->pluck('date');

        $streak = 0;
        $today  = now()->toDateString();

        foreach ($logs as $i => $date) {
            $expected = now()->subDays($i)->toDateString();
            if ($date === $expected) $streak++;
            else break;
        }

        return $streak;
    }

    public function getTotalProgressPercent(): int
    {
        $roadmaps = $this->userRoadmaps;
        if ($roadmaps->isEmpty()) return 0;
        return (int) round($roadmaps->avg('progress'));
    }
}
