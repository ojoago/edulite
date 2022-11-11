<?php

namespace App\Models\School\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffRoleHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','term_pid','session_pid','role','staff_pid','creator'
    ];
}
