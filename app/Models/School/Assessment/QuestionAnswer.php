<?php

namespace App\Models\School\Assessment;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','student_pid','question_pid','answer','remark','path','status','mark'
    ];
}
