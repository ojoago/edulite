<?php

namespace App\Models\School\Student\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_pid' ,'pid' , 'session_pid' , 'term_pid' , 'category_pid' , 'class_pid' , 'arm_pid' , 'subject_pid' , 'week' , 
        'period' , 'date' , 'type' , 'status' , 'path' , 'plan' , 'staff_pid'
    ];
}
