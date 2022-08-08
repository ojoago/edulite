<?php

namespace App\Models\School\Registration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolParent extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_pid','school_pid','pid','parent_image_path'
    ];
}
