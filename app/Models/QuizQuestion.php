<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = ['stage_id', 'question', 'order'];

    public function choices()
    {
        return $this->hasMany(QuizChoice::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}