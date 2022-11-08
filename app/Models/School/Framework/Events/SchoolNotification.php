<?php

namespace App\Models\School\Framework\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolNotification extends Model
{
    use HasFactory;
    protected $fillable = [
        'begin','end','message','type','school_pid','term_pid','session_pid','pid'
    ];
}
