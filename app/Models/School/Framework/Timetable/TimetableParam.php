<?php

namespace App\Models\School\Framework\Timetable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimetableParam extends Model
{
    use HasFactory;
    protected $fillable = [
        'arm_pid','pid','term_pid','school_pid','session_pid'
    ];
}
