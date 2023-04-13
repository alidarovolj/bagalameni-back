<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'overallRating',
        'user_id',
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
            'clubs',
    ];
}
