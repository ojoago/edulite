<?php

namespace App\Models\School\Framework\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','pid','score',
        'assessment_title_pid',
        'type','order', 
        'class_param_pid'// foreign key
    ];
}
