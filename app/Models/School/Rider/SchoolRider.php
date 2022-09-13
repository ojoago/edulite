<?php

namespace App\Models\School\Rider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolRider extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_pid','school_pid','pid','status','rider_id','passport',
    ];
}
