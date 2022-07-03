<?php

namespace App\Models\School\Framework;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentType extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject','description','school_pid','pid','staff_pid'
    ];
}
