<?php

namespace App\Models\School\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'reg_number', 'user_pid', 'pid', 'type', 'school_pid', 'status',
        'passport', 'address', 'date', 'title', 'fullname',
        'admitted_class', 'current_session_pid', 'address', 'religion', 'session_pid','parent_pid',
        'current_class_pid', 'admitted_term', 'admitted_session_pid','gender'
    ];


    public function setStudentRegNumber($value){
        $this->attributes['reg_number'] = strtoupper($value);
    }
}
