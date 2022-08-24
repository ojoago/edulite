<?php

namespace App\Models\School\Student\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentScoreSheet extends Model
{
    use HasFactory;
    protected $fillable = [
        'score_param_pid','student_pid','ca_type_pid','score','school_pid'
    ];
}
