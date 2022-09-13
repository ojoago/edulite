<?php

namespace App\Models\School\Framework\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','record_pid','student_pid'
    ];
}
