<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage_id',
        'title',
        'passing_score',
        'points_reward',
    ];

    // Satu quiz punya banyak soal
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    // Quiz milik satu stage
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    // Semua attempt yang pernah dikerjakan di quiz ini
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    // Attempt milik user tertentu
    public function userAttempts($userId)
    {
        return $this->attempts()->where('user_id', $userId);
    }

    // Cek apakah user sudah pernah lulus quiz ini
    public function isPassedByUser($userId): bool
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->where('is_passed', true)
            ->exists();
    }
}