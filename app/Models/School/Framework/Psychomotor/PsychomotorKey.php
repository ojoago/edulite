<?php

namespace App\Models\School\Framework\Psychomotor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychomotorKey extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','school_pid','psychomotor_pid','pid','max_score','status','staff_pid'
    ];

    public function setTitleAttribute($value){
        $this->attributes['title'] = strtoupper($value);
    }

    
}
