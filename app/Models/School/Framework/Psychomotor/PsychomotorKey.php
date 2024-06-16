<?php

namespace App\Models\School\Framework\Psychomotor;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychomotorKey extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','school_pid','psychomotor_pid','pid','max_score','status','staff_pid'
    ];

    protected function title(): Attribute
    {
        return new Attribute(
            set:fn($value) => strtoupper($value), 
        );
    }
    
}
