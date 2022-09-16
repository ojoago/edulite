<?php

namespace App\Models\School\Framework\Term;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveTermDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'term_pid','school_pid','begin','end','note','session_pid'
    ];
}
