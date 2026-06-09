<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizChoice extends Model
{
    protected $fillable = ['quiz_question_id', 'choice_text', 'is_correct'];
}