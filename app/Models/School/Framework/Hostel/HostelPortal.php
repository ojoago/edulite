<?php

namespace App\Models\School\Framework\Hostel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelPortal extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','session_pid','term_pid','hostel_pid','portal_pid','staff_pid'
    ];
}
