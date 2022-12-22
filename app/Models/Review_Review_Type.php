<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review_Review_Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'reviewType_id',
    ];

    protected $table = "reviews_review_types";
}
