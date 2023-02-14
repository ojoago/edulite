<?php

namespace App\Models\School\Framework\Result;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwardKey extends Model
{
    use HasFactory;
    protected $fillable = [
        'award','pid','school_pid','status'
    ];

    public function setAwardAttribute($value){
        $this->attributes['award'] = trim(strtoupper($value));
    }
}
