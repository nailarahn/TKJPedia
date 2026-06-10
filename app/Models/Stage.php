<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'roadmap_id', 'title', 'description', 'order',
        'estimated_minutes', 'type', 'content_url',
        'is_active', 'group_label', 'learning_points',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function roadmap(): BelongsTo { return $this->belongsTo(Roadmap::class); }
    public function userStages(): HasMany { return $this->hasMany(UserStage::class); }

    public function getTypeLabel(): string
    {
        return match($this->type) { 
            'video'    => 'Video Pembelajaran',
            'article'  => 'Artikel',
            'quiz'     => 'Kuis',
            'practice' => 'Praktek',
            default    => $this->type
        };
    }

    public function getYoutubeId(): ?string
    {
        if (!$this->content_url) return null;
        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([A-Za-z0-9_\-]{11})/',
            $this->content_url, $m
        );
        return $m[1] ?? null;
    }

    public function isYoutube(): bool
    {
        return $this->content_url &&
            (str_contains($this->content_url, 'youtube.com') || str_contains($this->content_url, 'youtu.be'));
    }

    public function getYoutubeEmbedUrl(): ?string
    {
        $id = $this->getYoutubeId();
        return $id ? "https://www.youtube.com/embed/{$id}?rel=0&modestbranding=1" : null;
    }

    public function isCompletedByUser(int $userId): bool
    {
        return $this->userStages()->where('user_id', $userId)->where('is_completed', true)->exists();
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);

    }
}