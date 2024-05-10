<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamTypeModel extends Model
{
    use HasFactory;
    protected $table ='types';
    protected $fillable = [
        'title',
        'is_active',
    ];
}
