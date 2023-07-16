<?php

namespace App\Models\School\Framework\Timetable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timetable extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_pid','param_pid','subject_pid','exam_date','exam_time'
    ];
    // h:i A
    public function examTime(): Attribute
    {
        return new Attribute(
            // get: fn ($value) => formatDate($value),
            set: fn ($value) => date('h:i A', strtotime($value))
        );
    }
}
