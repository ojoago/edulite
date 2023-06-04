<?php

namespace App\Models\School\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAccess extends Model
{
    use HasFactory;
    protected $fillable = ['staff_pid','access','school_pid'];
}
