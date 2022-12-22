<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Study_Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'college_id',
        'description',
    ];

    protected  $table = "study_programs";
}
