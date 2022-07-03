<?php

namespace App\Models\School\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'staff_pid','arm_pid','session_pid','term_pid','pid','school_pid'
    ];
}
