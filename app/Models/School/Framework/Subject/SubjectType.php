<?php

namespace App\Models\School\Framework\Subject;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectType extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject_type','description','school_pid','pid','staff_pid'
    ];
}
