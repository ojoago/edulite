<?php

namespace App\Models\School\Framework\Fees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeItemAmount extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','config_pid','amount','arm_pid','pid','term_pid','session_pid'
    ];
}
