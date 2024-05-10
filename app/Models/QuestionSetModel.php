<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSetModel extends Model
{
    use HasFactory;
    protected $table ='question_sets';
    protected $fillable = [
        'type_id',
        'skills_id',
        'title_id',
        'exam_taken',
        'total_part',
        'exam_duration',
        'total_question',
        'part_info',
        'audio_file',
        'is_active',
    ];
    
}
