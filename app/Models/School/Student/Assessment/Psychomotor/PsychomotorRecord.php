<?php

namespace App\Models\School\Student\Assessment\Psychomotor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychomotorRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid', 'class_param_pid', 'student_pid', 'key_pid', 'score'
    ];
}
