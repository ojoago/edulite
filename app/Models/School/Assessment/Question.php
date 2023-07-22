<?php

namespace App\Models\School\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','pid','bank_pid','question','path','mark','type','options'
    ];
}
