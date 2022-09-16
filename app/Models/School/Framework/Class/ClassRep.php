<?php

namespace App\Models\School\Framework\Class;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRep extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','session_pid','term_pid','arm_pid','student_pid','staff_pid'
    ];
}
