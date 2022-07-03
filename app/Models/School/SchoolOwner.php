<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolOwner extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','user_pid'
    ];
}
