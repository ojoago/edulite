<?php

namespace App\Models\School\Student;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'reg_number', 'user_pid', 'pid', 'type', 'school_pid', 'status',
        'passport', 'address', 'date', 'title', 'fullname',
        'admitted_class', 'current_session_pid', 'address', 'religion', 'session_pid','parent_pid',
        'current_class_pid', 'admitted_term', 'admitted_session_pid','gender',
    ];



    protected function regNumber() : Attribute
    {
        return new Attribute(
            set: fn ($value) => strtoupper($value) 
        );
    }
    protected function fullname() : Attribute
    {
        return new Attribute(
            set: fn ($value) => ucwords($value) 
        );
    }

}
