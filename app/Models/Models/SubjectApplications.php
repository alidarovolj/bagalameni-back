<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectApplications extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'user_id'
    ];
}
