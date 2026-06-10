<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
        'order',
    ];

    // Soal ini milik quiz mana
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Helper: ambil semua opsi sebagai array
    public function getOptionsArray(): array
    {
        return [
            'a' => $this->option_a,
            'b' => $this->option_b,
            'c' => $this->option_c,
            'd' => $this->option_d,
        ];
    }

    // Helper: cek apakah jawaban yang diberikan benar
    public function isCorrect(string $answer): bool
    {
        return strtolower($answer) === strtolower($this->correct_answer);
    }
}