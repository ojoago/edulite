<?php

namespace App\Models\School\Student\Result;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClassScoreParam extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','teacher_pid','session_pid','term_pid','arm_pid','pid'
    ];
}