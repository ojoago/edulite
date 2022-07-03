<?php

namespace App\Models\School\Framework\Grade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeKey extends Model
{
    use HasFactory;
    protected $fillable = [
        'grade_pid','title','grade','grade_point','min_score',
        'max_score','color','pid', 'school_pid'
    ];
}
