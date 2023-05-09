<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    use HasFactory;
    protected $fillable = [
        'overall',
        'difficulty',
        'repeat',
        'grade',
        'review',
        'professor_id',
        'subject_id',
        'user_id',
        'tags'
    ];

    protected $casts = [
        'tags' => 'array',
    ];
}
