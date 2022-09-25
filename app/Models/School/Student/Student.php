<?php

namespace App\Models\School\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'reg_number', 'user_pid', 'pid', 'type', 'school_pid', 'status',
        'passport', 'address', 'date', 'religion', 'title', 'fullname',
        'admitted_class', 'current_class', 'address', 'religion', 'session_pid','parent_pid',
        'current_session_pid', 'admitted_term'
    ];

}
