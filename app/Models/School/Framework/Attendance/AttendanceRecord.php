<?php

namespace App\Models\School\Framework\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'pid','term_pid','session_pid','date','arm_pid','school_pid', 'staff_pid','note'
    ];
}
