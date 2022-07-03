<?php

namespace App\Models\School\Framework\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssesmentTitle extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'school_pid','title','category','description','pid','status','staff_pid'
    ];
}
