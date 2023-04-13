<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professors extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullName',
        'overallRating',
        'school_id',
        'user_id'
    ];
}
