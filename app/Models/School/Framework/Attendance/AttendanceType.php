<?php

namespace App\Models\School\Framework\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceType extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', //attendance title
        'pid','description','school_pid','staff_pid'
    ];

}
