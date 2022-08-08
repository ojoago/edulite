<?php

namespace App\Models\School\Framework\Subject;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject','description','school_pid','pid','subject_type_pid','staff_pid','category_pid'
    ];

}
