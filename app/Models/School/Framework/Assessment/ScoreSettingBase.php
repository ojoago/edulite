<?php

namespace App\Models\School\Framework\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreSettingBase extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid', 'pid', 'score',
        'assessment_title_pid', //this is supossed to be assessment title
        'type', 'order',
        'class_pid','arm_pid' // foreign key
    ];
}
