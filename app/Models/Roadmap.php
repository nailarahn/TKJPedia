<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Roadmap extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'slug', 'level', 'category',
        'thumbnail', 'total_stages', 'estimated_hours',
        'is_active', 'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

        public function stages(): HasMany
    {
        return $this->hasMany(Stage::class)->orderBy('order');
    }

    public function userRoadmaps(): HasMany
    {
        return $this->hasMany(UserRoadmap::class);
    }

    public function enrolledUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roadmaps')
                    ->withPivot('progress', 'status', 'started_at', 'completed_at')
                    ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function getLevelLabel(): string
    {
        return match($this->level) {
            'beginner'     => '🟢 Pemula',
            'intermediate' => '🟡 Menengah',
            'advanced'     => '🔴 Lanjut',
            default        => $this->level,
        };
    }

    public function getCategoryLabel(): string
    {
        return match($this->category) {
            'networking'   => '🌐 Jaringan',
            'programming'  => '💻 Pemrograman',
            'server'       => '🖥️ Server',
            default        => $this->category,
        };
    }

    public function getUserProgress(int $userId): int
    {
        $enrollment = $this->userRoadmaps()->where('user_id', $userId)->first();
        return $enrollment ? $enrollment->progress : 0;
    }

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }
}
