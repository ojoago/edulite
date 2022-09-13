<?php

namespace App\Models\School\Framework\Grade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolGrade extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','category_pid','session_pid','term_pid','class_pid','pid','class_arm_pid', 'staff_pid'
    ];

   
}
