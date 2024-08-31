<?php

namespace App\Models\School\Student\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'pid' , 'school_pid' ,'session_pid' , 'term_pid' , 'category_pid' , 'class_pid' , 'arm_pid' , 'staff_pid' , 'subject_pid' ,
        'week' , 'period' , 'date' , 'type' , 'status' , 'path' , 'note' ,
    ];
}
