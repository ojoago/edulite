<?php

namespace App\Models\School\Student\Result;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTotal extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid', 'student_pid', 'class_param_pid', 'pid', 'subject_type',
        'total', 'seated', 'teacher_comment', 'subject_pid'
    ];
}
