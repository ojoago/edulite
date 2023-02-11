<?php

namespace App\Models\School\Framework\Class;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwapClassHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','student_pid','new_class','previus_class','session_pid','term_pid','created_by'
    ];
}
