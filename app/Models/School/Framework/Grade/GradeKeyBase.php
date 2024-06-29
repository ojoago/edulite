<?php

namespace App\Models\School\Framework\Grade;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeKeyBase extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'grade', 'grade_point', 'min_score',
        'max_score', 'color', 'pid', 'school_pid', 'remark',  'class_pid'
    ];


    protected function title(): Attribute
    {
        return new Attribute(
            set:fn($value) => strtoupper($value),
        );
    }

   
}
