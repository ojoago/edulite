<?php

namespace App\Models\School\Framework\Session;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveSession extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','session_pid','note'
    ];
}
