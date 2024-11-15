<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','user_pid','pid','role','status'
    ];
}
