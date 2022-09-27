<?php

namespace App\Models\School\Framework\Timetable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','param_pid','subject_pid','exam_date','exam_time'
    ];
}
