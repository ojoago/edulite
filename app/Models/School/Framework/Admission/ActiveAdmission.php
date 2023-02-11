<?php

namespace App\Models\School\Framework\Admission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveAdmission extends Model
{
    use HasFactory;
    protected $fillable = ['admission_pid','school_pid'];
}
