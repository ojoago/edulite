<?php

namespace App\Models\School\Framework\Hire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolAdvert extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','pid','qualification','course','note','years','status','subjects','end_date','start_date','title'
    ];
}
