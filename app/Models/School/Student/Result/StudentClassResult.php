<?php

namespace App\Models\School\Student\Result;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClassResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','student_pid','total', 'class_param_pid', 
        'class_teacher_comment','principal_comment','portal_comment', 'teacher_comment_on', 'principal_comment_on' , 'portal_comment_on'
    ];
}
