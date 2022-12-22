<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'contentNews',
        'title',
        'startDate',
        'endDate',
        'imageUrl',
    ];

    protected $table = "news";
}
