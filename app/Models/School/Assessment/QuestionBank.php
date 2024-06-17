<?php

namespace App\Models\School\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','class_param_pid','pid','note','mark','type','category','status','start_date', 'recordable',
        'end_date','start_time','end_time','teacher_pid','subject_pid','access', 'title', 'same_mark' , 'assessment_type'
    ];
}
