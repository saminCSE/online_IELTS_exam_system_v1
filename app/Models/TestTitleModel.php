<?php

namespace App\Models;

use App\Models\QuestionSetModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestTitleModel extends Model
{
    use HasFactory;
    protected $table = 'test_title';
    protected $fillable = [
        'title',
    ];

    public function questionSets()
    {
        return $this->hasMany(QuestionSetModel::class, 'title_id');
    }
}
