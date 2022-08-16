<?php

namespace App\Models\School\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSubject extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','teacher_pid', 'arm_subject_pid',
        'session_pid','term_pid','pid', 'staff_pid'
    ];
}
