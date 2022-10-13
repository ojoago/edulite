<?php

namespace App\Models\School\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_pid','session_pid','arm_pid','school_pid','date','staff_pid'
    ];
    // comment to push
}
