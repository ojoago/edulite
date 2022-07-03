<?php

namespace App\Models\School\Framework\Class;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $fillable = [
        'pid','staff_pid','class','category_pid','school_pid'
    ];
}
