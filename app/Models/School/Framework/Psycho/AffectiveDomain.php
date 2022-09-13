<?php

namespace App\Models\School\Framework\Psycho;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffectiveDomain extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','school_pid','pid','max_score','status','staff_pid'
    ];
}
