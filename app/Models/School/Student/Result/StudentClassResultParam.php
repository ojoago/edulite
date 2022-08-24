<?php

namespace App\Models\School\Student\Result;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClassResultParam extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','session_pid','term_pid','arm_pid','pid','principal_pid','class_teacher_pid', 'portal_pid'
    ];
}
