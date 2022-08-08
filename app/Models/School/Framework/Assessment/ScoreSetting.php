<?php

namespace App\Models\School\Framework\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','pid','score',
        'assessment_type_pid',//this is supossed to be assessment title
        'type','order', 
        'score_data_pid'// foreign key
    ];
}
