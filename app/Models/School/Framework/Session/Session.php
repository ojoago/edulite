<?php

namespace App\Models\School\Framework\Session;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $fillable = [
        'pid','session','staff_pid','school_pid'
    ];
}
