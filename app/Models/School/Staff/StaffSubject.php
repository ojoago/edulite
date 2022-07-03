<?php

namespace App\Models\School\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSubject extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','staff_pid','arm_pid','session_pid','term_pid','pid','subject_pid'
    ];
}
