<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_College extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'college_id',
        'educationStartYear',
        'studyProgramId',
    ];

    protected  $table = "user_college";
}
