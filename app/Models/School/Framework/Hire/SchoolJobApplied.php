<?php

namespace App\Models\School\Framework\Hire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolJobApplied extends Model
{
    use HasFactory;
    protected $fillable = ['job_pid','user_pid'];
}
