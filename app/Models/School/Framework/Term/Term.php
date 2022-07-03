<?php

namespace App\Models\School\Framework\Term;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
    protected $fillable = [
        'pid','school_pid','description','term'
    ];
}
