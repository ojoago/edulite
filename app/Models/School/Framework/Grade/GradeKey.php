<?php

namespace App\Models\School\Framework\Grade;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeKey extends Model
{
    use HasFactory;
    protected $fillable = [
        'grade_pid','title','grade','grade_point','min_score',
        'max_score','color','pid', 'school_pid','remark','term_pid','class_pid','session_pid'
    ];

    // public function setGradeAttribute($value)
    // {
    //     $this->attributes['grade'] = strtoupper(trim($value));
    // }

    public function grade() : Attribute
    {
        return new Attribute(
            set:fn ($value) => strtoupper(trim($value))
        );
    }
    public function title() : Attribute
    {
        return new Attribute(
            set:fn ($value) => strtoupper($value)
        );
    }
}
