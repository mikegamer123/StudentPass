<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'imageUrl',
        'location',
        'discountedPrice',
        'originalPrice',
        'startDate',
        'endDate',
        'admin_id',
        'company_id',
    ];
}
