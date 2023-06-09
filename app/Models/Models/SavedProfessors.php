<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedProfessors extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'professor_name',
        'professor_id',
    ];
}
