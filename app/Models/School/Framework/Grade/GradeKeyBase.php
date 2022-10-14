<?php

namespace App\Models\School\Framework\Grade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeKeyBase extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'grade', 'grade_point', 'min_score',
        'max_score', 'color', 'pid', 'school_pid', 'remark',  'class_pid'
    ];

    public function setGradeAttribute($value)
    {
        $this->attributes['grade'] = strtoupper(trim($value));
    }
}
