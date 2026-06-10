<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'stage_id',
        'score',
        'correct_count',
        'total_questions',
        'is_passed',
        'answers',
        'completed_at',
    ];

    protected $casts = [
        'answers'      => 'array',  // otomatis decode JSON jadi array
        'is_passed'    => 'boolean',
        'completed_at' => 'datetime',
    ];

    // Attempt ini milik user mana
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Attempt ini untuk quiz mana
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Attempt ini untuk stage mana
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    // Helper: tampilkan skor dalam format "8/10"
    public function getScoreLabel(): string
    {
        return "{$this->correct_count}/{$this->total_questions}";
    }
}