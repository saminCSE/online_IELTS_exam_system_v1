<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionModel extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $fillable = [
        'question_plans_id',
        'question_sets_id',
        'title',
        'question_type',
        'correct_answer',
        'group_id',
        'is_active',
    ];
}
