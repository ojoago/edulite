<?php

namespace App\Models\School\Framework\Result;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_pid' , 'category_pid' , 'class_teacher' , 'head_teacher' , 'chart' , 'title' , 'settings',
        'template' , 'grading' , 'subject_position', 'subject_teacher', 'base_dir' , 'sub_dir' , 'file_name', 'student_name'
    ];

    protected function subDir(): Attribute
    {
        return new Attribute(
            set:fn($val) => strtolower($val)
        );
    }

}
