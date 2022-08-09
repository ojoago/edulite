<?php

namespace App\Models\School\Framework\Class;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassArmSubject extends Model
{
    use HasFactory;
    protected $fillable = [
        'session_pid','subject_pid','arm_pid','status','swap_subject_pid','school_pid','staff_pid','pid'
    ];
}
