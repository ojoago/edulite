<?php

namespace App\Models\School\Framework\Psychomotor;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychomotorBase extends Model
{
    use HasFactory;
    protected $fillable = [
        'psychomotor','obtainable_score','description','school_pid','pid','status','staff_pid', 'category_pid', 'grade'
    ];

    public function psychomotor() : Attribute
    {
        return new Attribute(
            set:fn ($value) => strtoupper($value) 
        );
    }

    public function baseKey(){
        return $this->hasMany(PsychomotorKey::class,'psychomotor_pid', 'pid');
    }
}
