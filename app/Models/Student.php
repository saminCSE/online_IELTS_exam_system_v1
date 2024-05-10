<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'phone',
        'identity_no',
        'candidate_id',
    ];
    
    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = Hash::make($password);
    // }
}
