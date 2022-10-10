<?php

namespace App\Models\School\Framework\Psychomotor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychomotorBase extends Model
{
    use HasFactory;
    protected $fillable = [
        'psychomotor','obtainable_score','description','school_pid','pid','status','staff_pid'
    ];

    public function setPsychomotorAttribute($value){
        $this->attributes['psychomotor'] = strtoupper($value);
    }

    public function baseKey(){
        return $this->hasMany(PsychomotorKey::class,'psychomotor_pid', 'pid');
    }
}
