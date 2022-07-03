<?php

namespace App\Models\School\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolStaff extends Model
{
    use HasFactory;
    protected $fillable = ['school_pid','user_pid','pid','role_id','staff_id'];
}
