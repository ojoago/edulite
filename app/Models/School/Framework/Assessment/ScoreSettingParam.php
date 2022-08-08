<?php

namespace App\Models\School\Framework\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreSettingParam extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid', 'pid', 'session_pid', 'class_pid', 'term_pid',
        'category_pid', 'status', 'staff_pid'
    ];

}
