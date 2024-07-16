<?php

namespace App\Models\School\Student\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectScoreParam extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid', 'subject_teacher','class_param_pid', 
        'subject_pid', 'pid','subject_type', 'staff_pid', 'subject_name', 'subject_type_name' , 'subject_teacher_name', 'status'
    ];

}
