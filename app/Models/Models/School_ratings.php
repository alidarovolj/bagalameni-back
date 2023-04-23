<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School_ratings extends Model
{
    use HasFactory;
    protected $fillable = [
        'review',
        'user_id',
        'school_id',
        'location_place',
        'happiness',
        'internet',
        'safety',
        'opportunities',
        'location',
        'reputation',
        'facilities',
        'social',
        'food',
        'overallRating',
        'clubs',
    ];
}
