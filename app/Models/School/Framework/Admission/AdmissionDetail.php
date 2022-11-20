<?php

namespace App\Models\School\Framework\Admission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'from','to','session_pid','pid','creator','school_pid'
    ];
}
