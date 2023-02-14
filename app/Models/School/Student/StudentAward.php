<?php

namespace App\Models\School\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAward extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_pid','arm_pid','term_pid','session_pid','award_pid'
    ];
}
