<?php

namespace App\Models\School\Framework\Assessment;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentTitle extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'school_pid','title','category','description','pid','status','staff_pid'
    ];

    protected function title() : Attribute
    {
        return new Attribute(
            set:fn ($value) => strtoupper($value)
        );
    }

}
