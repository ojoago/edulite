<?php

namespace App\Models\School\Framework\Hostel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelStudent extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid', 'hostel_pid', 'student_pid', 'staff_pid'
    ];
    

}
