<?php

namespace App\Models\School\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAttendanceConfig extends Model
{
    use HasFactory;

    protected $fillable =[
        'school_pid' , 'clock_in_begin' , 'clock_in_end' , 'late_time' , 'office_resume_time' , 'office_close_time' , 'latitude' , 'longitude' , 'fence_radius' , 'note' , 'created_by' , 'area' ,
    ];
}
