<?php

namespace App\Models\School\Student\Results\Cumulative;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CumulativeResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'pid','session_pid','arm_pid','student_pid','school_pid',
        'principal_comment','teacher_comment','portal_comment'
    ];
}
