<?php

namespace App\Models\School\Framework\Psycho;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychoGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_pid','pid','grade','score','staff_pid'
    ];
}
