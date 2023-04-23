<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessorApplications extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullName',
        'school_name',
        'difficulty',
        'subject_id',
        'school_id',
    ];
}
