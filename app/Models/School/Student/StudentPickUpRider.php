<?php

namespace App\Models\School\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPickUpRider extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','student_pid','rider_pid','note','status', 'staff_pid'//
    ];
}
