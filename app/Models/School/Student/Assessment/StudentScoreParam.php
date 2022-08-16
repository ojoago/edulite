<?php

namespace App\Models\School\Student\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentScoreParam extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid', 'teacher_pid',  'session_pid', 'term_pid',
        'subject_pid', 'pid', 'arm_pid', 'class_pid', 
        'subject_type', 'category_pid','status',
    ];

}
