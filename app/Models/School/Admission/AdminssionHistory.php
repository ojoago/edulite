<?php

namespace App\Models\School\Admission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminssionHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','admission_number','category_pid','class_pid','arm_pid','admitted_arm_pid',
        'session_pid','term_pid','staff_pid','contact_person','contact_gsm','contact_email', 'student_pid'
    ];
}
