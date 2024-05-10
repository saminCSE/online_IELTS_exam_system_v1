<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOptionModel extends Model
{
    use HasFactory;
    protected $table ='question_options';
    protected $fillable = [
        'questions_id',
        'title',
        'correct_answer',
    ];
}
