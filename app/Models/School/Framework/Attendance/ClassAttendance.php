<?php

namespace App\Models\School\Framework\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassAttendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'attendance_pid','school_pid','pid','term_pid','session_pid',
        'category_pid','arm_pid','class_pid','staff_pid'
    ];
}
